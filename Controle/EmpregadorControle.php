<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/EmpregadorPDO.php';
    $classe = new empregadorPDO();
    if (isset($_GET['function'])) {
        $metodo = $_GET['function'];
        $classe->$metodo();
    }

