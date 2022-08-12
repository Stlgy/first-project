<?php
    $servidor="localhost";
    $bd="avaliacao";
    $user="root";
    $pass="";
    /*$opcoes = [
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES      => false
    ];
    
    
    $dsn="mysql:host=$servidor;dbname=$bd;charset=utf8mb4";
    
    try{
        $conexao=new PDO($dsn,$user,$pass,$opcoes);
    }catch(PDOException $e ){
        header("location:index.php?alerta=0");//msg de erro na conexao
    }*/
    /*estabelecer conexao com BD*/
    $conexao=mysqli_connect($servidor,$user,$pass,$bd);
?>