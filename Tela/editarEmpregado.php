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
        include_once '../Controle/empregadoPDO.php';
        $Empregado = new empregadoPDO();
            $stmt = $Empregado->selectEmpregadoId_usuario($_GET['id']);
                $nomeNormal = new Empregado($stmt->fetch());
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/empregadoControle.php?function=editar" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Editar Empregado</h4>
                        <div class="input-field col s6" hidden>
                            <input type="text" name="id_usuario" value="<?= $nomeNormal->getId_usuario() ?>">
                            <label>id_usuario</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="escolaridade" value="<?= $nomeNormal->getEscolaridade() ?>">
                            <label>escolaridade</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="area_atuacao" value="<?= $nomeNormal->getArea_atuacao() ?>">
                            <label>area_atuacao</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="nota" value="<?= $nomeNormal->getNota() ?>">
                            <label>nota</label>
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

