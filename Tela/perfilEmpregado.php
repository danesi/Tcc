<?php
    include_once '../Base/requerLogin.php';
    include_once "../Modelo/Usuario.php";
    include_once "../Modelo/Empregado.php";
    include_once "../Modelo/Endereco.php";
    include_once "../Controle/EmpregadoPDO.php";
    include_once "../Controle/EnderecoPDO.php";
    $usuario = new Usuario(unserialize($_SESSION['logado']));
    $empregadoPDO = new EmpregadoPDO();
    $enderecoPDO = new EnderecoPDO();
    $empregado = new Empregado($empregadoPDO->selectEmpregadoId_usuario($usuario->getId_usuario())->fetch());
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
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row" style="margin-top: 1vh; padding-right: 5vh">

        <div class="card col s10 offset-s1">
            <h4 class="textoCorPadrao2 center">Perfil de empregado</h4>
            <div class="divider"></div>
            <!--            <div class="center">-->
            <!--                <h6 class="center">É dessa maneira que seu perfil sera mostrado para as outras pessoas</h6>-->
            <!--            </div>-->
            <div class="row">
                <div class="col s3 offset-s1">
                    <div class="card z-depth-3">
                        <div class="card-image">
                            <img src="../<?= $usuario->getFoto() ?>">
                            <span class="card-title"><?= $usuario->getNome() ?></span>
                            <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped center"
                               data-position="bottom" data-tooltip="Nota do empregado">4.5</a>
                        </div>
                        <ul class="card-content center">
                            <h5>Áreas de atuação</h5>
                            <?php $areas = explode(",", $empregado->getArea_atuacao());
                                foreach ($areas as $area) { ?>
                                    <div class="chip"><?= $area ?></div>
                                    <?php
                                }
                            ?>
                            <h5>Ecolaridade</h5>
                            <div class="chip"><?= $empregado->getEscolaridade() ?></div>
                    </div>
                </div>
                <div class="right-divider"></div>
                <div class="card col s6 offset-s1 z-depth-3" style="margin-top: 7%">
                    <div class="card-title center">Editar dados</div>
                    <div class="divider"></div>
                    <br>
                    <form action="../Controle/EmpregadoControle.php?function=editar" method="post" id="formDados">
                        <input name="id_usuario" value="<?= $empregado->getId_usuario() ?>" hidden>
                        <div class="input-field col l10 m5 s12 offset-l1 offset-m1">
                            <select name="escolaridade" required>
                                <option value="Fundamental - Incompleto" <?= $empregado->getEscolaridade() == "Fundamental - Incompleto" ? 'selected' : '' ?>>
                                    Fundamental - Incompleto
                                </option>
                                <option value="Fundamental - Completo" <?= $empregado->getEscolaridade() == "Fundamental - Completo" ? 'selected' : '' ?>>
                                    Fundamental - Completo
                                </option>
                                <option value="Médio - Incompleto" <?= $empregado->getEscolaridade() == "Médio - Incompleto" ? 'selected' : '' ?>>
                                    Médio - Incompleto
                                </option>
                                <option value="Médio - Completo" <?= $empregado->getEscolaridade() == "Médio - Completo" ? 'selected' : '' ?>>
                                    Médio - Completo
                                </option>
                                <option value="Superior - Incompleto" <?= $empregado->getEscolaridade() == "Superior - Incompleto" ? 'selected' : '' ?>>
                                    Superior - Incompleto
                                </option>
                                <option value="Superior - Completo" <?= $empregado->getEscolaridade() == "Superior - Completo" ? 'selected' : '' ?>>
                                    Superior - Completo
                                </option>
                            </select>
                            <label>Escolaridade</label>
                        </div>
                        <div class="input-field col l10 offset-l1">
                            <div class="chips chips-initial"></div>
                            <input name="area_atuacao" value="" hidden class="area">
                        </div>
                        <div class="row center">
                            <input type="submit" class="btn corPadrao2" value="salvar">
                        </div>
                    </form>
                    <div class="row center">
                        <samp>* Para alterar outros dados pode acessar a pagina de <a
                                    href="./perfil.php">perfil</a></samp>
                    </div>
                </div>
                <div class="card col s10 offset-s1 z-depth-3">
                    <div class="card-title center">Endereço</div>
                    <div class="divider"></div>
                    <?php if ($empregadoPDO->verificaEndereco($empregado->getId_usuario())) {
                        $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($usuario->getId_endereco())->fetch());
                        ?>
                        <form action="../Controle/EnderecoControle.php?function=editarEnderecoEmpregado" method="post">
                            <input name="id_endereco" hidden value="<?= $endereco->getId_endereco() ?>">
                            <div class="row">
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="text" name="cep" id="cep" class="validate" required
                                           value="<?= $endereco->getCep() ?>">
                                    <label for="cep" class="active">CEP<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="endereco" id="endereco" class="validate" required
                                           value="<?= $endereco->getEndereco() ?>">
                                    <label for="endereco">Endereço<samp class="red-text">*</samp></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col l5 m5 s10 offset-l1">
                                    <input type="text" name="numero" id="numero" class="validate"
                                           value="<?= $endereco->getNumero() ?>">
                                    <label for="numero">Número</label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="complemento" id="complemento" class="validate"
                                           value="<?= $endereco->getComplemento() ?>">
                                    <label for="complemento">Complemento</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="text" name="cidade" id="cidade" class="validate" required
                                           value="<?= $endereco->getCidade() ?>">
                                    <label for="cidade">Cidade<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="estado" id="estado" class="validate" required
                                           value="<?= $endereco->getEstado() ?>">
                                    <label for="estado">Estado<samp class="red-text">*</samp></label>
                                    <div class="row right">
                                        <samp class="red-text">*</samp><samp class="grey-text"> Campos
                                            obrigatórios</samp>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="center">
                                    <button type="submit" class="blue darken-2 btn">Alterar</button>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <samp>Nenhum endereço encontrado, cadastre um agora para completar seu perfil</samp>
                        <div class="row center">
                            <a href="./registroEndereco.php?id=<?= $empregado->getId_usuario() ?>"
                               class="waves-effect waves-light btn modal-trigger blue darken-2">Cadastrar endereço</a>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
            <div class="row center">
                <a class="btn orange darken-2" href="../index.php">Voltar</a>
            </div>
        </div>

    </div>
    </div>
</main>
<?php
    include_once '../Base/footer.php';
?>
</body>
<div id="modalExcluir" class="modal">
    <div class="modal-content">
        <h4 class="textoCorPadrao2">Atenção</h4>
        <p>Você tem certeza que deseja excluir esse perfil de empregado?</p>
    </div>
    <div class="modal-footer">
        <a href="../Controle/EmpregadoControle.php?function=deletar&id_usuario=<?= $empregado->getId_usuario() ?>"
           class="modal-close waves-effect waves-green btn-flat red darken-2 white-text">Excluir</a>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat orange darken-2 white-text">Cancelar</a>
    </div>
</div>
</html>
<script>

    $('select').formSelect();
    $('.modal').modal();
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
                $('#endereco').val(logradouro).focus();
                $('#numero').val(gia).focus();
            }
        });
    });

    $('.chips').chips({
        autocompleteOptions: {
            data: {
                'Desenvolvedor': null,
                'Trabalhador rual': null,
                'Trabalhador urbano': null,
                'Domestica': null,
                'Pintor': null,
            },
            limit: Infinity,
            minLength: 1
        },
        data: [
            <?php $areas = explode(",", $empregado->getArea_atuacao());
            foreach ($areas as $area) { ?>
            {tag: '<?=$area?>'},
            <?php
            } ?>
            ],
        placeholder: 'Áreas de atuação*',
        secondaryPlaceholder: '+Áreas',
    });

    $("#formDados").submit(function () {
        var value = $('.chips').text();
        var areas = value.split('close');
        $('.area').val(areas);
        return true;
    });
</script>