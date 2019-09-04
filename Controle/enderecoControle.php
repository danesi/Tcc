<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/enderecoPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/enderecoPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/enderecoPDO.php';
        }
    }
}

$classe = new enderecoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

