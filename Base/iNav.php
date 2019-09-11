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
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['logado'])) {
    include_once $pontos . 'Base/navDeslogado.php';
} else {
    $usuario = new usuario(unserialize($_SESSION['logado']));
    if ($usuario->getAdministrador() == 0) {
        if (isset($_SESSION['prestador'])) {
            include_once $pontos . "Base/navPrestador.php";
        } else {
            include_once $pontos . "Base/navLogado.php";
        }
    } else {
        include_once $pontos . "Base/navAdm.php";
    }
}