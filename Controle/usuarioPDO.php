<?php

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
        if ($stmt->execute()) {
            $linha = $stmt->fetch(PDO::FETCH_ASSOC);
            $usuario = new usuario($linha);
            $_SESSION['logado'] = serialize($usuario);
            header('location: ../index.php');
        }
    }


    /*inserir*/
    function inserirUsuario()
    {
        $usuario = new usuario($_POST);
        $senha = md5($usuario->getSenha());
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('insert into usuario values(default , :nome , :cpf , :nascimento , :telefone , :email , :senha , :foto, 1);');
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':cpf', $usuario->getCpf());
        $stmt->bindValue(':nascimento', $usuario->getNascimento());
        $stmt->bindValue(':telefone', $usuario->getTelefone());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':senha', $senha);
        $stmt->bindValue(':foto', "");
        if ($stmt->execute()) {
            $ultId = $this->selecUltimoUsuario();
            $SendCadImg = filter_input(INPUT_POST, 'cadastrar', FILTER_SANITIZE_STRING);
            if ($SendCadImg && $_FILES['foto']['name'] != null) {
                $nome_imagem = md5($ultId);
                $ext = explode('.', $_FILES['foto']['name']);
                $extensao = "." . $ext[1];
                $diretorio = '../Img/Perfil/' . $nome_imagem . $extensao;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio)) {
                    $usuario->setFoto('Img/Perfil/' . $nome_imagem . $extensao);
                    $caminho = '/Img/Perfil/' . $nome_imagem . $extensao;
                    $this->alteraNomeFoto($ultId, $caminho);
                } else {
                    header('location: ../Tela/registroEmpregado.php?msg=ErroSalvarFoto');
                }
            } else {
                header('location: ../Tela/registroEmpregado.php?msg=ErroCarregarFoto');
            }
        }
        $ultId = $this->selecUltimoUsuario();
        $empregadoPDO = new EmpregadoPDO();
        $empregadoPDO->inserirEmpregado(new empregado($_POST), $ultId);
    }

    /*inserir*/


    public function alteraNomeFoto($id_usuario, $foto)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set foto = :foto where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':foto', $foto);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function selecUltimoUsuario()
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


    public function selectUsuario()
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


    public function selectUsuarioId_usuario($id_usuario)
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


    public function selectUsuarioNome($nome)
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


    public function selectUsuarioCpf($cpf)
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


    public function selectUsuarioNascimento($nascimento)
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


    public function selectUsuarioTelefone($telefone)
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


    public function selectUsuarioEmail($email)
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


    public function selectUsuarioSenha($senha)
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


    public function selectUsuarioId_endereco($id_endereco)
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


    public function updateUsuario(Usuario $usuario)
    {
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

    public function deleteUsuario($definir)
    {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from usuario where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deletar()
    {
        $this->deleteUsuario($_GET['id']);
        header('location: ../Tela/listarUsuario.php');
    }


    /*editar*/
    function editar()
    {
        $usuario = new Usuario($_POST);
        if ($this->updateUsuario($usuario) > 0) {
            header('location: ../index.php?msg=usuarioAlterado');
        } else {
            header('location: ../index.php?msg=usuarioErroAlterar');
        }
    }
    /*editar*/
    /*chave*/
}
                