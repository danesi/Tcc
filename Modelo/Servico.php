<?php 

class servico{

private $id_usuario;
private $nome;
private $descricao;
private $salario;
private $id_endereco;
private $id_empregado;


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

     public function getNome(){
         return $this->nome;
     }

     function setNome($nome){
          $this->nome = $nome;
     }

     public function getDescricao(){
         return $this->descricao;
     }

     function setDescricao($descricao){
          $this->descricao = $descricao;
     }

     public function getSalario(){
         return $this->salario;
     }

     function setSalario($salario){
          $this->salario = $salario;
     }

     public function getId_endereco(){
         return $this->id_endereco;
     }

     function setId_endereco($id_endereco){
          $this->id_endereco = $id_endereco;
     }

     public function getId_empregado(){
         return $this->id_empregado;
     }

     function setId_empregado($id_empregado){
          $this->id_empregado = $id_empregado;
     }

}