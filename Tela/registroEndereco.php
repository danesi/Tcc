<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
    include_once '../Base/header.php';
    include_once '../Controle/EnderecoPDO.php';
    include_once '../Modelo/Usuario.php';
    include_once '../Modelo/Endereco.php';
    ?>
<body class="homeimg">
<?php
include_once '../Base/iNav.php';
?>
<main>
    <div class="row" style="margin-top: 1vh;">
        <div class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1">
            <?php
            if (isset($_GET['id_usuario'])) {
            ?>
            <form action="../Controle/EnderecoControle.php?function=inserirEnderecoEmpregado" method="post">
                <input name="id" hidden value="<?= $_GET['id_usuario'] ?>">
                <?php
                }
                if (isset($_GET['id_servico'])) { ?>
                <form action="../Controle/EnderecoControle.php?function=inserirEnderecoServico" method="post">
                    <input name="id" hidden value="<?= $_GET['id_servico'] ?>">
                    <?php }
                    ?>
                    <div class="row">
                        <div class="row">
                            <h4 class="textoCorPadrao2 center">Cadastrar endereço</h4>
                            <div class="divider"></div>
                            <?php
                            if (isset($_GET['id_servico'])) {
                                $usuario = new Usuario(unserialize($_SESSION['logado']));
                                $enderecoPDO = new EnderecoPDO();
                                $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($usuario->getId_endereco())->fetch());
                                ?>
                                <div class="row" style="margin-left: 12vh">
                                    <div class="row">
                                        <p>
                                            <label>
                                                <input class="with-gap" name="address" type="radio" checked id="old" value="old"/>
                                                <span class="black-text">Usar endereço já cadastrado</span>
                                                <div class="row col s7 offset-s2" id="oldAddress">
                                                    <ul class="collection with-header">
                                                        <li class="collection-item">
                                                            <div><b>Endereço</b>
                                                                <div class="secondary-content black-text">
                                                                    <?= $endereco->getEndereco() ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div><b>CEP</b>
                                                                <div class="secondary-content black-text">
                                                                    <?= $endereco->getCep() ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div><b>Número</b>
                                                                <div class="secondary-content black-text">
                                                                    <?= $endereco->getNumero() ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div><b>Complemento</b>
                                                                <div class="secondary-content black-text">
                                                                    <?= $endereco->getComplemento() ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div><b>UF</b>
                                                                <div class="secondary-content black-text">
                                                                    <?= $endereco->getEstado() ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="collection-item">
                                                            <div><b>Cidade</b>
                                                                <div class="secondary-content black-text">
                                                                    <?= $endereco->getCidade() ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </label>
                                        </p>
                                    </div>
                                    <div class="row">
                                        <p>
                                            <label>
                                                <input class="with-gap" name="address" type="radio" id="new" value="new"/>
                                                <span class="black-text">Cadastrar novo</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="row" id="newAddress" <?=isset($_GET['id_servico'])?'hidden':''?>>
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="text" name="cep" id="cep">
                                    <label for="cep" class="active">CEP<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="endereco" id="endereco">
                                    <label for="endereco">Endereço<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col l5 m5 s10 offset-s1 offset-l1">
                                    <input type="text" name="numero" id="numero">
                                    <label for="numero">Número</label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="complemento" id="complemento">
                                    <label for="complemento">Complemento</label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="text" name="cidade" id="cidade">
                                    <label for="cidade">Cidade<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="estado" id="estado">
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

    $("#new").click(function () {
        $('#oldAddress').attr("hidden", true);
        $('#newAddress').removeAttr("hidden");
        $('#cep').attr("required", true);
        $('#endereco').attr("required", true);
        $('#cidade').attr("required", true);
        $('#estado').attr("required", true);
    });

    $('#old').click(function () {
        $('#newAddress').attr("hidden", true);
        $('#oldAddress').removeAttr("hidden");
        $('#cep').removeAttr("required");
        $('#endereco').removeAttr("required");
        $('#cidade').removeAttr("required");
        $('#estado').removeAttr("required");
    });
</script>

