<?php
	session_start();
	$_SESSION['user'] = NULL;
	$_SESSION['nivel'] = NULL;
	unset($_SESSION['user']);
	unset($_SESSION['nivel']);
	session_destroy();
    if(file_exists("index.php")){
		header("location:index.php");
	}
?>