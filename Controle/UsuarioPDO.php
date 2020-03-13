<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (realpath('./index.php')) {
        include_once './Controle/conexao.php';
        include_once './Modelo/Empregado.php';
        include_once './Controle/EmpregadoPDO.php';
        include_once './Modelo/Usuario.php';
    } else {
        if (realpath('../index.php')) {
            include_once '../Controle/conexao.php';
            include_once '../Modelo/Empregado.php';
            include_once '../Controle/EmpregadoPDO.php';
            include_once '../Modelo/Usuario.php';
        } else {
            if (realpath('../../index.php')) {
                include_once '../../Controle/conexao.php';
                include_once '../../Modelo/Empregado.php';
                include_once '../../Controle/EmpregadoPDO.php';
                include_once '../../Modelo/Usuario.php';
            }
        }
    }


    class UsuarioPDO
    {


        function login()
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $senha = md5($_POST['senha']);
            $email = $_POST['email'];
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha;");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":senha", $senha);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $linha = $stmt->fetch(PDO::FETCH_ASSOC);
                $usuario = new usuario($linha);
                $_SESSION['logado'] = serialize($usuario);
                $_SESSION['id_usuario'] = $usuario->getId_usuario();
                header('location: ../index.php');
            } else {
                header('location: ../Tela/login.php');
            }
        }

        function logoff()
        {
            session_destroy();
            header("Location: ../index.php");
        }


        /*inserir*/
        function inserirUsuario()
        {
            $usuario = new usuario($_POST);
            $senha = md5($_POST['senha1']);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into usuario values(default , :nome , :cpf , :nascimento , :telefone , :email , :senha , :foto, 0, 1);');
            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':cpf', $usuario->getCpf());
            $stmt->bindValue(':nascimento', $usuario->getNascimento());
            $stmt->bindValue(':telefone', $usuario->getTelefone());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':senha', $senha);
            $stmt->bindValue(':foto', "");
            if ($stmt->execute()) {
                header("Location: ../index.php?msg=sucesso");
            }
        }

        /*inserir*/
        function relacionaEndereco($id_endereco, $id_usuario)
        {
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("update usuario set id_endereco = :endereco where id_usuario = :id_usuario");
            $stmt->bindValue(":endereco", $id_endereco);
            $stmt->bindValue(":id_usuario", $id_usuario);
            if ($stmt->execute()) {
                $usuario = new Usuario($this->selectUsuarioId_usuario($id_usuario));
                $_SESSION['logado'] = serialize($usuario);
                $_SESSION['toast'][] = 'Endereço cadastrado com sucesso!';
                header("Location: ../Tela/perfilEmpregado.php");
            } else {
                $_SESSION['toast'][] = 'Erro ao associar endereço';
                header("Location: ../Tela/perfilEmpregado.php");
            }
        }

        function alteraFoto()
        {
            if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
                $_SESSION['toast'][] = "O tamanho máximo de arquivo é de 15MB";
                header("location: ../Tela/perfil.php");
            } else {
                $fatorReducao = 5;
                $tamanho = filesize($_FILES['imagem']['tmp_name']);
                $qualidade = (100000000 - ($tamanho * $fatorReducao)) / 1000000;
                if ($qualidade < 5) {
                    $qualidade = 5;
                }
                $us = new usuario(unserialize($_SESSION['logado']));
                $antiga = $us->getFoto();
                $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
                $ext = explode('.', $_FILES['imagem']['name']);
                $extensao = ".".$ext[(count($ext) - 1)];
                $extensao = strtolower($extensao);
                switch ($extensao) {
                    case '.jfif':
                    case '.jpeg':
                    case '.jpg':
                        imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__.'/../Img/Perfil/'.$nome_imagem.'.webp', $qualidade);
                        break;
                    case '.svg':
                        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__.'/../Img/Perfil/'.$nome_imagem.'.svg');
                        break;
                    case '.gif':
                        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__.'/../Img/Perfil/'.$nome_imagem.'.gif');
                        break;
                    case '.png':
                        $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                        imagepalettetotruecolor($img);
                        imagewebp($img, __DIR__.'/../Img/Perfil/'.$nome_imagem.'.webp', $qualidade);
                        break;
                    case '.webp':
                        imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__.'/../Img/Perfil/'.$nome_imagem.'.webp', $qualidade);
                        break;
                    case '.bmp':
                        imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__.'/../Img/Perfil/'.$nome_imagem.'.webp', $qualidade);
                        break;
                }
                $conexao = new conexao();
                $pdo = $conexao->getConexao();
                $stmt = $pdo->prepare("update usuario set foto = :foto where id_usuario = :id");
                $stmt->bindValue(':id', $us->getId_usuario());
                $stmt->bindValue(':foto', 'Img/Perfil/'.$nome_imagem.($extensao == '.svg' ? ".svg" : ($extensao == '.gif' ? ".gif" : ".webp")));
                //Verificar se os dados foram inseridos com sucesso
                if ($stmt->execute()) {
                    $us->setFoto('Img/Perfil/'.$nome_imagem.($extensao == '.svg' ? ".svg" : ($extensao == '.gif' ? ".gif" : ".webp")));
                    if ($antiga != 'Img/Perfil/default.png' && $antiga != $us->getFoto()) {
                        unlink('../'.$antiga);
                    }
                    $_SESSION['logado'] = serialize($us);
                    $_SESSION['toast'][] = "Foto alterada com sucesso!";
                    header('Location: ../Tela/perfil.php');
                } else {
                    $_SESSION['toast'][] = "Erro ao cadastrar foto";
                    header('Location: ../Tela/perfil.php');
                }
            }
        }

        function selecUltimoUsuario()
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select max(id_usuario) as id_usuario from usuario;');
            $stmt->execute();
            while ($linha = $stmt->fetch()) {
                $usuario = new usuario($linha);
            }
            return $usuario->getId_usuario();
        }


        function selectUsuario()
        {

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


        function selectUsuarioId_usuario($id_usuario)
        {

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


        function selectUsuarioNome($nome)
        {

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


        function selectUsuarioCpf($cpf)
        {

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


        function selectUsuarioNascimento($nascimento)
        {

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


        function selectUsuarioTelefone($telefone)
        {

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


        function selectUsuarioEmail($email)
        {

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


        function selectUsuarioSenha($senha)
        {

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


        function selectUsuarioId_endereco($id_endereco)
        {

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


        function updateUsuario(Usuario $usuario)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('update usuario set nome = :nome , cpf = :cpf , nascimento = :nascimento , telefone = :telefone , email = :email where id_usuario = :id_usuario;');
            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':cpf', $usuario->getCpf());
            $stmt->bindValue(':nascimento', $usuario->getNascimento());
            $stmt->bindValue(':telefone', $usuario->getTelefone());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
            $stmt->execute();
            return $stmt->rowCount();
        }

        function deleteUsuario($definir)
        {
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('delete from usuario where id_usuario = :definir ;');
            $stmt->bindValue(':definir', $definir);
            $stmt->execute();
            return $stmt->rowCount();
        }

        function deletar()
        {
            $this->deleteUsuario($_GET['id']);
            header('location: ../Tela/listarUsuario.php');
        }

        function editar()
        {
            $usuario = new Usuario($_POST);
            if ($this->updateUsuario($usuario) > 0) {
                $_SESSION['logado'] = serialize(new Usuario($this->selectUsuarioId_usuario($usuario->getId_usuario())->fetch()));
                $_SESSION['toast'][] = "Informaçãos pessoais alteradas!";
                header('location: ../Tela/perfil.php');
            } else {
                $_SESSION['toast'][] = "Erro ao alterar informações pessoais";
                header('location: ../Tela/perfil.php');
            }
        }
    }
                