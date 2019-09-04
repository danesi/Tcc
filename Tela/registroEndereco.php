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
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/enderecoControle.php?function=inserirEndereco" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Cadastrar Endereco</h4>
                        <div class="input-field col s6">
                            <input type="text" name="endereco">
                            <label>endereco</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="cep">
                            <label>cep</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="numero">
                            <label>numero</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="complemento">
                            <label>complemento</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="estado">
                            <label>estado</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="cidade">
                            <label>cidade</label>
                        </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                        <input type="submit" class="btn corPadrao2" value="Cadastrar">
                    </div>
                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

