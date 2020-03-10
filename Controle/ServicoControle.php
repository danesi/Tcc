<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/ServicoPDO.php';
    $classe = new servicoPDO();
    if (isset($_GET['function'])) {
        $metodo = $_GET['function'];
        $classe->$metodo();
    }

