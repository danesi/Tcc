<!DOCTYPE html>
            <?php
            if(isset($_SESSION['logado'])){
                header('location: ../Tela/home.php');
            }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <?php
        include_once '../Base/header.php';
        ?>
    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="row" style="margin-top: 10vh;">
                <form action="../Controle/UsuarioControle.php?function=login" class="card col l4 offset-l4 m8 offset-m2 s10 offset-s1" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Faça Login</h4>
                        <div class="input-field col s10 offset-s1">
                            <input type="email" name="email">
                            <label>Email</label>
                        </div>
                        <div class="input-field col s10 offset-s1">
                            <input type="password" name="senha">
                            <label>Senha</label>
                        </div>
                    </div>
                    <div class="row center">
                        <input type="submit" class="btn corPadrao2" value="Entrar">
                    </div>
                    <div class="row center">
                        <a href="registroUsuario.php" class="blue-text" >Cadastre-se</a>
                    </div>
                        <div class='row'>
                            <?php
                            if (isset($_GET['msg'])) {
                                if ($_GET['msg'] == "erro") {
                                    echo "LOGIN OU SENHA INCORRETOS!";
                                }
                            }
                            ?>
                        </div>
                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

