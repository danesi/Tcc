<?php
    if (realpath('./index.php')) {
        include_once './Controle/conexao.php';
        include_once './Modelo/Empregado.php';
        include_once './Modelo/Usuario.php';
    } else {
        if (realpath('../index.php')) {
            include_once '../Controle/conexao.php';
            include_once '../Modelo/Empregado.php';
            include_once '../Modelo/Usuario.php';
        } else {
            if (realpath('../../index.php')) {
                include_once '../../Controle/conexao.php';
                include_once '../../Modelo/Empregado.php';
                include_once '../../Modelo/Usuario.php';
            }
        }
    }


    class EmpregadoPDO
    {

        /*inserir*/
        function inserirEmpregado()
        {
            $empregado = new empregado($_POST);
            print_r($_POST);
            $usuario = new usuario(unserialize($_SESSION['logado']));
            $empregado->setId_usuario($usuario->getId_usuario());
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into empregado values(:id_usuario , :escolaridade , :area_atuacao, null);');
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
            $stmt->bindValue(':escolaridade', $empregado->getEscolaridade());
            $stmt->bindValue(':area_atuacao', $empregado->getArea_atuacao());
            if ($stmt->execute()) {
                $SendCadImg = filter_input(INPUT_POST, 'cadastrar', FILTER_SANITIZE_STRING);
                if ($SendCadImg && $_FILES['foto']['name'] != null) {
                    $nome_imagem = md5($usuario->getId_usuario());
                    $ext = explode('.', $_FILES['foto']['name']);
                    $extensao = ".".$ext[1];
                    $diretorio = '../Img/Perfil/'.$nome_imagem.$extensao;
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio)) {
                        $usuario->setFoto('Img/Perfil/'.$nome_imagem.$extensao);
                        $caminho = '/Img/Perfil/'.$nome_imagem.$extensao;
                        $this->alteraNomeFoto($usuario->getId_usuario(), $caminho);
                        $_SESSION['toast'][] = "Empregado cadastrado com sucesso!";
//                    header("Location: ../Tela/perfilEmpregado.php");
                    } else {
//                    header("Location: ../Tela/registroEmpregado.php?msg=erroSalvarImagem");
                    }
                } else {
//                header("Location: ../Tela/registroEmpregado.php?msg=erroCarrregaImagem");
                }

            } else {
//            header('location: ../index.php?msg=empregadoErroInsert');
            }
        }

        /*inserir*/


        function alteraNomeFoto($id_usuario, $foto)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('update usuario set foto = :foto where id_usuario = :id_usuario;');
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':foto', $foto);
            $stmt->execute();
            return $stmt->rowCount();
        }

        function verificaEmpregado($id_usuario)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from empregado where id_usuario = :id_usuario;");
            $stmt->bindValue(":id_usuario", $id_usuario);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        function verificaEndereco($id_endereco)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select id_endereco from usuario where id_usuario = :id_usuario");
            $stmt->bindValue(":id_usuario", $id_endereco);
            $stmt->execute();
            if ($stmt->fetch()['id_endereco'] == null) {
                return false;
            } else {
                return true;
            }
        }


        function selectEmpregado()
        {

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


        function selectEmpregadoId_usuario($id_usuario)
        {

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


        function selectEmpregadoEscolaridade($escolaridade)
        {

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


        function selectEmpregadoArea_atuacao($area_atuacao)
        {

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


        function selectEmpregadoNota($nota)
        {

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


        function updateEmpregado(Empregado $empregado)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('update empregado set escolaridade = :escolaridade , area_atuacao = :area_atuacao where id_usuario = :id_usuario;');
            $stmt->bindValue(':escolaridade', $empregado->getEscolaridade());
            $stmt->bindValue(':area_atuacao', $empregado->getArea_atuacao());
            $stmt->bindValue(':id_usuario', $empregado->getId_usuario());
            $stmt->execute();
            return $stmt->rowCount();
        }

        function deleteEmpregado($definir)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('delete from empregado where id_usuario = :definir ;');
            $stmt->bindValue(':definir', $definir);
            $stmt->execute();
            return $stmt->rowCount();
        }

        function deletar()
        {
            $this->deleteEmpregado($_GET['id_usuario']);
            $_SESSION['toast'][] = 'Perfil de empregado excluido!';
            header('location: ../index.php');
        }


        function editar()
        {
            $empregado = new Empregado($_POST);
            if ($this->updateEmpregado($empregado) > 0) {
                $_SESSION['toast'][] = "Dados de empregado alterados!";
                header('location: ../Tela/perfilEmpregado.php');
            } else {
                $_SESSION['toast'][] = "Erro ao alterar dados";
                header('location: ../Tela/perfilEmpregado.php');
            }
        }
    }
                