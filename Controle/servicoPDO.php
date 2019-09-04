<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Servico.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Servico.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Servico.php';
        }
    }
}


class ServicoPDO{
    
             /*inserir*/
    function inserirServico() {
        $servico = new servico($_POST);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into Servico values(default , :nome , :descricao , :salario , :id_endereco , :id_empregado);' );

            $stmt->bindValue(':nome', $servico->getNome());    
        
            $stmt->bindValue(':descricao', $servico->getDescricao());    
        
            $stmt->bindValue(':salario', $servico->getSalario());    
        
            $stmt->bindValue(':id_endereco', $servico->getId_endereco());    
        
            $stmt->bindValue(':id_empregado', $servico->getId_empregado());    
        
            if($stmt->execute()){ 
                header('location: ../index.php?msg=servicoInserido');
            }else{
                header('location: ../index.php?msg=servicoErroInsert');
            }
    }
    /*inserir*/
                
    

            

    public function selectServico(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectServicoId_usuario($id_usuario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectServicoNome($nome){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico where nome = :nome;');
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectServicoDescricao($descricao){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico where descricao = :descricao;');
        $stmt->bindValue(':descricao', $descricao);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectServicoSalario($salario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico where salario = :salario;');
        $stmt->bindValue(':salario', $salario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectServicoId_endereco($id_endereco){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico where id_endereco = :id_endereco;');
        $stmt->bindValue(':id_endereco', $id_endereco);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectServicoId_empregado($id_empregado){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from servico where id_empregado = :id_empregado;');
        $stmt->bindValue(':id_empregado', $id_empregado);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateServico(Servico $servico){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update servico set nome = :nome , descricao = :descricao , salario = :salario , id_endereco = :id_endereco , id_empregado = :id_empregado where id_usuario = :id_usuario;');
        $stmt->bindValue(':nome', $servico->getNome());
        
        $stmt->bindValue(':descricao', $servico->getDescricao());
        
        $stmt->bindValue(':salario', $servico->getSalario());
        
        $stmt->bindValue(':id_endereco', $servico->getId_endereco());
        
        $stmt->bindValue(':id_empregado', $servico->getId_empregado());
        
        $stmt->bindValue(':id_usuario', $servico->getId_usuario());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteServico($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from servico where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteServico($_GET['id']);
        header('location: ../Tela/listarServico.php');
    }



            /*editar*/
            function editar() {
                $servico = new Servico($_POST);
                    if($this->updateServico($servico) > 0){
                        header('location: ../index.php?msg=servicoAlterado');
                    } else {
                        header('location: ../index.php?msg=servicoErroAlterar');
                    }
            }
            /*editar*/
            /*chave*/
            }
                