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
if(!isset($_SESSION)){
    session_start();
}
if (!isset($_SESSION['logado'])) {
    include_once $pontos . 'Base/navDeslogado.php';
} else {
    include_once  $pontos . 'Base/navLogado.php';
}