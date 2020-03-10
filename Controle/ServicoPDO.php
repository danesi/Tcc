<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Modelo/Servico.php';
    include_once __DIR__.'/../Modelo/Empregador.php';
    include_once __DIR__.'/../Controle/EmpregadorPDO.php';
    include_once __DIR__.'/../Controle/FotoservicoPDO.php';


    class ServicoPDO
    {

        /*inserir*/
        function inserirServico()
        {
            $servico = new servico($_POST);
            $salario = explode(",", $servico->getSalario());
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into servico values(default , :nome , :descricao , :salario, null, :id_usuario);');
            $stmt->bindValue(':nome', $servico->getNome());
            $stmt->bindValue(':descricao', $servico->getDescricao());
            $stmt->bindValue(':salario', $salario[0].".".$salario[1]);
            $stmt->bindValue(':id_usuario', $_SESSION['id_usuario']);
            if ($stmt->execute()) {
                $ultId_servico = $pdo->lastInsertId();
                $SendCadImg = filter_input(INPUT_POST, 'cadastrar', FILTER_SANITIZE_STRING);
                if ($SendCadImg && $_FILES['foto']['name'] != null) {
                    $nome_imagem = md5($ultId_servico);
                    $ext = explode('.', $_FILES['foto']['name']);
                    $extensao = ".".$ext[1];
                    $diretorio = '../Img/Servico/'.$nome_imagem.$extensao;
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio)) {
                        $servico->setFoto('Img/Servico/'.$nome_imagem.$extensao);
                        $caminho = '/Img/Servico/'.$nome_imagem.$extensao;
                        $fotoservicoPDO = new FotoservicoPDO();
                        if ($fotoservicoPDO->inserirFotoServico($ultId_servico, $caminho)) {
                            $_SESSION['toast'][] = "Serviço cadastrado com susseço!";
                            header("Location: ../Tela/perfilServico.php");
                        } else {
                            $_SESSION['toast'][] = "Erro ao alterar a foto!";
                            header("Location: ../Tela/registroServico.php");
                        }
                    } else {
                        $_SESSION['toast'][] = "Erro ao salvar a foto!";
                        header("Location: ../Tela/registroServico.php");
                    }
                }

            } else {
                $_SESSION['toast'][] = "Erro ao cadastrar serviço!";
                header("Location: ../Tela/registroServico.php");
            }
        }

        function relacionaEndereco($id_endereco, $id_servico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("update servico set id_endereco = :endereco where id_servico = :id_servico");
            $stmt->bindValue(":endereco", $id_endereco);
            $stmt->bindValue(":id_servico", $id_servico);
            if ($stmt->execute()) {
                $_SESSION['toast'][] = 'Endereço cadastrado com sucesso!';
                header("Location: ../Tela/editarServico.php?id_servico=".$id_servico."&endereco");
            } else {
                $_SESSION['toast'][] = 'Erro ao associar endereço';
                header("Location: ../Tela/editarServico.php?id_servico=".$id_servico."&endereco");
            }
        }

        /*inserir*/
        public function selectServico()
        {
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


        public function selecionaUltimoServico()
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select max(id_servico) as id_servico from servico;');
            $stmt->execute();
            while ($linha = $stmt->fetch()) {
                $servico = new servico($linha);
            }
            return $servico->getId_servico();
        }

        public function selectServicoId_usuario($id_usuario)
        {

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

        public function selectServicoId_servico($id_servico)
        {

            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from servico where id_servico = :id_servico;');
            $stmt->bindValue(':id_servico', $id_servico);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        public function selectServicoNome($nome)
        {

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


        public function selectServicoDescricao($descricao)
        {

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


        public function selectServicoSalario($salario)
        {

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


        public function selectServicoId_endereco($id_endereco)
        {

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


        public function selectServicoId_empregado($id_empregado)
        {

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


        public function updateServico(Servico $servico)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('update servico set nome = :nome , descricao = :descricao , salario = :salario where id_servico = :id_servico;');
            $stmt->bindValue(':nome', $servico->getNome());
            $stmt->bindValue(':descricao', $servico->getDescricao());
            $stmt->bindValue(':salario', $servico->getSalario());
            $stmt->bindValue(':id_servico', $servico->getId_servico());
            $stmt->execute();
            return $stmt->rowCount();
        }

        function excluir()
        {
            $id_servico = $_POST['id_servico'];
            $fotoservicoPDO = new FotoservicoPDO();
            if($fotoservicoPDO->removerTodasFotos($id_servico)){
                $pdo = conexao::getConexao();
                $stmt = $pdo->prepare("delete from servico where id_servico = :id_servico");
                $stmt->bindValue(":id_servico", $id_servico);
                if($stmt->execute()){
                    $_SESSION['toast'][] = "Serviço excluido com sucesso!";
                    header("Location: ../Tela/perfilServico.php");
                } else {
                    $_SESSION['toast'][] = "Ocorreu um erro ao excluir o serviço";
                    header("Location: ../Tela/perfilServico.php");
                }
            } else {
                $_SESSION['toast'][] = "Ocorreu um erro ao excluir as fotos do serviço";
                header("Location: ../Tela/perfilServico.php");
            }
        }


        /*editar*/
        function editar()
        {
            $servico = new Servico($_POST);
            if ($this->updateServico($servico) > 0) {
                $_SESSION['toast'][] = 'Informações do serviço alteradas!';
                header("Location: ../Tela/editarServico.php?id_servico=".$_POST['id_servico']."&info");
            } else {
                $_SESSION['toast'][] = 'Erro ao alterar informações';
                header("Location: ../Tela/editarServico.php?id_servico=".$_POST['id_servico']."&info");
            }
        }
        /*editar*/
        /*chave*/
    }
                