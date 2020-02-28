<?php

if (!isset($_SESSION)) {
    session_start();
}

if (realpath('./index.php')) {
    include_once './Controle/EmpregadoPDO.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/EmpregadoPDO.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/EmpregadoPDO.php';
        }
    }
}

$classe = new empregadoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}

