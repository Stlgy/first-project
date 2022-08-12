<?php
session_start();
require_once('includes/classes.php');

if ($_POST['action'] == "Register") {
    $u = new User;
    //$password= password_hash($_POST["password"],PASSWORD_DEFAULT);

    $naoExiste = $u->user_verify($_POST['fuser']);

    if ($naoExiste == TRUE) {
        $u->adduser($_POST['fuser'],$_POST['fpass']);
    } else {
        header("location:index.php?alerta=5");
    }
} else {
    $l = new Login;
    $msg=$l->login1();
    header("location:index.php?alerta=$msg");
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
    <section id="cxregister">
        <title>:: Registration ::</title>
        <link href="folhadeestilos.css" rel="stylesheet">
        <meta charset="UTF-8">
        </head>

        <body>
            <p class="tit9"> Registration Form</p>
            <form method="post" action="register_form.php" method="POST">
                <table>
                    <tr>
                        <td>Username</td>
                        <td><input type="test" name="fuser"></td>
                    </tr>

                    <tr>
                        <td>Password</td>
                        <td><input type="password" name="fpass"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="action" value="Login" class="input_b1"></td>
                    </tr>

                </table>
            </form>

    </section>
</body>