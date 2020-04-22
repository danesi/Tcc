<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Modelo/Servico.php';
    include_once __DIR__.'/../Modelo/Empregador.php';
    include_once __DIR__.'/../Controle/EmpregadorPDO.php';
    include_once __DIR__.'/../Controle/FotoservicoPDO.php';
    include_once __DIR__.'/../Controle/EnderecoPDO.php';
    include_once __DIR__.'/../Controle/FotoservicoPDO.php';
    include_once __DIR__.'/../Controle/EmailPDO.php';


    class ServicoPDO
    {

        /*inserir*/
        function inserirServico()
        {
            $servico = new servico($_POST);
            $salario = str_replace(",", ".", $servico->getSalario());
            $usuario = new Usuario(unserialize($_SESSION['logado']));
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into servico values(default , :nome , :descricao , :salario, null, :id_usuario, default, default);');
            $stmt->bindValue(':nome', $servico->getNome());
            $stmt->bindValue(':descricao', $servico->getDescricao());
            $stmt->bindValue(':salario', $salario);
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
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
                            $emailPDO = new EmailPDO();
                            $emailPDO->notificaNovoServico($servico->getNome(), $usuario);
                            $_SESSION['toast'][] = "Cadastre um endereço para esse serviço!";
                            header("Location: ../Tela/registroEndereco.php?id_servico=".$ultId_servico);
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
                header("Location: ../Tela/perfilServico.php");
            } else {
                $_SESSION['toast'][] = 'Erro ao associar endereço';
                header("Location: ../Tela/editarServico.php?id_servico=".$id_servico."&endereco");
            }
        }

        function selectServicosPendentes()
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from servico where status = 'pendente';");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt;
            } else {
                return false;
            }
        }


        function verificaServico($id_usuario)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from servico where id_usuario = :id_usuario;");
            $stmt->bindValue(":id_usuario", $id_usuario);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

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

        function selectAllServicosAjax()
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select * from servico ;');
            $stmt->execute();
            $fotoservicoPDO = new FotoservicoPDO();
            while ($linha = $stmt->fetch()) {
                $servico = new Servico($linha);
                $foto = new Fotoservico($fotoservicoPDO->selectFotoPrincipalServico($servico->getId_servico())->fetch());
                echo '<div class="col l3 m3 s10 offset-s1">
                        <div class="card z-depth-3">
                            <div class="card-image">
                                <img src="../'.$foto->getCaminho().'" height="270" width="100">
                                <span class="card-title">'.$servico->getNome().'</span>
                                <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped"
                                   data-position="bottom" data-tooltip="Nota do serviço">4.5</a>
                                </div>
                                <ul class="card-content">
                                    <h5>Descrição</h5>'.$servico->getDescricao().'
                                    <h5>Salário mensal</h5>
                                    <div class="chip">R$ '.$servico->getSalario().'</div>
                                    <br>
                                    <br>
                                </ul>
                            </div>
                            </div>';
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


        public function selectPorNome()
        {
            $nome = $_POST['nome'];
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from servico where nome LIKE :nome");
            $stmt->bindValue(":nome", '%'.$nome.'%');
            $stmt->execute();
            $fotoservicoPDO = new FotoservicoPDO();
            if ($stmt->rowCount() > 0) {
                while ($linha = $stmt->fetch()) {
                    $servico = new Servico($linha);
                    $foto = new Fotoservico($fotoservicoPDO->selectFotoPrincipalServico($servico->getId_servico())->fetch());
                    echo '<div class="col l3 m3 s10 offset-s1">
                        <div class="card z-depth-3">
                            <div class="card-image">
                                <img src="../'.$foto->getCaminho().'" height="270" width="100">
                                <span class="card-title">'.$servico->getNome().'</span>
                                <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped"
                                   data-position="bottom" data-tooltip="Nota do serviço">4.5</a>
                                </div>
                                <ul class="card-content">
                                    <h5>Descrição</h5>'.$servico->getDescricao().'
                                    <h5>Salário mensal</h5>
                                    <div class="chip">R$ '.$servico->getSalario().'</div>
                                    <br>
                                    <br>
                                </ul>
                            </div>
                            </div>';
                }
            } else {
                echo "<div class='row'><div class='card-title center'>Nenhum resultado encontrado</div></div>";
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
            if ($fotoservicoPDO->removerTodasFotos($id_servico)) {
                $pdo = conexao::getConexao();
                $stmt = $pdo->prepare("delete from servico where id_servico = :id_servico");
                $stmt->bindValue(":id_servico", $id_servico);
                if ($stmt->execute()) {
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


        function selectPorLocalizacao()
        {
            $local = $_POST['local'];
            if ($local == "") {
                $this->selectAllServicosAjax();
            }
            $pdo = conexao::getConexao();
            $enderecoPDO = new EnderecoPDO();
            $fotoservicoPDO = new FotoservicoPDO();
            $enderecos = $enderecoPDO->selectPorLocalizacao($local);
            $existe = false;
            if ($enderecos->rowCount() > 0) {
                while ($linha = $enderecos->fetch()) {
                    $endereco = new Endereco($linha);
                    $stmt = $pdo->prepare("select * from servico where id_endereco = :id_endereco");
                    $stmt->bindValue(":id_endereco", $endereco->getId_endereco());
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        while ($servicos = $stmt->fetch()) {
                            $existe = true;
                            $servico = new Servico($servicos);
                            $foto = new Fotoservico($fotoservicoPDO->selectFotoPrincipalServico($servico->getId_servico())->fetch());
                            echo "<div class='col l3 m3 s10 offset-s1'>
                        <div class='card z-depth-3'>
                            <div class='card-image'>
                                <img src='../".$foto->getCaminho()."' height='270' width='100'>
                                <span class='card-title'>".$servico->getNome()."</span>
                                <a class='btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped'
                                   data-position='bottom' data-tooltip='Nota do serviço'>4.5</a>
                            </div>
                            <ul class='card-content'>
                                <h5>Descrição</h5>
                                ".$servico->getDescricao()."
                                <h5>Salário mensal</h5>
                                <div class='chip'>R$ ".$servico->getSalario()."</div>
                                <br>
                                <br>
                            </ul>
                        </div>
                    </div>";
                        }
                    }
                }
            }
            if (!$existe) {
                echo "<div class='row'><div class='card-title center'>Nenhum resultado encontrado</div></div>";
            }
        }

        function recusar()
        {
            $servico = new Servico($_POST);
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare('update servico set status = :status, motivo = :motivo where id_servico = :id_servico');
            $stmt->bindValue(":status", "recusado");
            $stmt->bindValue(":motivo", $servico->getMotivo());
            $stmt->bindValue(":id_servico", $servico->getId_servico());
            if ($stmt->execute()) {
                $_SESSION['toast'][] = "Serviço recusado";
                header("location: ../Tela/solicitacoes.php");
            } else {
                $_SESSION['toast'][] = "Erro ao recusar o serviçp";
                header("location: ../Tela/solicitacoes.php");
            }
        }

        function aceitar()
        {
            $id_servico = $_GET['id_servico'];
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare('update servico set status = :status where id_servico = :id_servico');
            $stmt->bindValue(":status", "aceito");
            $stmt->bindValue(":id_servico", $id_servico);
            if ($stmt->execute()) {
                $_SESSION['toast'][] = "Serviço aceito com sucesso";
                header("location: ../Tela/solicitacoes.php");
            } else {
                $_SESSION['toast'][] = "Erro ao aceitar o serviçp";
                header("location: ../Tela/solicitacoes.php");
            }
        }
    }
                