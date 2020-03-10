<?php
    include_once __DIR__."/../Controle/conexao.php";
    include_once __DIR__."/../Modelo/Fotoservico.php";

    class FotoservicoPDO
    {
        function inserirFotoServico($id_servico, $foto)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into fotoservico values (default, :id_servico, :caminho);');
            $stmt->bindValue(':id_servico', $id_servico);
            $stmt->bindValue(':caminho', $foto);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        function selectFotoPrincipalServico($id_servico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from fotoservico where id_servico = :id_servico order by id_fotoservico asc limit 1");
            $stmt->bindValue(":id_servico", $id_servico);
            $stmt->execute();
            return $stmt;
        }

        function selectTodasFotos($id_servico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from fotoservico where id_servico = :id_servico;");
            $stmt->bindValue(":id_servico", $id_servico);
            $stmt->execute();
            return $stmt;
        }

        function addFoto()
        {
            $id_servico = $_POST['id_servico'];
            if ($_FILES['foto']['name'] != null) {
                $nome_imagem = hash_file('md5', $_FILES['foto']['tmp_name']);
                $ext = explode('.', $_FILES['foto']['name']);
                $extensao = ".".$ext[(count($ext) - 1)];
                $extensao = strtolower($extensao);
                switch ($extensao) {
                    case '.jpeg':
                    case '.jfif':
                    case '.jpg':
                        imagewebp(imagecreatefromjpeg($_FILES['foto']['tmp_name']), __DIR__.'/../Img/Servico/'.$nome_imagem.'.webp', 65);
                        break;
                    case '.svg':
                        move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__.'/../Img/Servico/'.$nome_imagem.'.svg');
                        break;
                    case '.png':
                        $img = imagecreatefrompng($_FILES['foto']['tmp_name']);
                        imagepalettetotruecolor($img);
                        imagewebp($img, __DIR__.'/../Img/Servico/'.$nome_imagem.'.webp', 35);
                        break;
                    case '.webp':
                        imagewebp(imagecreatefromwebp($_FILES['foto']['tmp_name']), __DIR__.'/../Img/Servico/'.$nome_imagem.'.webp', 65);
                        break;
                    case '.bmp':
                        imagewebp(imagecreatefromwbmp($_FILES['foto']['tmp_name']), __DIR__.'/../Img/Servico/'.$nome_imagem.'.webp', 65);
                        break;
                    default:
                        $_SESSION['toast'][] = "Erro ao carregar a foto";
                        header('location: ../Tela/editarServico.php?id_servico='.$id_servico.'&foto');
                        exit(0);
                        break;
                }
            } else {
                $_SESSION['toast'][] = "Erro ao carregar a foto";
                header('location: ../Tela/editarServico.php?id_servico='.$id_servico.'&foto');
            }
            $caminho = 'Img/Servico/'.$nome_imagem.($extensao == '.svg' ? ".svg" : ".webp");
            if ($this->inserirFotoServico($id_servico, $caminho)) {
                $_SESSION['toast'][] = "Foto adicionada";
                header('location: ../Tela/editarServico.php?id_servico='.$id_servico.'&foto');
            } else {
                $_SESSION['toast'][] = "Erro ao adicionar a foto";
                header('location: ../Tela/editarServico.php?id_servico='.$id_servico.'&foto');
            }
        }

        function removerFoto()
        {
            $id_fotoservico = $_GET['id_foto'];
            $servico = $_GET['id_servico'];
            $caminho = $this->selectFotosById($id_fotoservico);
            $pdo = conexao::getConexao();
            if ($this->countFotos($servico)) {
                $stmt = $pdo->prepare("delete from fotoservico where id_fotoservico = :id_fotoservico");
                $stmt->bindValue(":id_fotoservico", $id_fotoservico);
                if ($stmt->execute()) {
                    unlink("../".$caminho);
                    $_SESSION['toast'][] = "Foto removida com sucesso";
                    header('location: ../Tela/editarServico.php?id_servico='.$servico.'&foto');
                } else {
                    $_SESSION['toast'][] = "Ocorreu algum erro ao excluir a foto";
                    header('location: ../Tela/editarServico.php?id_servico='.$servico.'&foto');
                }
            } else {
                $_SESSION['toast'][] = "O serviço precisa ter pelo menos uma foto!";
                header('location: ../Tela/editarServico.php?id_servico='.$servico.'&foto');
            }
        }

        function removerTodasFotos($id_servico)
        {
            $stmtFotos = $this->selectFotosIdServico($id_servico);
            while ($linha = $stmtFotos->fetch()) {
                $foto = new Fotoservico($linha);
                unlink("../".$foto->getCaminho());
            }
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("delete from fotoservico where id_servico = :id_servico");
            $stmt->bindValue(":id_servico", $id_servico);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        function selectFotosIdServico($id_servico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from fotoservico where id_servico = :id_servico");
            $stmt->bindValue(":id_servico", $id_servico);
            $stmt->execute();
            return $stmt;
        }


        function countFotosExclusao($id_servico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("SELECT * from fotoservico where id_servico = :id_servico");
            $stmt->bindValue(":id_servico", $id_servico);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return true;
            } else {
                return false;
            }
        }

        function countFotos($id_servico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("SELECT * from fotoservico where id_servico = :id_servico");
            $stmt->bindValue(":id_servico", $id_servico);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                return false;
            } else {
                return true;
            }
        }

        function selectFotosById($id_fotoservico)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("SELECT caminho FROM fotoservico where id_fotoservico = :id_fotoservico");
            $stmt->bindValue(":id_fotoservico", $id_fotoservico);
            if ($stmt->execute()) {
                $stmt = $stmt->fetch();
                return $stmt['caminho'];
            }
        }
    }