<?php
    include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/navBar.php';
        ?>
        <?php
        include_once '../Controle/UsuarioPDO.php';
        $Usuario = new usuarioPDO();
            $stmt = $Usuario->selectUsuarioId_usuario($_GET['id']);
                $nomeNormal = new Usuario($stmt->fetch());
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/UsuarioControle.php?function=editar" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Editar Usuario</h4>
                        <div class="input-field col s6" hidden>
                            <input type="text" name="id_usuario" value="<?= $nomeNormal->getId_usuario() ?>">
                            <label>id_usuario</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="nome" value="<?= $nomeNormal->getNome() ?>">
                            <label>nome</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="cpf" value="<?= $nomeNormal->getCpf() ?>">
                            <label>cpf</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="nascimento" value="<?= $nomeNormal->getNascimento() ?>">
                            <label>nascimento</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="telefone" value="<?= $nomeNormal->getTelefone() ?>">
                            <label>telefone</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="email" value="<?= $nomeNormal->getEmail() ?>">
                            <label>email</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="senha" value="<?= $nomeNormal->getSenha() ?>">
                            <label>senha</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="id_endereco" value="<?= $nomeNormal->getId_endereco() ?>">
                            <label>id_endereco</label>
                        </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                        <input type="submit" class="btn corPadrao2" value="Alterar">
                    </div>
                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

