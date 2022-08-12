<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');
//$conexao = mi_conexao();
//$msgLog = login1($conexao);

$l = new Login;
$l->login1();

$c = new Champion;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["champion"])) {
    //$id = addchampion($conexao);
    $id = $c->addchampion();

    //exit("asasdsdasdas");
    if ($id !== false) {
        $c->uploadchampicons($id);
        $c->uploadchampart($id);
        header("Location:index.php?upload=Sucessfull&alerta=1");
        return;
    }
    header("Location:index.php?upload=Failed&alerta=0");
}
//$sql = "SELECT * FROM habilidades ORDER BY nome_h ASC";/*definir SQL*/
/*enviar SQL e receber dados da BD*/
////$resultado = mysqli_query($conexao, $sql);/*funçao msqli_query utiliza conexao e um sql para enviar os dados*/
//var_dump($resultado);mostra conteudo
?>
<!doctype html>
<html lang="pt">

<head>
    <title>:: Favorite Champions ::</title>
    <link href="folhadeestilos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
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
                        <br>
                        <p class="tit4"> Add Champion</p>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <table id="formtab">
                                <tr>
                                    <td>Icon Image</td>
                                    <td> <input type="file" name="fimage" class="iinp" required> </td>
                                </tr>
                                <tr>
                                    <td>Profile Image</td>
                                    <td> <input type="file" name="pimage" class="pinp"  required> </td>
                                </tr>
                                <tr>
                                    <td>Name:</td>
                                    <td><input type="text" name="champion" placeholder="Set Title"required></td>
                                </tr>
                                <tr>
                                    <td>Role:</td>
                                    <td><input type="text" name="role" placeholder="Set Job" required></td>
                                </tr>
                                <tr>
                                    <td>Difficulty:</td>
                                    <td><input type="text" name="dif" placeholder="Set Arduous" required></td>
                                </tr>
                                <tr>
                                    <td>Description:</td>
                                    <td><textarea name="des" rows=10 placeholder="Set Characterization" required></textarea></td>
                                </tr>
                                <tr>
                                    <td>Abilities:</td>
                                    <td>
                                <?php
                                $ghab = new Abilities;
                                $ghab->get_abilities();
                                ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" value="Add" class="input_b1"> </td>
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
    <?php
    include_once('includes/footer.php');
    ?>
</body>
<script src="includes/uteis.js"></script>
</html>