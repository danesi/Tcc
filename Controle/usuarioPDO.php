<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Usuario.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Usuario.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Usuario.php';
        }
    }
}


class UsuarioPDO{
    
             /*inserir*/
    function inserirUsuario() {
        $usuario = new usuario($_POST);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into Usuario values(default , :nome , :cpf , :nascimento , :telefone , :email , :senha , :id_endereco);' );

            $stmt->bindValue(':nome', $usuario->getNome());    
        
            $stmt->bindValue(':cpf', $usuario->getCpf());    
        
            $stmt->bindValue(':nascimento', $usuario->getNascimento());    
        
            $stmt->bindValue(':telefone', $usuario->getTelefone());    
        
            $stmt->bindValue(':email', $usuario->getEmail());    
        
            $stmt->bindValue(':senha', $usuario->getSenha());    
        
            $stmt->bindValue(':id_endereco', $usuario->getId_endereco());    
        
            if($stmt->execute()){ 
                header('location: ../index.php?msg=usuarioInserido');
            }else{
                header('location: ../index.php?msg=usuarioErroInsert');
            }
    }
    /*inserir*/
                
    

            

    public function selectUsuario(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioId_usuario($id_usuario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioNome($nome){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where nome = :nome;');
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioCpf($cpf){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where cpf = :cpf;');
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioNascimento($nascimento){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where nascimento = :nascimento;');
        $stmt->bindValue(':nascimento', $nascimento);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioTelefone($telefone){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where telefone = :telefone;');
        $stmt->bindValue(':telefone', $telefone);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioEmail($email){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioSenha($senha){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where senha = :senha;');
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectUsuarioId_endereco($id_endereco){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where id_endereco = :id_endereco;');
        $stmt->bindValue(':id_endereco', $id_endereco);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateUsuario(Usuario $usuario){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set nome = :nome , cpf = :cpf , nascimento = :nascimento , telefone = :telefone , email = :email , senha = :senha , id_endereco = :id_endereco where id_usuario = :id_usuario;');
        $stmt->bindValue(':nome', $usuario->getNome());
        
        $stmt->bindValue(':cpf', $usuario->getCpf());
        
        $stmt->bindValue(':nascimento', $usuario->getNascimento());
        
        $stmt->bindValue(':telefone', $usuario->getTelefone());
        
        $stmt->bindValue(':email', $usuario->getEmail());
        
        $stmt->bindValue(':senha', $usuario->getSenha());
        
        $stmt->bindValue(':id_endereco', $usuario->getId_endereco());
        
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteUsuario($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from usuario where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteUsuario($_GET['id']);
        header('location: ../Tela/listarUsuario.php');
    }



            /*editar*/
            function editar() {
                $usuario = new Usuario($_POST);
                    if($this->updateUsuario($usuario) > 0){
                        header('location: ../index.php?msg=usuarioAlterado');
                    } else {
                        header('location: ../index.php?msg=usuarioErroAlterar');
                    }
            }
            /*editar*/
            /*chave*/
            }
                