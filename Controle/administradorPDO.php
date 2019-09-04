<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Administrador.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Administrador.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Administrador.php';
        }
    }
}


class AdministradorPDO{
    
             /*inserir*/
    function inserirAdministrador() {
        $administrador = new administrador($_POST);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into Administrador values(default , :admin);' );

            $stmt->bindValue(':admin', $administrador->getAdmin());    
        
            if($stmt->execute()){ 
                header('location: ../index.php?msg=administradorInserido');
            }else{
                header('location: ../index.php?msg=administradorErroInsert');
            }
    }
    /*inserir*/
                
    

            

    public function selectAdministrador(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from administrador ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectAdministradorId_usuario($id_usuario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from administrador where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectAdministradorAdmin($admin){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from administrador where admin = :admin;');
        $stmt->bindValue(':admin', $admin);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateAdministrador(Administrador $administrador){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update administrador set admin = :admin where id_usuario = :id_usuario;');
        $stmt->bindValue(':admin', $administrador->getAdmin());
        
        $stmt->bindValue(':id_usuario', $administrador->getId_usuario());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteAdministrador($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from administrador where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteAdministrador($_GET['id']);
        header('location: ../Tela/listarAdministrador.php');
    }



            /*editar*/
            function editar() {
                $administrador = new Administrador($_POST);
                    if($this->updateAdministrador($administrador) > 0){
                        header('location: ../index.php?msg=administradorAlterado');
                    } else {
                        header('location: ../index.php?msg=administradorErroAlterar');
                    }
            }
            /*editar*/
            /*chave*/
            }
                