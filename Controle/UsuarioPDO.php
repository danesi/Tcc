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
                