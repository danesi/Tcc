<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Modelo/Empregador.php';
    include_once __DIR__.'/../Modelo/Usuario.php';


    class EmpregadorPDO
    {

        /*inserir*/
        function inserirEmpregador()
        {
            $empregador = new Empregador($_POST);
            $usuario = new Usuario(unserialize($_SESSION['logado']));
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare('insert into empregador values(:id_usuario , :razao_social , :cnpj, :nota);');
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
            $stmt->bindValue(':razao_social', $empregador->getRazao_social());
            $stmt->bindValue(':cnpj', $empregador->getCnpj());
            $stmt->bindValue(':nota', 0);
            if ($stmt->execute()) {
                $_SESSION['toast'][] = "Seu perfil de mepregador foi cadastrado!";
                $_SESSION['toast'][] = "Agora você já pode cadastrar seu serviço";
                header("Location: ../Tela/registroServico.php");
            } else {
                $_SESSION['toast'][] = "Erro ao cadastrar o empregador!";
                header("Location: ../Tela/registroEmpregador.php");
            }
        }

        /*inserir*/
        public function selectEmpregador()
        {

            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from empregador ;');
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        public function selectEmpregadorId_usuario($id_usuario)
        {

            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from empregador where id_usuario = :id_usuario;');
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        public function selectEmpregadorRazao_social($razao_social)
        {

            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from empregador where razao_social = :razao_social;');
            $stmt->bindValue(':razao_social', $razao_social);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        public function selectEmpregadorCnpj($cnpj)
        {

            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from empregador where cnpj = :cnpj;');
            $stmt->bindValue(':cnpj', $cnpj);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        public function selectEmpregadorNota($nota)
        {

            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from empregador where nota = :nota;');
            $stmt->bindValue(':nota', $nota);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        public function updateEmpregador(Empregador $empregador)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('update empregador set razao_social = :razao_social , cnpj = :cnpj , nota = :nota where id_usuario = :id_usuario;');
            $stmt->bindValue(':razao_social', $empregador->getRazao_social());
            $stmt->bindValue(':cnpj', $empregador->getCnpj());
            $stmt->bindValue(':nota', $empregador->getNota());
            $stmt->bindValue(':id_usuario', $empregador->getId_usuario());
            $stmt->execute();
            return $stmt->rowCount();
        }

        public function deleteEmpregador($definir)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('delete from empregador where id_usuario = :definir ;');
            $stmt->bindValue(':definir', $definir);
            $stmt->execute();
            return $stmt->rowCount();
        }

        public function deletar()
        {
            $this->deleteEmpregador($_GET['id']);
            header('location: ../Tela/listarEmpregador.php');
        }


        /*editar*/
        function editar()
        {
            $empregador = new Empregador($_POST);
            if ($this->updateEmpregador($empregador) > 0) {
                header('location: ../index.php?msg=empregadorAlterado');
            } else {
                header('location: ../index.php?msg=empregadorErroAlterar');
            }
        }
        /*editar*/
        /*chave*/
    }
                