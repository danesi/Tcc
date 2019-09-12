<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Empregado.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Empregado.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Empregado.php';
        }
    }
}


class EmpregadoPDO{
    
             /*inserir*/
    function inserirEmpregado(empregado $empregado, $id_usuario) {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('insert into empregado values(:id_usuario , :escolaridade , :area_atuacao , :nota);' );
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':escolaridade', $empregado->getEscolaridade());
        $stmt->bindValue(':area_atuacao', $empregado->getArea_atuacao());
        $stmt->bindValue(':nota', $empregado->getNota());
        if($stmt->execute()){
            header('location: ../Tela/perfilEmpregado.php?msg=empregadoInserido');
        }else{
            header('location: ../index.php?msg=empregadoErroInsert');
        }
    }
    /*inserir*/
                
    

            

    public function selectEmpregado(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from empregado ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEmpregadoId_usuario($id_usuario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from empregado where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEmpregadoEscolaridade($escolaridade){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from empregado where escolaridade = :escolaridade;');
        $stmt->bindValue(':escolaridade', $escolaridade);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEmpregadoArea_atuacao($area_atuacao){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from empregado where area_atuacao = :area_atuacao;');
        $stmt->bindValue(':area_atuacao', $area_atuacao);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectEmpregadoNota($nota){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from empregado where nota = :nota;');
        $stmt->bindValue(':nota', $nota);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateEmpregado(Empregado $empregado){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update empregado set escolaridade = :escolaridade , area_atuacao = :area_atuacao , nota = :nota where id_usuario = :id_usuario;');
        $stmt->bindValue(':escolaridade', $empregado->getEscolaridade());
        
        $stmt->bindValue(':area_atuacao', $empregado->getArea_atuacao());
        
        $stmt->bindValue(':nota', $empregado->getNota());
        
        $stmt->bindValue(':id_usuario', $empregado->getId_usuario());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteEmpregado($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from empregado where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteEmpregado($_GET['id']);
        header('location: ../Tela/listarEmpregado.php');
    }



            /*editar*/
            function editar() {
                $empregado = new Empregado($_POST);
                    if($this->updateEmpregado($empregado) > 0){
                        header('location: ../index.php?msg=empregadoAlterado');
                    } else {
                        header('location: ../index.php?msg=empregadoErroAlterar');
                    }
            }
            /*editar*/
            /*chave*/
            }
                