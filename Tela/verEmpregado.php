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
    <title>EasyJobs</title>
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
                        <div class="card-image" id="user">
                            <span hidden class="id"><?=$empregado->getId_usuario()?></span>
                            <img src="../<?= $user->getFoto() ?>">
                            <span class="card-title nome" ><?= $user->getNome() ?></span>
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

                    <?php if ($empregadoPDO->verificaEndereco($empregado->getId_usuario())) {
                        $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($user->getId_endereco())->fetch());
                    ?>
                    <ul class="collection with-header">
                        <li class="collection-header"><div class="card-title center">Endereço</div></li>
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
            <div class="row center">
                <a class="voltar btn orange darken-1">Voltar</a>
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
<?php
 include_once "../Base/chat2.php";
?>
<script>

    $('select').formSelect();
    $('.modal').modal();

    $("#formDados").submit(function () {
        var value = $('.chips').text();
        var areas = value.split('close');
        $('.area').val(areas);
        return true;
    });

    $('.voltar').click(function () {
        location.href = document.referrer;
    });

    $('#btnChat').hide();
</script>