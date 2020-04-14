<?php
    $pontos = "";
    if (realpath("./index.php")) {
        $pontos = './';
    } else {
        if (realpath("../index.php")) {
            $pontos = '../';
        } else {
            if (realpath("../../index.php")) {
                $pontos = '../../';
            }
        }
    }
    include_once $pontos.'Modelo/Usuario.php';;
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['logado'])) {
        include_once $pontos.'Base/navDeslogado.php';
    } else {
        $user = new Usuario(unserialize($_SESSION['logado']));
        if ($user->getAdmin() == 1) {
            include_once $pontos.'Base/navAdmin.php';
        } else {
            include_once $pontos.'Base/navLogado.php';
        }
    }