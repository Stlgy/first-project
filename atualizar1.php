<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');

//$conexao = mi_conexao();
//$msgLog = login1($conexao);

$l = new Login;
$l->login1();

//$sql = "SELECT * FROM champion ORDER BY nome_c ASC";/*definir SQL*/
/*enviar SQL e receber dados da BD*/
//$resultado = mysqli_query($conexao, $sql);/*funçao msqli_query utiliza conexao e um sql para enviar os dados*/

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
            ?>
            <?php
            if (isset($_SESSION['user'])) {
                switch ($_SESSION['nivel']) {
                    case 1:
                        echo '
                        <br>
                    <p class="tit4"> Update Champion</p>
                    <div>';

                        //champEdit($resultado);
                        $cEdit = new Champion;
                        $cEdit->champEdit();
                        echo '</div>';
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
    </section>
    <!--fim da cxsite-->
    <?php
    include_once('includes/footer.php');
    ?>
</body>
<script src="includes/uteis.js"></script>
</html>