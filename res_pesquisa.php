<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');

//$conexao = mi_conexao();
//$msgLog=login1($conexao);

?>

<!DOCTYPE html>
<html lang="pt">
	<head>
        <title>:: Favorite Champions ::</title>
        <link href="folhadeestilos.css" 
        rel="stylesheet">
        <meta charset="UTF-8">
	</head>
	<body>
        <?php
            include_once('includes/header.php');
        ?>
        <section id="cxsite">
            <?php
                include_once('includes/nav.php');
            ?>
            <br><br><br>
                <div class="caixaresult">
                <p class="tit9"> Results for: </p>
            <div>
            <?php
            $vr=new Champion;
            $vr->respesquisa();
            ?>
            </div>  
        </section> <!-- fim da cxsite -->

        <?php
            include_once('includes/footer.php');
        ?>
	</body>
</html>