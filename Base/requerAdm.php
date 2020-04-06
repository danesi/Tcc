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
if (!isset($_SESSION)) {
    session_start();
}
include_once $pontos . 'Modelo/Usuario.php';
if (isset($_SESSION['logado'])) {
    $usuario = new usuario(unserialize($_SESSION['logado']));
    if ($usuario->getAdmin() == 0) {
        $_SESSION['toast'][] = "Você precisa de permissão para acessar essa tela";
        header('location: ' . $pontos . "index.php");
    } else {
        $logado = $usuario;
    }
} else {
    $_SESSION['toast'][] = "Você precisa estar logado para fazer essa operação";
    header('location: ' . $pontos . "index.php");
}

