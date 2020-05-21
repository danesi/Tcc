<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once '../Base/requerLogin.php';
    include_once "../Modelo/Usuario.php";
    include_once "../Modelo/Servico.php";
    include_once "../Modelo/Endereco.php";
    include_once "../Modelo/Empregador.php";
    include_once "../Modelo/Fotoservico.php";
    include_once "../Controle/ServicoPDO.php";
    include_once "../Controle/EnderecoPDO.php";
    include_once "../Controle/EmpregadorPDO.php";
    include_once "../Controle/FotoservicoPDO.php";
    include_once "../Controle/chatPDO.php";
    $chatPDO = new chatPDO();
    $usuario = new Usuario(unserialize($_SESSION['logado']));
    $servicoPDO = new ServicoPDO();
    $enderecoPDO = new EnderecoPDO();
    $empregadorPDO = new EmpregadorPDO();
    $fotoservicoPDO = new FotoservicoPDO();
    $empregador = new Empregador($empregadorPDO->selectEmpregadorId_usuario($usuario->getId_usuario())->fetch());
    $stmtServicos = $servicoPDO->selectServicoId_usuario($usuario->getId_usuario());
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
    <div class="row" style="margin-top: 1vh;">
        <div class="card col l10 m10 offset-l1 offset-m1 s12">
            <h4 class="textoCorPadrao2 center">Perfil dos seus serviços</h4>
            <div class="divider"></div>
            <div class="row center">
                <?php while ($linha = $stmtServicos->fetch()) {
                    $servico = new Servico($linha);
                    $foto = new Fotoservico($fotoservicoPDO->selectFotoPrincipalServico($servico->getId_servico())->fetch());
                    ?>
                    <div class="col s10 m6 l3 offset-s1">
                        <div class="card bot z-depth-3">
                            <div class="card-image ">

                                <div class="center-block"
                                     style="background-image: url('<?php echo "../".$foto->getCaminho(); ?>');
                                             height: 250px; max-width: auto;
                                             background-position: center;
                                             background-size: cover;
                                             background-repeat: no-repeat;
                                             object-fit: cover;
                                             object-position: center;
                                             ">
                                    <?php if ($servico->getStatus() == "pendente") { ?>
                                        <a href="#modalPendente" class="modal-trigger">
                                            <div class="chip orange black-text right"
                                                 style="position: relative; margin-top: 1vh">
                                                Pendente
                                            </div>
                                        </a>
                                    <?php } ?>
                                    <?php if ($servico->getStatus() == "recusado") { ?>
                                        <a href="#modalRecusado" class="btnRecusado"
                                           motivo="<?= $servico->getMotivo() ?>">
                                            <div class="chip red black-text right"
                                                 style="position: relative; margin-top: 1vh">
                                                Recusado
                                            </div>
                                        </a>
                                    <?php } ?>
                                    <?php if ($servico->getStatus() == "aceito") { ?>
                                        <div class="chip green black-text right"
                                             style="position: relative; margin-top: 1vh">
                                            Aceito
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div id="divider" class="divider"></div>
                            <div class="card-content">
                                <div class="card-title"
                                     style="margin-top: -2vh"><?php echo $servico->getNome(); ?></div>
                                <div class="divider"></div>
                                <div class="row">
                                    <h5>Descrição</h5>
                                    <?php echo $servico->getDescricao();
                                    ?>
                                    <h5>Salário mensal</h5>
                                    <div class="chip">R$ <?= $servico->getSalario() ?></div>
                                    <br>
                                    <br>
                                    <div class="row center">
                                        <a href="#modalexcluirServico"
                                           class="btn red darken-2 modal-trigger btnExcluirServico"
                                           id_servico="<?= $servico->getId_servico() ?>">Excluir</a>
                                        <a href="./editarServico.php?id_servico=<?= $servico->getId_servico() ?>&info"
                                           class="btn blue darken-2">Editar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
            </div>
            <div class="fixed-action-btn" <?= $chatPDO->verificaExistChat($usuario->getId_usuario()) ? "style='margin-bottom: 11vh'" : ""?>>
                <a class="btn-floating btn-large red initLoader " href="./registroServico.php">
                    <i class="large material-icons blue darken-1">add</i>
                </a>
            </div>
        </div>

</main>
<div id="modalexcluirServico" class="modal">
    <form action="../Controle/ServicoControle.php?function=excluir" method="post">
        <input type="text" class="inputIdServico" name="id_servico" value="" hidden>
        <div class="modal-content">
            <h4 class="textoCorPadrao2">Atenção</h4>
            <p>Você realmente deseja excluir esse serviço</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn blue darken-2">Cancelar</a>
            <button type="submit" class="btn red darken-2">Excluir</button>
        </div>
    </form>
</div>
<div id="modalPendente" class="modal">
    <div class="modal-content">
        <h4>Serviço pendente</h4>
        <p>Esse serviço encontra-se pendente, pois ele ainda não foi avaliado por nenhum de nosso administradores.</p>
        <p>Portanto ele não estará visível para os outros usuários até que um adiministrador de o parecer.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat blue darken-1 white-text">OK</a>
    </div>
</div>
<div id="modalRecusado" class="modal">
    <div class="modal-content">
        <h4>Serviço recusado</h4>
        <p>Infelizmente esse serviço foi interpretado como impróprio para nosso site, portanto ele ficará oculto para os
            usuário</p>
        <p>Nossos administradores identificaram os segintes motivos</p>
        <p><b>Motivo:</b>
        <p id="motivo"></p></p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat blue darken-1 white-text">OK</a>
    </div>
</div>
<?php
    include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    $('.tooltipped').tooltip();
    $('.modal').modal();

    $('.btnExcluirServico').click(function () {
        id_servico = $(this).attr('id_servico');
        $('.inputIdServico').val(id_servico);
    });

    $('.btnRecusado').click(function () {
        var motivo = $(this).attr('motivo');
        $('#motivo').html(motivo);
        $('#modalRecusado').modal('open');
    });
</script>