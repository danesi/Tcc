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
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row" style="margin-top: 1vh;">
        <form action="../Controle/EmpregadorControle.php?function=inserirEmpregador" class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1" method="post">
            <div class="row center">
                <h4 class="textoCorPadrao2">Cadastrar empregador</h4>
                <div class="divider"></div>
                <br>
                <div class="row">
                    <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                        <input type="text" name="razao_social" id="razao_social">
                        <label for="razao_social">Razão social <samp class="red-text">*</samp></label>
                    </div>
                    <div class="input-field col s5 m5 s10 offset-s1">
                        <input type="text" name="cnpj" id="cnpj">
                        <label for="cnpj">CNPJ <samp class="red-text">*</samp></label>
                        <div class="row right">
                            <samp class="red-text">*</samp><samp class="grey-text"> Campos obrigatórios</samp>
                        </div>
                    </div>
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
<script>
    $("#cnpj").mask("00.000.000/0000-00");
</script>

