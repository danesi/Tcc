<?php 

class endereco{

private $id_endereco;
private $endereco;
private $cep;
private $numero;
private $complemento;
private $estado;
private $cidade;


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

     public function getId_endereco(){
         return $this->id_endereco;
     }

     function setId_endereco($id_endereco){
          $this->id_endereco = $id_endereco;
     }

     public function getEndereco(){
         return $this->endereco;
     }

     function setEndereco($endereco){
          $this->endereco = $endereco;
     }

     public function getCep(){
         return $this->cep;
     }

     function setCep($cep){
          $this->cep = $cep;
     }

     public function getNumero(){
         return $this->numero;
     }

     function setNumero($numero){
          $this->numero = $numero;
     }

     public function getComplemento(){
         return $this->complemento;
     }

     function setComplemento($complemento){
          $this->complemento = $complemento;
     }

     public function getEstado(){
         return $this->estado;
     }

     function setEstado($estado){
          $this->estado = $estado;
     }

     public function getCidade(){
         return $this->cidade;
     }

     function setCidade($cidade){
          $this->cidade = $cidade;
     }

}