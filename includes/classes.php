<?php

class Bd
{
    protected PDO $conexao;
    protected $opcoes = [
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES      => false
    ];

    public function __construct()
    {
        if (file_exists('../htconfigs/meu_conf.php')) {
            $configs = '../htconfigs/meu_conf.php';
        } elseif (file_exists('../../htconfigs/meu_conf.php')) {
            $configs = '../../htconfigs/meu_conf.php';
        } elseif (file_exists('../../../htconfigs/meu_conf.php')) {
            $configs = '../../../htconfigs/meu_conf.php';
        } elseif (file_exists('../../../../htconfigs/meu_conf.php')) {
            $configs = '../../../../htconfigs/meu_conf.php';
        } else {
            $configs = '../../../../../htconfigs/meu_conf.php';
        }
        require($configs);
        $dsn = "mysql:host=$server;dbname=$bd;charset=utf8mb4";
        $opcoes = $this->opcoes;
        try {
            $con = new PDO($dsn, $user, $pass, $opcoes);
            $this->conexao = $con;
        } catch (PDOException $e) {
            die("Morre Mother Foca: " . $e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->conexao;
    }
}
class Login
{
    private $conexao;

    public function __construct()
    {
        $pdo = new Bd;
        $con = $pdo->getPDO();
        $this->conexao = $con;
        unset($pdo);
    }

    public function login1()
    {
        $msgLog = 0;
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fuser'])) {
            // passar p variaveis locais os dados do form de login
            $user = $_POST['fuser'];
            $pass = $_POST['fpass'];

            //pedir à BD a info do user preenchido
            $sql = "SELECT * FROM users WHERE nome_u='$user'";
            $conexao = $this->conexao;
            $resultado = $conexao->query($sql);


            /* caso a BD tenha retornado algum registo... ou seja SE o utilizador foi reconhecido  */
            if ($resultado->rowCount() > 0) {
                $linha = $resultado->fetchAll();

                // guardar como var local a info retornada da BD: a password encriptada e o nivel de acesso
                $passBd = $linha[0]['pass_u'];
                $nivel = $linha[0]['nivel_u'];

                // Verificar se a pass preenchida corresponde à pass armazenada na BD
                if (password_verify($pass, $passBd)) {
                    $_SESSION['user'] = $user;
                    $_SESSION['nivel'] = $nivel;
                } else {
                    $msgLog = 8;
                }
            } else {
                $msgLog = 9;
            }
        }
        return $msgLog;
    }
    public function login2($msgLog = "")
    {

        // se já há dados do user na SESSION é pq já estamos logados (escondemos o formulário)
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $msgLog = "<p class='logP2'>Welcome $user  <a class='logP3' href='Logout.php'>Logout</a></p>";
            echo $msgLog;
        } else {  // se não há SESSION então temos de nos logar (mostramos o formulário e a linha do msgLog: q pode trazer um erro ou o vazio "") 
?>
            <form id="formreg" method="POST" action="register_form.php">
                <input type="text" class="logInput" name="fuser" placeholder="username" required>

                <input type="password" class="logInput" name="fpass" placeholder="password" required>

                <input type="submit" name="action" value="Login" class="input_b1">

                <?= $msgLog ?>
                <input type="submit" name="action" value="Register" class="input_b1">
            </form>
<?php
        }
    }
}
class User
{
    private $conexao;

    public function __construct()
    {
        $pdo = new Bd;
        $con = $pdo->getPDO();
        $this->conexao = $con;
        unset($pdo);
    }
    public function user_verify($username)
    {
        //$username=$_POST['$username'];
        $sql = "SELECT *FROM users WHERE nome_u=?";
        $conexao = $this->conexao;
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$username]);
        $dados = $resultado->fetchAll();
        if (!empty($dados)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function adduser($username, $password)
    {
        //$username=$_POST['$username'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $conexao = $this->conexao;
        $sql = "INSERT INTO users (nome_u,pass_u) VALUES (:username,:password)";
        $stmt = $conexao->prepare($sql);
        $resultado = $stmt->execute([$username, $password]);
        if ($resultado == TRUE) {
            header("location:index.php?alerta=6");
        } else {
            header("location:index.php?alerta=0");
        }
    }
}
class Champion
{
    private PDO $conexao;

    public function __construct()
    {
        $pdo = new Bd;
        $con = $pdo->getPDO();
        $this->conexao = $con;
        unset($pdo);
    }
    public function allfromchampions()
    {
        $sql = "SELECT *FROM champion ORDER BY nome_c ASC";
        $conexao = $this->conexao;
        $resultado = $conexao->query($sql);
        $dados = $resultado->fetchAll();

        foreach ($dados as $registo) {
            echo '<a class="caixinha" href="infochamp.php?idc=' . $registo["id_c"] . '"><div>';
            //$nChamp = clean($registo['nome_c']);
            if (file_exists('imagens/icons/' . $registo["id_c"] . '.jpg')) {
                echo '<img class="champImg" src="imagens/icons/' . $registo["id_c"] . '.jpg">';
            }
            echo '<p class= "tit5">' . $registo['nome_c'] . '</p> <br><br>';
            echo '</div></a>';
        }
    }
    public function infochamp()
    {
        $idc = $_GET['idc'];

        $sql = "SELECT champion.*, habilidadeschampion.id_h_hc as hc FROM champion LEFT JOIN habilidadeschampion ON champion.id_c=habilidadeschampion.id_c_hc WHERE id_c=?";
        //enviar a instrucao para a BD
        $conexao = $this->conexao;
        $resultado = $conexao->prepare($sql);
        $resultado->execute([$idc]);
        $dados = $resultado->fetchAll();
        //$nomes_habilidades=mostrahabilidades($conexao);


        echo '<div class="caixaimg">';
        // $nChamp = clean($dados['nome_c']);
        if (file_exists('imagens/champart/' . $dados[0]["id_c"] . '.jpg')) {
            echo '<img class="champImg" src="imagens/champart/' . $dados[0]["id_c"] . '.jpg">';
        }
        echo '</div>';

        echo '<div class="caixainfo">';
        echo '<br>';
        echo '<p class="tit5">' . $dados[0]['nome_c'] . '</p> <br><br>';
        echo '<p class="tit3">Role: </p>';
        echo '<p class="tit2">' . $dados[0]['role_c'] . '</p> <br><br>';
        echo '<p class="tit3">Difficulty: </p>';
        echo '<p class="tit2">' . $dados[0]['dif_c'] . '</p> <br><br>';
        echo '<p class="tit3">Description: </p>';
        echo '<p class="tit2">' . $dados[0]['des_c'] . '</p> <br><br>';
        echo '</div>';


        //$habilidades = explode(',', $registo['hc']); //variavel com array de todas habilidades do champ especifico
        if (!empty($dados[0]['hc'])) {
            $dd = $dados[0]['hc'];
            echo '<div class="caixahabilidades">'; //explode retorna array de strings, each of which is a substring of string formed by splitting it on boundaries formed by the string separator.

            $valores = explode(",", $dd);
            $sql = 'SELECT id_h,nome_h FROM habilidades WHERE id_h IN (' . trim(str_repeat(', ?', count($valores)), ', ') . ') ORDER BY ordem_h';
            //die($sql);
            //$sql = "SELECT id_h,nome_h FROM habilidades WHERE id_h IN ('$dd') order BY ordem_h";
            $conexao = $this->conexao;
            $resultado = $conexao->prepare($sql);
            $resultado->execute($valores);
            $h = $resultado->fetchAll();
            //$resultado = mysqli_query($conexao, $sql);
            //$h = mysqli_fetch_all($resultado);


            foreach ($h as $habilidade) {
                echo ' <img src="imagens/habilidades/' . $habilidade['id_h'] . '.png" title="' . $habilidade['nome_h'] . '" alt="' . $habilidade['id_h'] . '">&nbsp;'; //alt se img n existe escreve
            } //mostra imghabilidade com nome habilidade
            echo '</div>';
        }

        echo '</div>';
    }
    public function addchampion()
    {
        $sql = "SELECT nome_c FROM champion";
        $conexao = $this->conexao;
        $resultado = $conexao->query($sql);
        $listNomes = $resultado->fetchall();

        $listNomesArray = [];
        foreach ($listNomes as $l) {
            array_push($listNomesArray, $l['nome_c']);
        }

        $champion = $_POST['champion'];
        $role = $_POST['role'];
        $dif = $_POST['dif'];
        $des = $_POST['des'];


        if (!in_array($champion, $listNomesArray)) {

            if (!isset($_POST['hab_check'])) {
                $habilidade = "";
            } else {
                $habilidade = implode(',', $_POST['hab_check']); //implode separa 
            }
            $sql = "INSERT INTO champion (nome_c,role_c,dif_c,des_c) VALUES (?,?,?,?)";
            $stmt = $conexao->prepare($sql);
            $resultado = $stmt->execute([$champion, $role, $dif, $des]);
            //$q = mysqli_prepare($conexao, $sql);
            //mysqli_stmt_bind_param($q, "ssss", $champion, $role, $dif, $des);
            //$resultado = mysqli_stmt_execute($q);
            $id = $conexao->lastInsertId();
            //$id=mysqli_insert_id($conexao);
            $sql = "INSERT INTO habilidadeschampion(id_c_hc, id_h_hc) VALUES (?,?)";
            $stmt = $conexao->prepare($sql);
            $resultado = $stmt->execute([$id, $habilidade]);
            //$resultado = mysqli_query($conexao, $sql);
            return $id;
        } else {
            $fdb = 4;
            //header("location:index.php?alerta=" . $fdb);
        }
        return false;
    }
    public function uploadchampicons($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $file = $_FILES['fimage'];
            $fileName = $file['name'];
            $file_TmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            //$fileType = $file['type'];
            $fileExt = explode('.', $fileName);
            $fileActualExp = strtolower(end($fileExt)); //lowercased

            $allowed = array('jpg');
            if (in_array($fileActualExp, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 10000000) {
                        $fileDestination = 'imagens/icons/' . $id . '.jpg';
                        move_uploaded_file($file_TmpName, $fileDestination);
                        //header("Location:index.php?upload=Sucessfull");
                    } else {
                        echo "File is too big!";
                    }
                } else {
                    echo "Error uploading file!";
                }
            } else {
                echo "Wrong file type!";
            }
        }
    }
    public function uploadchampart($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $file = $_FILES['pimage'];
            $fileName = $file['name'];
            $file_TmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
            $fileExt = explode('.', $fileName);
            $fileActualExp = strtolower(end($fileExt)); //lowercased

            $allowed = array('jpg');
            if (in_array($fileActualExp, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 10000000) {
                        $fileDestination = 'imagens/champart/' . $id . '.jpg';
                        move_uploaded_file($file_TmpName, $fileDestination);
                        //header("Location:index.php?upload=Sucessfull");
                    } else {
                        echo "File is too big!";
                    }
                } else {
                    echo "Error uploading file!";
                }
            } else {
                echo "Wrong file type!";
            }
        }
    }
    public function champEdit()
    {
        $sql = "SELECT *FROM champion ORDER BY nome_c ASC";
        $conexao = $this->conexao;
        $resultado = $conexao->query($sql);
        $dados = $resultado->fetchAll();

        foreach ($dados as $registo) {
            $id = $registo['id_c'];
            $champion = $registo['nome_c'];
            echo "<p class='crudLink'><a href='atualizar2.php?idc=$id'>
                $champion</a></p>";
        }
    }
    function dadosFormEditar($id) //formulario
    {


        $sql = "SELECT champion.*, habilidadeschampion.id_h_hc as hc FROM champion LEFT JOIN habilidadeschampion ON champion.id_c=habilidadeschampion.id_c_hc WHERE id_c=?";
        //enviar a instrucao para a BD
        $conexao = $this->conexao;
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$id]);
        $dados = $stmt->fetchAll();

        foreach ($dados as $registo) {
            //passar os elementos do array para variaveis
            $arrayDados = [
                "nome"          => $registo['nome_c'],
                "role"          => $registo['role_c'],
                "dif"           => $registo['dif_c'],
                "des"           => $registo['des_c'],
                "habilidades_c" => $registo['hc']
            ];
            return $arrayDados;
        }
    }
    public function champupdate()
    {
        $conexao = $this->conexao;

        //criar variaveis com os valores recebidos do formulario(array POST)
        $champion = $_POST['champion'];
        $role = $_POST['role'];
        $dif = $_POST['dif'];
        $des = $_POST['des'];


        if (!isset($_POST['hab_check'])) {
            $habilidade = ""; //implode separa 
        } else {
            $habilidade = implode(',', $_POST['hab_check']); //implode separa 
        }
        $idc = $_GET['idc']; //colocar o id numa variavel local

        //Definir uma istrucao SQL
        $sql = "UPDATE champion SET nome_c=?, role_c=?, dif_c=?,des_c=? WHERE id_c=?;";
        $q = $conexao->prepare($sql); //prepara para introduzir todos os caracteres

        $resultado = $q->execute([$champion, $role, $dif, $des, $idc]);

        /* verificar o sucesso na inserçao dos dados na BD*/
        if ($resultado === TRUE) {
            $fdb = 2;
            header("location:index.php?alerta=" . $fdb);
        } else {
            $fdb = 0;
            header("location:inserir.php?alerta=" . $fdb);
        }
        $sql = "UPDATE habilidadeschampion SET id_h_hc=? WHERE id_c_hc=?";
        $stmt = $conexao->prepare($sql);
        $resultado = $stmt->execute([$habilidade, $idc]);
        return $idc;
    }
    function champlistdelete()
    {
        $conexao = $this->conexao;

        $sql = "SELECT *FROM champion ORDER BY nome_c ASC";
        $resultado = $conexao->query($sql);

        $dados = $resultado->fetchAll();

        foreach ($dados as $registo) {
            $id = $registo['id_c'];
            $champion = $registo['nome_c'];
            echo "<p class='crudLink'><a href='eliminar.php?idc=$id'
             onClick='return verificApaga(event);'>$champion</a></p>";
        }
    }
    public function champdelete()
    {
        $conexao = $this->conexao;

        $idc = $_GET['idc'];
        $sql = "DELETE FROM champion WHERE id_c =?";
        $r = $conexao->prepare($sql);
        $resultado = $r->execute([$idc]);
        if ($resultado === TRUE) {
            header("location:index.php?alerta=3");
        } else {
            header("location:index.php?alerta=0");
        }
        $sql = "DELETE FROM habilidadeschampion WHERE id_c_hc =?";
        $stmt = $conexao->prepare($sql);
        $resultado = $stmt->execute([$idc]);
    }
    public function respesquisa()
    {
        if (isset($_GET['fpesq'])) {
            $pesq = "%" . $_GET['fpesq'] . "%";
            /* definir uma instrucao SQL */
            $sql = "SELECT * FROM champion WHERE nome_c LIKE ? OR des_c LIKE ? ORDER BY nome_c ASC";
            $conexao = $this->conexao;
            $resultado = $conexao->prepare($sql);
            $resultado->execute([$pesq, $pesq]);
            $dados = $resultado->fetchAll();

            // se o SELECT retornou resultados
            if (count($dados) > 0) {
                // LOOPar entre os resultados
                foreach ($dados as $registo) {
                    $id = $registo['id_c'];
                    $champion = $registo['nome_c'];
                    echo "<p class='crudLink'><a href='infochamp.php?idc=$id'>" . $champion . "</a></p>";
                }
            } else { // se não há resultados
                echo '<p class="tit6"> Your search returned no results</p>';
            }
        }
    }
}
class Abilities
{
    private $conexao;

    public function __construct()
    {
        $pdo = new Bd;
        $con = $pdo->getPDO();
        $this->conexao = $con;
        unset($pdo);
    }
    function get_abilities($update = false)
    { //se n tiver 2 argumento o 2 argumento=false
        $sql = "SELECT * FROM habilidades ORDER BY nome_h ASC";
        $conexao = $this->conexao;
        $resultado = $conexao->query($sql);
        $dados = $resultado->fetchAll();


        $hcids = [];
        if ($update !== false) {
            $hcids = explode(',', $update); //variavel com ids do champion
        }

        foreach ($dados as $registo) {
            $checked = '';
            $id = $registo['id_h'];
            $habilidade = $registo['nome_h'];
            if (in_array($id, $hcids)) $checked = 'checked'; //in array verifica se id existe dentro das habilidades do champ
            if (file_exists('imagens/habilidades/' . $id . '.png')) { //verifica se existe
                echo "<div class=caixahabilidadeimg>
                        <input type='checkbox' name='hab_check[]' value='$id' $checked>
                        <img src='imagens/habilidades/$id.png' title='$habilidade' alt='$habilidade'>
                    </div>&nbsp;"; //codigo html de espaço none blank space
                //check vazia se sem habilidade

            }
        }
    }

    public function uploadabilities()
    {
        $conexao = $this->conexao;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $files = $_FILES['himage'];
            $nomes = $_POST['hnome'];
            for ($i = 0; $i < count($files); $i++) {
                $fileName = $files['name'][$i];
                $file_TmpName = $files['tmp_name'][$i];
                $fileSize = $files['size'][$i];
                $fileError = $files['error'][$i];
                $fileExt = explode('.', $fileName);
                $fileActualExp = strtolower(end($fileExt)); //lowercased

                $allowed = array('png');
                if (in_array($fileActualExp, $allowed)) {
                    if ($fileError === 0) {
                        if ($fileSize < 10000000) {
                            $sql_addimage = "INSERT INTO habilidades(nome_h, ordem_h)
                                VALUES (?,?)";
                            $stmt = $conexao->prepare($sql_addimage);
                            $add = $stmt->execute([$nomes[$i], $i + 1]);
                            if ($add == TRUE) {
                                $id = $conexao->lastInsertId();
                                $fileDestination = 'imagens/habilidades/' . $id . '.png';
                                move_uploaded_file($file_TmpName, $fileDestination);
                            } else {
                                echo "Insert fail";
                            }
                        } else {
                            echo "File is too big!";
                        }
                    } else {
                        echo "Error uploading file!";
                    }
                } else {
                    echo "Wrong file type!";
                }
            }
            header("Location:index.php?upload=Sucessfull&alerta=7");
        }
    }
}
