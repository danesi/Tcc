<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once __DIR__ . '/../Controle/chatPDO.php';
$classe = new chatPDO();
if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    $classe->$metodo();
}