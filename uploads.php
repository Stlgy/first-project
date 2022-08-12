<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');
$conexao = mi_conexao();
$msgLog = login1($conexao);
$h = new Abilities;
$h->uploadabilities();
$sql = "SELECT * FROM champion ORDER BY nome_c ASC";/*definir SQL*/
/*enviar SQL e receber dados da BD*/
$resultado = mysqli_query($conexao, $sql);/*funçao msqli_query utiliza conexao e um sql para enviar os dados*/
//uploadhabilities($conexao);
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
                        <p class="tit8"> Abilities</p>
                        <form action="" method="POST" enctype="multipart/form-data">

                            <!--  Os dados enviados por POST nao sao visiveis no browser 
                        action define para onde os dados sao enviados, action="" envia os dados para este mesmo ficheiro-->
                            <table id="formTab">
                                <tr>
                                <tr>
                                    <td>Ability Name</td>
                                    <td> <input type="text" name="hnome[]"  placeholder="Set Passive"required> </td>
                                </tr>
                                <tr>
                                    <td>Ability Image</td>
                                    <td> <input type="file" name="himage[]"   required> </td>
                                </tr>
                                <tr>
                                    <td>Ability Name</td>
                                    <td> <input type="text" name="hnome[]"  placeholder="Set Q"required> </td>
                                </tr>

                                <tr>
                                    <td>Ability Image</td>
                                    <td> <input type="file" name="himage[]"  required> </td>
                                </tr>
                                <tr>
                                    <td>Ability Name</td>
                                    <td> <input type="text" name="hnome[]"  placeholder="Set W" required> </td>
                                </tr>

                                <tr>
                                    <td>Ability Image</td>
                                    <td> <input type="file" name="himage[]"  required> </td>
                                </tr>
                                <tr>
                                    <td>Ability Name</td>
                                    <td> <input type="text" name="hnome[]"  placeholder="Set E"required> </td>
                                </tr>

                                <tr>
                                    <td>Ability Image</td>
                                    <td> <input type="file" name="himage[]"  required> </td>
                                </tr>
                                <tr>
                                    <td>Ability Name</td>
                                    <td> <input type="text" name="hnome[]" placeholder="Set Ultimate"required> </td>
                                </tr>

                                <tr>
                                    <td>Ability Image</td>
                                    <td> <input type="file" name="himage[]" required> </td>
                                </tr>

                                </td>
                                <tr>
                                <tr>
                                    <td> </td>
                                    <td> <input type="submit" value="submit" class="input_b1"> </td>
                                </tr>
                            </table>

                        </form>
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
        </div>
    </section> <!-- fim da cxsite -->
    <?php
    include_once('includes/footer.php');
    ?>
</body>
<script src="includes/uteis.js"></script>

</html>