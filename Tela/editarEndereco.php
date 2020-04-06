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
        include_once '../Controle/EnderecoPDO.php';
        $Endereco = new enderecoPDO();
            $stmt = $Endereco->selectEnderecoId_endereco($_GET['id']);
                $nomeNormal = new Endereco($stmt->fetch());
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/EnderecoControle.php?function=editar" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Editar Endereco</h4>
                        <div class="input-field col s6" hidden>
                            <input type="text" name="id_endereco" value="<?= $nomeNormal->getId_endereco() ?>">
                            <label>id_endereco</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="endereco" value="<?= $nomeNormal->getEndereco() ?>">
                            <label>endereco</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="cep" value="<?= $nomeNormal->getCep() ?>">
                            <label>cep</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="numero" value="<?= $nomeNormal->getNumero() ?>">
                            <label>numero</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="complemento" value="<?= $nomeNormal->getComplemento() ?>">
                            <label>complemento</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="estado" value="<?= $nomeNormal->getEstado() ?>">
                            <label>estado</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="cidade" value="<?= $nomeNormal->getCidade() ?>">
                            <label>cidade</label>
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

