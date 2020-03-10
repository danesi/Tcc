<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/EnderecoPDO.php';
    $classe = new enderecoPDO();
    if (isset($_GET['function'])) {
        $metodo = $_GET['function'];
        $classe->$metodo();
    }

