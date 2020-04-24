<!DOCTYPE html>
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
    <div class="carousel">
        <a class="carousel-item"><img class="materialboxed"
                                                   src="Img/Servico/45c48cce2e2d7fbdea1afc51c7c6ad26.jpg" style="
height: 250px; max-width: auto;
                                         background-position: center;
                                         background-size: cover;
                                         background-repeat: no-repeat;
                                         object-fit: cover;
                                         object-position: center;
"></a><a class="carousel-item"><img class="materialboxed"
                                                   src="Img/Servico/c81e728d9d4c2f636f067f89cc14862c.png" style="
height: 250px; max-width: auto;
                                         background-position: center;
                                         background-size: cover;
                                         background-repeat: no-repeat;
                                         object-fit: cover;
                                         object-position: center;
"></a><a class="carousel-item"><img class="materialboxed"
                                                   src="Img/Servico/c9f0f895fb98ab9159f51fd0297e236d.jpg" style="
height: 250px; max-width: auto;
                                         background-position: center;
                                         background-size: cover;
                                         background-repeat: no-repeat;
                                         object-fit: cover;
                                         object-position: center;
"></a>
    </div>
</main>
<?php
    include_once './Base/footer.php';
?>
</body>
</html>
<script>
    $('.carousel').carousel();
    $('.materialboxed').materialbox();
</script>
