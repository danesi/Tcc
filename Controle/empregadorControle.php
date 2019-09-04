<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/empregadorPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/empregadorPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/empregadorPDO.php';
        }
    }
}

$classe = new empregadorPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

