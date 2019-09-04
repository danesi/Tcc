<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Endereco.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Endereco.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Endereco.php';
        }
    }
}


class EnderecoPDO{
    
             /*inserir*/
    function inserirEndereco() {
        $endereco = new endereco($_POST);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into Endereco values(default , :endereco , :cep , :numero , :complemento , :estado , :cidade);' );

            $stmt->bindValue(':endereco', $endereco->getEndereco());    
        
            $stmt->bindValue(':cep', $endereco->getCep());    
        
            $stmt->bindValue(':numero', $endereco->getNumero());    
        
            $stmt->bindValue(':complemento', $endereco->getComplemento());    
        
            $stmt->bindValue(':estado', $endereco->getEstado());    
        
            $stmt->bindValue(':cidade', $endereco->getCidade());    
        
            if($stmt->execute()){ 
                header('location: ../index.php?msg=enderecoInserido');
            }else{
                header('location: ../index.php?msg=enderecoErroInsert');
            }
    }
    /*inserir*/
                
    

            

    public function selectEndereco(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoId_endereco($id_endereco){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where id_endereco = :id_endereco;');
        $stmt->bindValue(':id_endereco', $id_endereco);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoEndereco($endereco){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where endereco = :endereco;');
        $stmt->bindValue(':endereco', $endereco);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoCep($cep){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where cep = :cep;');
        $stmt->bindValue(':cep', $cep);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoNumero($numero){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where numero = :numero;');
        $stmt->bindValue(':numero', $numero);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoComplemento($complemento){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where complemento = :complemento;');
        $stmt->bindValue(':complemento', $complemento);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoEstado($estado){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where estado = :estado;');
        $stmt->bindValue(':estado', $estado);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEnderecoCidade($cidade){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from endereco where cidade = :cidade;');
        $stmt->bindValue(':cidade', $cidade);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateEndereco(Endereco $endereco){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update endereco set endereco = :endereco , cep = :cep , numero = :numero , complemento = :complemento , estado = :estado , cidade = :cidade where id_endereco = :id_endereco;');
        $stmt->bindValue(':endereco', $endereco->getEndereco());
        
        $stmt->bindValue(':cep', $endereco->getCep());
        
        $stmt->bindValue(':numero', $endereco->getNumero());
        
        $stmt->bindValue(':complemento', $endereco->getComplemento());
        
        $stmt->bindValue(':estado', $endereco->getEstado());
        
        $stmt->bindValue(':cidade', $endereco->getCidade());
        
        $stmt->bindValue(':id_endereco', $endereco->getId_endereco());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteEndereco($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from endereco where id_endereco = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteEndereco($_GET['id']);
        header('location: ../Tela/listarEndereco.php');
    }



            /*editar*/
            function editar() {
                $endereco = new Endereco($_POST);
                    if($this->updateEndereco($endereco) > 0){
                        header('location: ../index.php?msg=enderecoAlterado');
                    } else {
                        header('location: ../index.php?msg=enderecoErroAlterar');
                    }
            }
            /*editar*/
            /*chave*/
            }
                