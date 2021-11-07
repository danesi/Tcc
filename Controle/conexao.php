<?php

    class conexao
    {

        private static $con;

        public static function getConexao(): PDO
        {
            try {
                if (is_null(self::$con)) {
                    self::$con = new PDO('mysql:host=localhost;dbname=tcc', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                }
                return self::$con;
            } catch (Exception $e) {
                echo "<h1>FALHA GERAL</h1>";
                exit(0);
            }
        }
    }