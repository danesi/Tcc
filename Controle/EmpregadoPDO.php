<?php
    include_once __DIR__.'./../Controle/conexao.php';
    include_once __DIR__.'./../Controle/UsuarioPDO.php';
    include_once __DIR__.'./../Controle/EmailPDO.php';
    include_once __DIR__.'./../Modelo/Empregado.php';
    include_once __DIR__.'./../Modelo/Usuario.php';


    class EmpregadoPDO
    {

        /*inserir*/
        function inserirEmpregado()
        {
            $empregado = new empregado($_POST);
            $usuario = new usuario(unserialize($_SESSION['logado']));
            $empregado->setId_usuario($usuario->getId_usuario());
            $count = strlen($empregado->getArea_atuacao());
            $areas = substr($empregado->getArea_atuacao(), 0, $count - 1);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into empregado values(:id_usuario , :escolaridade , :area_atuacao, null, default );');
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
            $stmt->bindValue(':escolaridade', $empregado->getEscolaridade());
            $stmt->bindValue(':area_atuacao', $areas);
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
                        header("Location: ../Tela/perfilEmpregado.php");
                    } else {
                        header("Location: ../Tela/registroEmpregado.php?msg=erroSalvarImagem");
                    }
                } else {
                    $_SESSION['toast'][] = "Empregado cadastrado com sucesso!";
                    header("Location: ../Tela/perfilEmpregado.php");
                }

            } else {
                header('location: ../index.php?msg=empregadoErroInsert');
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
            $count = strlen($empregado->getArea_atuacao());
            $areas = substr($empregado->getArea_atuacao(), 0, $count - 1);
            $stmt = $pdo->prepare('update empregado set escolaridade = :escolaridade , area_atuacao = :area_atuacao where id_usuario = :id_usuario;');
            $stmt->bindValue(':escolaridade', $empregado->getEscolaridade());
            $stmt->bindValue(':area_atuacao', $areas);
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
            if ($this->deleteEmpregado($_POST['id_usuario']) > 0) {
                $_SESSION['toast'][] = 'Empregado excluido!';
                $emailPDO = new EmailPDO();
                $emailPDO->notificaEmpregadoDeletado($_POST['id_usuario']);
                echo "<script>location.href = document.referrer;</script>";
            } else {
                $_SESSION['toast'][] = 'Erro ao excluir empregado';
                echo "<script>location.href = document.referrer;</script>";
            }
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

        function selectAllAreasAtuacao()
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select area_atuacao from empregado");
            $stmt->execute();
            $allAreas = null;
            while ($area = $stmt->fetch()) {
                $allAreas = $allAreas.$area['area_atuacao'];
                $allAreas = $allAreas.",";
            }
            $count = strlen($allAreas);
            $areas = substr($allAreas, 0, $count - 1);
            $areas = explode(",", $areas);
            return array_unique($areas);
        }

        function selectEmpregadoProArea()
        {
            if (isset($_POST['data'])) {
                $areas = $_POST['data'];
            }
            $pdo = conexao::getConexao();
            $response = [];
            $empregados = null;
            if (isset($areas)) {
                foreach ($areas as $area) {
                    $stmt = $pdo->prepare("select * from empregado where area_atuacao like '%".$area."%'");
                    $stmt->execute();
                    $response[] = $stmt->fetchAll();
                }
            } else {
                $stmt = $pdo->prepare("select * from empregado");
                $stmt->execute();
                $response[] = $stmt->fetchAll();
            }
            foreach ($response as $datas) {
                foreach ($datas as $data) {
                    $empregados = $empregados.$data['id_usuario'].",";
                }
            }
            $count = strlen($empregados);
            $empregados = substr($empregados, 0, $count - 1);
            $empregados = explode(",", $empregados);
            $empregados = array_unique($empregados);
            foreach ($empregados as $id_empregado) {
                $empregado = new Empregado($this->selectEmpregadoId_usuario($id_empregado)->fetch());
                $usuarioPDO = new UsuarioPDO();
                $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($empregado->getId_usuario())->fetch());
                $media = $this->selectMedia($empregado->getId_usuario());
                echo "
                    <a href='./verEmpregado.php?id=".$empregado->getId_usuario()."'>
                    <div class='col l3 m3 s10 offset-s1' >
                    <div class='card empregados'>
                        <div class='card-image'>
                            <img src='../".$usuario->getFoto()."'>
                            <span class='card-title'>".$usuario->getNome()."</span>
                            <a class='btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped center'
                               data-position='bottom' data-tooltip='Nota do empregado'>".$media."</a>
                        </div>
                        <ul class='card-content center'>
                            <h5>Áreas de atuação</h5>";
                $areas = explode(",", $empregado->getArea_atuacao());
                foreach ($areas as $area) {
                    echo "<div class='chip'>".$area."</div>";
                }
                echo "<h5>Ecolaridade</h5>
                            <div class='chip'>".$empregado->getEscolaridade()."</div>
                    </div>
                </div></a>";
            }
        }

        function avaliar()
        {
            $newNota = $_POST['nota'];
            $id_empregado = $_POST['id_empregado'];
            $id_usuario = $_POST['id_usuario'];
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("insert into nota_empregado values (default, :id_empregado, :id_usuario, :nota)");
            $stmt->bindValue(":id_empregado", $id_empregado);
            $stmt->bindValue(":id_usuario", $id_usuario);
            $stmt->bindValue(":nota", $newNota);
            $stmt->execute();
            echo $stmt->rowCount();
        }

        function selectAvaliacaoId_usuario($id_usuario, $id_empregado)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from nota_empregado where id_usuario = :id_usuario and id_empregado = :id_empregado");
            $stmt->bindValue(":id_usuario", $id_usuario);
            $stmt->bindValue(":id_empregado", $id_empregado);
            $stmt->execute();
            return $stmt;
        }

        function selectMedia($id_empregado)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from nota_empregado where id_empregado = :id_empregado");
            $stmt->bindValue(":id_empregado", $id_empregado);
            $stmt->execute();
            $quant = $stmt->rowCount();
            $notas = $stmt->fetchAll();
            $sum = 0;
            $media = 0;
            foreach ($notas as $nota) {
                $sum += $nota['nota'];
            }
            if ($quant != 0)  {
                $media = $sum / $quant;
            }
            return $media;
        }
    }
                