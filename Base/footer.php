<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}
include_once $pontos . "Modelo/Usuario.php";
include_once $pontos . "Controle/chatPDO.php";
$chatPDO = new chatPDO();
$user = new Usuario(unserialize($_SESSION['logado']));
$url = str_replace("/Tcc/Tela", "", $_SERVER["PHP_SELF"]);
if ($chatPDO->verificaExistChat($user->getId_usuario())) {
if ($url != "/verEmpregado.php") {
    include_once $pontos . "Base/chat.php";
}
}
?>

<footer class="center white">
    <div class="footer-copyright black-text"><a target="_blank" href="http://markeyvip.com" class="center col l10 s12 offset-l1 black-text">
            © 2020 Developed by - Daniel Anesi</a>
    </div>
</footer>

