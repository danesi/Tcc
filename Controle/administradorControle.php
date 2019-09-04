<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/administradorPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/administradorPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/administradorPDO.php';
        }
    }
}

$classe = new administradorPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

