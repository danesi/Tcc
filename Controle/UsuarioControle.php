<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/UsuarioPDO.php';
    $classe = new usuarioPDO();
    if (isset($_GET['function'])) {
        $metodo = $_GET['function'];
        $classe->$metodo();
    }

