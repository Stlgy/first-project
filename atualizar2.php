<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');

//$conexao = mi_conexao();
//$msgLog = login1($conexao);

$l = new Login;
$l->login1();
$c = new Champion;

/*Verificar se estamos a receber os dados do formulario*/
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["champion"])) {/*post verifica se foi pelo metodo post e o outro pelo preenchido no formulario*/
    $id = $c->champupdate();
    //$id = champupdate($conexao);

    uploadchampart($id);
    uploadchampicons($id);
} else if (isset($_GET['idc'])) { //estou a receber um id no URL ?
    $dados = $c->dadosFormEditar($_GET['idc']);
}

//$sql = "SELECT * FROM habilidades ORDER BY nome_h ASC";/*definir SQL*/
/*enviar SQL e receber dados da BD*/
//$resultado = mysqli_query($conexao, $sql);

?>
<!doctype html>
<html lang="pt">

<head>
    <title>:: Favorite Champions ::</title>
    <link href="folhadeestilos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <!--ligação à folha de estilos-->
    <meta charset="UTF-8">
</head>

<body>
    <?php
    include_once('includes/header.php');
    ?>
    <section id="cxsite">
        <div class="caixazita">
            <?php
            include_once('includes/nav.php');
            if (isset($_SESSION['user'])) {
                switch ($_SESSION['nivel']) {
                    case 1:
            ?>
                        <br><br>
                        <p class="tit4"> Update Champion</p>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <table id="formtab">
                                <tr>
                                    <td>Icon Image</td>
                                    <td> <input type="file" name="fimage" class="iinp"> </td>
                                </tr>
                                <tr>
                                    <td>Profile Image</td>
                                    <td> <input type="file" name="pimage" class="pinp"> </td>
                                </tr>
                                <tr>
                                    <td>Name: </td>
                                    <td><input type="text" name="champion" value="<?= $dados['nome'] ?>" required></td>
                                </tr>
                                <tr>
                                    <td>Role</td>
                                    <td><input type="text" name="role" value="<?= $dados['role'] ?>" required></td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Difficulty</td>
                                    <td><input type="text" name="dif" value="<?= $dados['dif'] ?>" required></td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td><textarea name="des" rows=10 required><?= $dados['des'] ?></textarea></td>
                                </tr>
                                <tr>
                                    <td>Abilities:</td>
                                    <td>
                                        <?php
                                        $h = new Habilities;
                                        $h->get_habilities($dados['habilidades_c']);
                                        //get_habilities($resultado, $dados['habilidades_c']);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" value="update" class="input_b1"> </td>
                                </tr>
                            </table>
                        </form>
        </div>
<?php
                        break;
                    case 0:
                        echo '<p class="tit6"> No permission to access this page</p>';
                        break;
                }
            } else {
                echo '<p class="tit6"> No permission to access this page</p>';
            }
?>
    </section>
    <!--fim da cxsite-->
    <?php
    include_once('includes/footer.php');

    ?>
</body>
<script src="includes/uteis.js"></script>

</html>