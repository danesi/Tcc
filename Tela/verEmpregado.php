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
$logado = new Usuario(unserialize($_SESSION['logado']));
$empregadoPDO = new EmpregadoPDO();
$enderecoPDO = new EnderecoPDO();
$empregado = new Empregado($empregadoPDO->selectEmpregadoId_usuario($_GET['id'])->fetch());
$media = $empregadoPDO->selectMedia($empregado->getId_usuario());
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
                            <span hidden class="id"><?= $empregado->getId_usuario() ?></span>
                            <span hidden class="nome"><?= $user->getNome() ?></span>
                            <div class="center-block"
                                 style="background-image: url('<?= "../" . $user->getFoto(); ?>');
                                         height: 250px; max-width: auto;
                                         background-position: center;
                                         background-size: cover;
                                         background-repeat: no-repeat;
                                         object-fit: cover;
                                         object-position: center;
                                         ">
                            </div>
                            <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped center"
                               data-position="bottom" data-tooltip="Nota do empregado"><?= $media ?></a>
                        </div>
                        <div id="divider" class="divider"></div>
                        <div class="card-content center">
                            <div class="card-title"
                                 style="margin-top: -2vh"><?php echo $user->getNome(); ?></div>
                            <div class="divider"></div>
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
                </div>
                <div class="card col l6 m6 offset-m1 offset-l1 s10 offset-s1 z-depth-3">

                    <?php if ($empregadoPDO->verificaEndereco($empregado->getId_usuario())) {
                    $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($user->getId_endereco())->fetch());
                    ?>
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <div class="card-title center">Endereço</div>
                        </li>
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
                }
                if ($_GET['id'] != $logado->getId_usuario()) {
                    ?>
                    <div id="avaliacao">
                        <div class="card col l6 m6 offset-m1 offset-l1 s10 offset-s1 z-depth-3">
                            <ul class="collection with-header">
                                <li class="collection-header">
                                    <div class="card-title center">Avaliação</div>
                                </li>
                                <?php
                                $nota = $empregadoPDO->selectAvaliacaoId_usuario($logado->getId_usuario(), $empregado->getId_usuario());
                                if ($nota->rowCount() > 0) {
                                    ?>
                                    <li class="collection-item">
                                        <p class="center">Sua avaliação foi de nota: <?= $nota->fetch()['nota'] ?></p>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="collection-item">
                                        <p class="center">Avalie esse empregado, dando uma nota de 0 - 10</p>
                                        <div class="input-field col s10 offset-s1 offset-l1">
                                            <input type="number" name="nota" id="nota" min="0" max="10">
                                            <label for="nota">Nota</label>
                                        </div>
                                        <div class="row center">
                                            <button class="btn blue darken-1 avaliar">Avaliar</button>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
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

    $(".avaliar").click(function () {
        var nota = $('#nota').val();
        if (nota !== null && nota !== '') {
            $.ajax({
                url: '../Controle/EmpregadoControle.php?function=avaliar',
                type: 'post',
                data: {
                    nota: nota,
                    id_empregado: <?= $_GET['id'] ?>,
                    id_usuario: <?= $logado->getId_usuario() ?>
                },
                success: function (data) {
                    if (data > 0) {
                        M.toast({html: "Avaliação registrada"});
                        $("#avaliacao").load(window.location.href + " #avaliacao");
                    } else {
                        M.toast({html: "Erro ao salvar a avaliação"});
                        M.toast({html: "tente novamente mais tarde"});
                    }
                }
            })
        } else {
            M.toast({html: "Preencha a nota!"})
        }
    });
</script>