<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once '../Base/requerLogin.php';
    include_once "../Modelo/Usuario.php";
    include_once "../Modelo/Empregado.php";
    include_once "../Modelo/Endereco.php";
    include_once "../Controle/EmpregadoPDO.php";
    include_once "../Controle/EnderecoPDO.php";
    include_once "../Controle/UsuarioPDO.php";

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
    $usuarioPDO = new UsuarioPDO();
    $user = new Usuario($usuarioPDO->selectUsuarioId_usuario($_GET['id'])->fetch());
    $empregadoPDO = new EmpregadoPDO();
    $enderecoPDO = new EnderecoPDO();
    $empregado = new Empregado($empregadoPDO->selectEmpregadoId_usuario($_GET['id'])->fetch());
?>
<main>
    <div class="row">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <h4 class="textoCorPadrao2 center">Empregado</h4>
            <div class="divider"></div>
            <div class="row">
                <div class="col l3 offset-l1 m3 offset-m1 s10 offset-s1">
                    <div class="card z-depth-3">
                        <div class="card-image">
                            <img src="../<?= $user->getFoto() ?>">
                            <span class="card-title"><?= $user->getNome() ?></span>
                            <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped center"
                               data-position="bottom" data-tooltip="Nota do empregado"><?=$empregado->getNota() == null ? '0' : $empregado->getNota()?></a>
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
                <div class="card col l6 m6 offset-m1 offset-l1 s10 offset-s1 z-depth-3">
                    <div class="card-title center">Endereço</div>
                    <div class="divider"></div>
                    <?php if ($empregadoPDO->verificaEndereco($empregado->getId_usuario())) {
                        $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($user->getId_endereco())->fetch());
                    ?>
                    <div class="input-field col s10 offset-s1">
                        <input type="text" name="cep" id="cep" class="validate" required
                               value="<?= $endereco->getCep() ?>">
                        <label for="cep" class="active">CEP</label>
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <input type="text" name="endereco" id="endereco" class="validate" required
                               value="<?= $endereco->getEndereco() ?>">
                        <label for="endereco">Endereço</label>
                    </div>

                    <div class="input-field col s10 offset-s1">
                        <input type="text" name="numero" id="numero" class="validate"
                               value="<?= $endereco->getNumero() ?>">
                        <label for="numero">Número</label>
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <input type="text" name="complemento" id="complemento" class="validate"
                               value="<?= $endereco->getComplemento() ?>">
                        <label for="complemento">Complemento</label>
                    </div>

                    <div class="input-field col s10 offset-s1">
                        <input type="text" name="cidade" id="cidade" class="validate" required
                               value="<?= $endereco->getCidade() ?>">
                        <label for="cidade">Cidade</label>
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <input type="text" name="estado" id="estado" class="validate" required
                               value="<?= $endereco->getEstado() ?>">
                        <label for="estado">Estado</label>
                    </div>
                </div>
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