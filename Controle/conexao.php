<?php
    class conexao {

        private static $con;

        public static function getConexao() :PDO{
            if (is_null(self::$con)) {
                self::$con = new PDO('mysql:host=localhost;dbname=tcc', 'root', '');
            }
            return self::$con;
        }

        public static function getTransactConnetion():PDO{
            return new PDO('mysql:host=localhost;dbname=tcc', 'root', '');
        }
    }