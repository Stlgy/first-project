<?php
session_start();
require_once('includes/funcoes.php');
require_once('includes/classes.php');
//$conexao = mi_conexao();
$l = new Login;
$l->login1();
$c=new Champion;

if (isset($_GET['idc'])) { //estou a receber um id no URL ?
    $idc = $_GET['idc'];
    /*$sql = "SELECT champion.*, habilidadeschampion.id_h_hc as hc FROM champion LEFT JOIN habilidadeschampion ON champion.id_c=habilidadeschampion.id_c_hc WHERE id_c=$idc";
    //enviar a instrucao para a BD
    $resultado = mysqli_query($conexao, $sql);
    $registo = mysqli_fetch_array($resultado);
    //$nomes_habilidades=mostrahabilidades($conexao);*/
}
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
    <div class="cxsite">
        <?php
        include_once('includes/nav.php');
        
        $c->infochamp();
        ?>
        <!--<div class="caixaimg">';
            <?php 
            // $nChamp = clean($registo['nome_c']);
            // if (file_exists('imagens/champart/' . $registo["id_c"] . '.jpg')) {
            //     echo '<img class="champImg" src="imagens/champart/' . $registo["id_c"] . '.jpg">';
            // } ?>
        </div>';

        <div class="caixainfo">
            <br><br>
            <p class="tit5"><?php $registo['nome_c'] ?></p> <br><br>
            <p class="tit3">Role: </p>
            <p class="tit2"><?php $registo['role_c'] ?></p> <br><br>
            <p class="tit3">Difficulty: </p>
            <p class="tit2"><?php $registo['dif_c'] ?></p> <br><br>
            <p class="tit3">Description: </p>
            <p class="tit2"><?php $registo['des_c'] ?></p> <br><br>
        </div>-->

        <?php
        /*//$habilidades = explode(',', $registo['hc']); //variavel com array de todas habilidades do champ especifico
        if (!empty($registo['hc'])) {
            echo '<div class="caixahabilidades">'; //explode retorna array de strings, each of which is a substring of string formed by splitting it on boundaries formed by the string separator.

            $sql = "SELECT id_h,nome_h FROM habilidades WHERE id_h IN ($registo[hc]) order BY ordem_h";

            $resultado = mysqli_query($conexao, $sql);
            $h = mysqli_fetch_all($resultado);
            //echo var_dump($h);
            //die();

            foreach ($h as $habilidade) {
                echo ' <img src="imagens/habilidades/' . $habilidade[0] . '.png" title="' . $habilidade[1] . '" alt="' . $habilidade[1] . '">&nbsp;'; //alt se img n existe escreve
            } //mostra imghabilidade com nome habilidade
            echo '</div>';
        }

        echo '</div>';*/
        ?>
        </section>
</body>
<script src="includes/uteis.js"></script>
</html>