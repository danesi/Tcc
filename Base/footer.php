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
?>

<footer class="center white">
    <div class="footer-copyright black-text"><a target="_blank" href="http://markeyvip.com" class="center col l10 s12 offset-l1 black-text">
            © 2020 Developed by - Daniel Anesi</a>
    </div>
</footer>

