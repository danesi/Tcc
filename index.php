<!DOCTYPE html>
<?php
if (isset($_SESSION['logado'])) {
    header('location: ../Tela/home.php');
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once './Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once './Base/iNav.php';
        ?>
        <main>
           
        </main>
        <?php
        include_once './Base/footer.php';
        ?>
    </body>
</html>

