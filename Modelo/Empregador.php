<?php 

class empregador{

private $id_usuario;
private $razao_social;
private $cnpj;
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

     public function getRazao_social(){
         return $this->razao_social;
     }

     function setRazao_social($razao_social){
          $this->razao_social = $razao_social;
     }

     public function getCnpj(){
         return $this->cnpj;
     }

     function setCnpj($cnpj){
          $this->cnpj = $cnpj;
     }

     public function getNota(){
         return $this->nota;
     }

     function setNota($nota){
          $this->nota = $nota;
     }

}