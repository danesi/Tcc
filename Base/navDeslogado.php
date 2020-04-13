<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
    include_once './Modelo/Usuario.php';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
        include_once '../Modelo/Usuario.php';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
            include_once '../../Modelo/Usuario.php';
        }
    }
}
?>

<nav class="nav-extended white">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="#" data-target="slide-out" class="sidenav-trigger">
            <i class="material-icons black-text">menu</i>
        </a>
        <a href="<?php echo $pontos; ?>./index.php" class="brand-logo left black-text hide-on-small-only">Tcc</a>
        <a href="<?php echo $pontos; ?>./index.php" class="brand-logo black-text center hide-on-med-and-up">Tcc</a>
        <ul class="right hide-on-med-and-down">
            <li>
                <a href="<?php echo $pontos; ?>./Tela/login.php" class="waves-effect waves-light btn blue darken-1">Quero trabalhar</a>
            </li>
            <li>
                <a href="<?php echo $pontos; ?>./Tela/login.php" class="waves-effect waves-light btn orange darken-1">Quero disponibilizar</a>
            </li>
            <li>
                <a href="<?php echo $pontos; ?>./Tela/login.php" class="waves-effect waves-light btn orange darken-1">Entrar</a>
            </li>
        </ul>
    </div>
</nav>

<ul id="slide-out" class="sidenav">
    <ul class="collapsible">
        <li>
            <a href="<?php echo $pontos; ?>./Tela/login.php" >Quero trabalhar</a>
        </li>
        <li>
            <a href="<?php echo $pontos; ?>./Tela/login.php" >Quero disponibilizar</a>
        </li>
        <li>
            <a href="<?php echo $pontos; ?>./Tela/login.php" >Entrar</a>
        </li>
    </ul>
</ul>
<script>
    $('.dropdown-trigger').dropdown({
        coverTrigger: false,
    });
    $('.collapsible').collapsible();
    $(document).ready(function () {
        $('.sidenav').sidenav();
    });


    $(".anime").click(function () {
        if ($(this).attr("x") == 0) {
            $(".anime").attr("x", "0");
            $(".animi").attr("style", "transform: rotate(0deg);");
            $(this).children($(".animi")).attr("style", "transform: rotate(180deg);");
            $(this).attr("x", "1");
        } else {
            $(this).children($(".animi")).attr("style", "transform: rotate(0deg);");
            $(this).attr("x", "0");
        }
    });
</script>
