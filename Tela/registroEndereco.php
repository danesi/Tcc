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
        <div class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1">
            <form action="../Controle/EnderecoControle.php?function=inserirEnderecoEmpregado" method="post">
                <div class="row center">
                    <div class="row">
                        <h4 class="textoCorPadrao2 center">Cadastrar endereço</h4>
                        <div class="divider"></div>
                        <input name="id" hidden value="<?= $_GET['id'] ?>">
                        <div class="row">
                            <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                <input type="text" name="cep" id="cep" class="validate" required>
                                <label for="cep" class="active">CEP<samp class="red-text">*</samp></label>
                            </div>
                            <div class="input-field col s5 m5 s10 offset-s1">
                                <input type="text" name="endereco" id="endereco" class="validate" required>
                                <label for="endereco">Endereço<samp class="red-text">*</samp></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col l5 m5 s10 offset-l1">
                                <input type="text" name="numero" id="numero" class="validate">
                                <label for="numero">Número</label>
                            </div>
                            <div class="input-field col s5 m5 s10 offset-s1">
                                <input type="text" name="complemento" id="complemento" class="validate">
                                <label for="complemento">Complemento</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                <input type="text" name="cidade" id="cidade" class="validate" required>
                                <label for="cidade">Cidade<samp class="red-text">*</samp></label>
                            </div>
                            <div class="input-field col s5 m5 s10 offset-s1">
                                <input type="text" name="estado" id="estado" class="validate" required>
                                <label for="estado">Estado<samp class="red-text">*</samp></label>
                                <div class="row right">
                                    <samp class="red-text">*</samp><samp class="grey-text"> Campos
                                        obrigatórios</samp>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                        <input type="submit" class="btn corPadrao2" value="Cadastrar">
                    </div>
            </form>
        </div>
    </div>
</main>
<?php
    include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    $("#cep").mask("00000-000");
    $('#cep').blur(function () {
        cep = $(this).val();
        cep = cep.replace(/\D/g, '');
        $.ajax({
            url: 'https://viacep.com.br/ws/' + cep + '/json/unicode',
            dataType: 'json',
            success: function ({localidade, uf, complemento, logradouro, gia}) {
                $('#cidade').val(localidade).focus();
                $('#estado').val(uf).focus();
                $('#complemento').val(complemento).focus();
                $('#numero').val(gia).focus();
                $('#endereco').val(logradouro).focus();
            }
        })
    });
</script>

