<?php
function mi_conexao()
{
    if (file_exists("../../../includes/conexao.php")) {
        require_once('../../../includes/conexao.php');
    } elseif (file_exists("../../includes/conexao.php")) {
        require_once('../../includes/conexao.php');/* para elementos essenciais no carregamento da pagina*/
        require_once('../includes/conexao.php');
    } else {
        require_once('includes/conexao.php');
    }

    return $conexao;
}
function verifAlerta($num)
{
    switch ($num) {
        case 0:
            $msgAlerta ="";
            break;
        case 1:
            $msgAlerta = "<p class='alertas'> Champion Added</p>";
            break;
        case 2:
            $msgAlerta = "<p class='alertas'> Champion Updated</p>";
            /* return implica break*/
            break;
        case 3:
            $msgAlerta = "<p class='alertas'> Champion Deleted</p>";
            break;
        case 4:
            $msgAlerta = "<p class='alertas'> Champion Already Exists</p>";
            break;
        case 5:
            $msgAlerta = "<p class='alertas'> User Already Exists</p>";
            break;
        case 6:
            $msgAlerta = "<p class='alertas'> User Added</p>";
            break;
        case 7:
            $msgAlerta = "<p class='alertas'> Abilities Uploaded</p>";
            break;
        case 8:
            $msgAlerta = "<p class='alertas'>Incorrect Password </p>";
            break;
        case 9:
            $msgAlerta ="<p class='alertas'>User Not Found</p>";
            break;
        default:
            $msgAlerta = "<p class='alertas'> Operation Failed! Try again later! </p>";
            break;
    }
    return $msgAlerta;
}
function clean($string)
{
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}
function allfromchampions($resultado)
{

    while ($registo = mysqli_fetch_array($resultado)) {
        echo '<a class="caixinha" href="infochamp.php?idc=' . $registo["id_c"] . '"><div>';
        $nChamp = clean($registo['nome_c']);
        if (file_exists('imagens/icons/' . $registo["id_c"] . '.jpg')) {
            echo '<img class="champImg" src="imagens/icons/' . $registo["id_c"] . '.jpg">';
        }
        echo '<p class= "tit5">' . $registo['nome_c'] . '</p> <br><br>';
        // echo'<p class= "tit3">Role: </p>';
        // echo'<p class= "tit2">'.$registo['role_c'].'</p> <br><br>';
        // echo'<p class= "tit3">Difficulty: </p>';
        // echo'<p class= "tit2">'.$registo['dif_c'].'</p> <br><br>';
        // echo'<p class= "tit3">Description: </p>';
        // echo'<p class="tit2">'.$registo['des_c'].'</p> <br><br>';
        echo '</div></a>';
    }
}
function addchampion($conexao)
{
                $sql= "SELECT nome_c FROM champion";
                $resultado=mysqli_query($conexao,$sql);
                $listNomesArray=[];
                while($linha=mysqli_fetch_array($resultado)){
                    array_push($listNomesArray,$linha['nome_c']);
                }
    $champion = $_POST['champion'];
    $role = $_POST['role'];
    $dif = $_POST['dif'];
    $des = $_POST['des'];
    /*$image_file=$_FILES['image'];

    $directory=getcwd();*/

    if(!in_array($champion,$listNomesArray)){

                if(is_null($_POST['hab_check'])){
                    $habilidade = ""; //implode separa 
                }else{
                    $habilidade = implode(',', $_POST['hab_check']); //implode separa 
                }
                $sql = "INSERT INTO champion (nome_c,role_c,dif_c,des_c) VALUES (?,?,?,?)";
                $q = mysqli_prepare($conexao, $sql);
                mysqli_stmt_bind_param($q, "ssss", $champion, $role, $dif, $des);
                $resultado = mysqli_stmt_execute($q);
                $id=mysqli_insert_id($conexao);
                if ($resultado === TRUE) {
                    $fdb = 1;
                    header("location:index.php?alerta=" . $fdb);
                } else {
                    $fdb = 0;
                    header("location:inserir.php?alerta=" . $fdb);
                }
                $sql = "SELECT id_c FROM champion ORDER BY id_c DESC LIMIT 1";
                $resultado = mysqli_query($conexao, $sql);
                $registo = mysqli_fetch_array($resultado);
                $new_id = $registo[0];
                $sql = "INSERT INTO habilidadeschampion(id_hc, id_c_hc, id_h_hc) VALUES ('','$new_id','$habilidade')";
                $resultado = mysqli_query($conexao, $sql);
                return $id;
    }else{
        header("location:index.php?alerta=" . $fdb);
    }
}
function champEdit($resultado)
{

    while ($registo = mysqli_fetch_array($resultado)) {
        $id = $registo['id_c'];
        $champion = $registo['nome_c'];
        echo "<p class='crudLink'><a href='atualizar2.php?idc=$id'>
             $champion</a></p>";
    }
}
function champupdate($conexao)
{
    //criar variaveis com os valores recebidos do formulario(array POST)
    $champion = $_POST['champion'];
    $role = $_POST['role'];
    $dif = $_POST['dif'];
    $des = $_POST['des'];
    $habilidade = implode(',', $_POST['hab_check']); //implode separa 
    $idc = $_GET['idc']; //colocar o id numa variavel local

    //Definir uma istrucao SQL
    $sql = "UPDATE champion SET nome_c=?, role_c=?, dif_c=?,des_c=? WHERE id_c=?;";
    $q = mysqli_prepare($conexao, $sql); //prepara para introduzir todos os caracteres
    mysqli_stmt_bind_param($q, "ssssi", $champion, $role, $dif, $des, $idc);

    //enviar SQL para BD
    $resultado = mysqli_stmt_execute($q);
     /* verificar o sucesso na inserçao dos dados na BD*/
    if ($resultado === TRUE) {
        $fdb = 2;
        header("location:index.php?alerta=" . $fdb);
    } else {
        $fdb = 0;
        header("location:inserir.php?alerta=" . $fdb);
    }
    $sql = "UPDATE habilidadeschampion SET id_h_hc='$habilidade' WHERE id_c_hc=$idc";
    $resultado = mysqli_query($conexao, $sql);
    return $idc;
}
function dadosFormEditar($conexao)
{
    $idc = $_GET['idc']; //colocar o id numa variavel local
    $sql = "SELECT champion.*, habilidadeschampion.id_h_hc as hc FROM champion LEFT JOIN habilidadeschampion ON champion.id_c=habilidadeschampion.id_c_hc WHERE id_c=$idc";
    //enviar a instrucao para a BD
    $resultado = mysqli_query($conexao, $sql);
    $registo = mysqli_fetch_array($resultado);
    //passar os lementos do array para variaveis
    $arrayDados = [
        "nome"          => $registo['nome_c'],
        "role"          => $registo['role_c'],
        "dif"           => $registo['dif_c'],
        "des"           => $registo['des_c'],
        "habilidades_c" => $registo['hc']
    ];
    return $arrayDados;
}
function mostrahabilidades($conexao)
{
    $sql = "SELECT * FROM habilidades";
    $resultado = mysqli_query($conexao, $sql);
    $devolve = [];
    while ($registo = mysqli_fetch_array($resultado)) {
        $devolve[$registo['id_h']] = $registo['nome_h'];
        //array com keys=id e valor=nome
    }
    return $devolve;
}
function champlistdelete($resultado)
{
    while ($registo = mysqli_fetch_array($resultado)) {
        $id = $registo['id_c'];
        $champion = $registo['nome_c'];
        echo "<p class='crudLink'><a href='eliminar.php?idc=$id'
             onClick='return verificApaga(event);'>$champion</a></p>";
    }
}
function champdelete($conexao)
{
    $idc = $_GET['idc'];
    $sql = "DELETE FROM champion WHERE id_c ='$idc'";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado === TRUE) {
        header("location:index.php?alerta=3");
    } else {
        header("location:index.php?alerta=0");
    }
    $sql = "DELETE FROM habilidadeschampion WHERE id_c_hc ='$idc'";
    $resultado = mysqli_query($conexao, $sql);
}
function login1($conexao)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fuser'])) {
        // passar p variaveis locais os dados do form de login
        $user = $_POST['fuser'];
        $pass = $_POST['fpass'];

        //pedir à BD a info do user preenchido
        $sql = "SELECT * FROM users WHERE nome_u='$user'";
        $resultado = mysqli_query($conexao, $sql);

        /* caso a BD tenha retornado algum registo... ou seja SE o utilizador foi reconhecido  */
        if (mysqli_num_rows($resultado) > 0) {
            $linha = mysqli_fetch_array($resultado);
            // guardar como var local a info retornada da BD: a password encriptada e o nivel de acesso
            $passBd = $linha['pass_u'];
            $nivel = $linha['nivel_u'];

            // Verificar se a pass preenchida corresponde à pass armazenada na BD
            if (password_verify($pass, $passBd)) {
                $_SESSION['user'] = $user;
                $_SESSION['nivel'] = $nivel;
            } else {
                $msgLog = "<p class='logP'>Incorrect Password </p>";
            }
        } else {
            $msgLog = "<p class='logP'>User $user not found</p>";
        }
    }
    if (!isset($msgLog)) {
        $msgLog = "";
    }
    return $msgLog;
}
function login2($msgLog = "")
{

    // se já há dados do user na SESSION é pq já estamos logados (escondemos o formulário)
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $msgLog = "<p class='logP2'>Welcome $user  <a href='logout.php'>logout</a></p>";
        echo $msgLog;
    } else {  // se não há SESSION então temos de nos logar (mostramos o formulário e a linha do msgLog: q pode trazer um erro ou o vazio "") 
        echo
        '<form method="POST" action="">
                    <input type="text" class="logInput" name="fuser" required>

                    <input type="password" class="logInput" name="fpass" required>

                    <input type="submit" value="Login" class="input_b">
                    
                ' . $msgLog . '
        </form>';
        echo '
        <form action="register_form.php" method="GET">
            <input type="submit" value="Register" class="input_b">
        </form>
        ';
    }
}
function get_abilities($resultado, $update = false)
{ //se n tiver 2 argumento o 2 argumento=false
    $hcids = [];
    if ($update !== false) {
        $hcids = explode(',', $update); //variavel com ids do champion
    }

    
    while ($registo = mysqli_fetch_array($resultado)) {
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
function verifica_resultados($resultado)
{
    // se o SELECT retornou resultados
    if (mysqli_num_rows($resultado) > 0) {
        // LOOPar entre os resultados
        while ($registo = mysqli_fetch_array($resultado)) {
            $id = $registo['id_c'];
            $champion = $registo['nome_c'];
            echo "<p class='crudLink'><a href='infochamp.php?idc=$id'>" . $champion . "</a></p>";
        }
    } else { // se não há resultados
        echo '<p class="tit6"> A sua pesquisa não retornou qualquer resultado</p>';
    }
}
function uploadabilities($conexao)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        /* echo "<pre>";
        echo print_r($_POST);
        echo"</pre>";
        die(); */
        
        $files = $_FILES['himage'];
        $nomes = $_POST['hnome'];
        for ($i = 0; $i < count($files); $i++) {
            $fileName = $files['name'][$i];
            $file_TmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileError = $files['error'][$i];
            //$fileType = $files['type'];//??
            $fileExt = explode('.', $fileName);
            $fileActualExp = strtolower(end($fileExt)); //lowercased

            $allowed = array('png');
            if (in_array($fileActualExp, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 10000000) {
                        $sql_addimage = "INSERT INTO habilidades(nome_h, ordem_h)
                        VALUES ('$nomes[$i]',$i+1)";
                        $add = mysqli_query($conexao, $sql_addimage);
                        if ($add == TRUE) {
                            $id = mysqli_insert_id($conexao);
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
        header("Location:index.php?upload=Sucessfull");
    }
}
function uploadchampicons($id)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $file = $_FILES['fimage'];
        $fileName = $file['name'];
        $file_TmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        //$fileType = $file['type'];//??
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
function uploadchampart($id)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $file = $_FILES['pimage'];
        $fileName = $file['name'];
        $file_TmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type']; //??
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
