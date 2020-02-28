<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/ServicoPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/ServicoPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/ServicoPDO.php';
        }
    }
}

$classe = new servicoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

