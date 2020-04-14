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
include_once $pontos . 'Modelo/Usuario.php';
class Empregado extends Usuario {

private $id_usuario;
private $escolaridade;
private $area_atuacao;
private $nota;


public function __construct() {
    if (func_num_args() != 0) {
        $atributos = func_get_args()[0];
        foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    function atualizar($vetor) {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

     public function getId_usuario(){
         return $this->id_usuario;
     }

     function setId_usuario($id_usuario){
          $this->id_usuario = $id_usuario;
     }

     public function getEscolaridade(){
         return $this->escolaridade;
     }

     function setEscolaridade($escolaridade){
          $this->escolaridade = $escolaridade;
     }

     public function getArea_atuacao(){
         return $this->area_atuacao;
     }

     function setArea_atuacao($area_atuacao){
          $this->area_atuacao = $area_atuacao;
     }

     public function getNota(){
         return $this->nota;
     }

     function setNota($nota){
          $this->nota = $nota;
     }

}