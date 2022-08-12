<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');

//$conexao = mi_conexao();
//$msgLog = login1($conexao);

$l = new Login;
$l->login1();


if (isset($_GET["alerta"])) {
    $msgAlerta = verifAlerta($_GET["alerta"]);
} else {
    $msgAlerta = "";
}
$c=new Champion;

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
    /*echo password_hash("admin", PASSWORD_DEFAULT);*/
    include_once('includes/header.php');
    ?>
    <section id="cxsite">
        <div class="caixazita">
            <?php
            include_once('includes/nav.php');
            echo $msgAlerta;
            ?>
            <br>

            <p class="tit7"> Champions</p>
            <div class="cxFlex">
                <?php
                $c->allfromchampions();
                
                ?>
            </div>
        </div>
    </section>
    <?php
    include_once('includes/footer.php');
    ?>
</body>
<script src="includes/uteis.js"></script>
</html>