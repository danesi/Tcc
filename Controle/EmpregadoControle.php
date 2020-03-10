<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/EmpregadoPDO.php';
    $classe = new empregadoPDO();
    if (isset($_GET['function'])) {
        $metodo = $_GET['function'];
        $classe->$metodo();
    }

