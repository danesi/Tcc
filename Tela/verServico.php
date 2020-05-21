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
    include_once "../Controle/UsuarioPDO.php";
    include_once "../Controle/ServicoPDO.php";
    include_once "../Controle/EnderecoPDO.php";
    include_once "../Controle/EmpregadorPDO.php";
    include_once "../Controle/FotoservicoPDO.php";
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
    $servicoPDO = new ServicoPDO();
    $enderecoPDO = new EnderecoPDO();
    $empregadorPDO = new EmpregadorPDO();
    $fotoservicoPDO = new FotoservicoPDO();
    $empregador = new Empregador($empregadorPDO->selectEmpregadorId_usuario($usuario->getId_usuario())->fetch());
    $servico = new Servico($servicoPDO->selectServicoId_servico($_GET['id'])->fetch());
?>
<main>
    <div class="row" style="margin-top: 1vh;">
        <div class="card col l10 m10 offset-l1 offset-m1 s12">
            <h4 class="textoCorPadrao2 center">Serviço <?= $servico->getNome() ?></h4>
            <div class="divider"></div>
            <div class="card-title center">Fotos</div>
            <div class="row hide-on-small-only" style="margin-left: -32vh; margin-top: -10vh">
                <div class="carousel center" style="z-index: 10000">
                    <?php
                        $stmtFotos = $fotoservicoPDO->selectTodasFotos($servico->getId_servico());
                        while ($linha = $stmtFotos->fetch()) {
                            $fotos = new Fotoservico($linha);
                            ?>
                            <a class="carousel-item">
                                <img class="materialboxed" src="<?= '../'.$fotos->getCaminho() ?>"
                                     style="
                             height: 250px; max-width: auto;
                             background-position: center;
                             background-size: cover;
                             background-repeat: no-repeat;
                             object-fit: cover;
                             object-position: center;">
                            </a>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="hide-on-med-and-up">
                <div class="slider">
                    <ul class="slides">
                        <?php
                            $stmtFotos = $fotoservicoPDO->selectTodasFotos($servico->getId_servico());
                            while ($linha = $stmtFotos->fetch()) {
                                $fotos = new Fotoservico($linha);
                                ?>
                                <li>
                                    <img src="<?= '../'.$fotos->getCaminho() ?>"
                                         style="
                                         width: 100%;
                                         height: 500px; max-width: 100%;
                                         background-position: center;
                                         background-size: cover;
                                         background-repeat: no-repeat;
                                         object-fit: cover;
                                         object-position: center;"
                                    >
                                </li>
                                <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="card-title center">Perfil</div>
            <div class="divider"></div>
            <br>
            <div class="row center">
                <?php
                    $foto = new Fotoservico($fotoservicoPDO->selectFotoPrincipalServico($servico->getId_servico())->fetch());
                ?>
                <div class="col s10 m6 l3 offset-s1 offset-l1">
                    <div class="card bot z-depth-3">
                        <div class="card-image ">

                            <div class="center-block"
                                 style="background-image: url('<?= "../".$foto->getCaminho(); ?>');
                                         height: 250px; max-width: auto;
                                         background-position: center;
                                         background-size: cover;
                                         background-repeat: no-repeat;
                                         object-fit: cover;
                                         object-position: center;
                                         ">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col l6 m6 offset-m1 offset-l1 s10 offset-s1 z-depth-3">
                    <div class="card-title center">Endereço</div>
                    <div class="divider"></div>
                    <?php
                        $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($servico->getId_endereco())->fetch());
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
            </div>
            <div class="row center">
                <a class="btn orange darken-1 voltar">Voltar</a>
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
    $('.carousel').carousel();
    $('.materialboxed').materialbox();
    $('.slider').slider();

    $('.btnExcluirServico').click(function () {
        id_servico = $(this).attr('id_servico');
        $('.inputIdServico').val(id_servico);
    });

    $('.btnRecusado').click(function () {
        var motivo = $(this).attr('motivo');
        $('#motivo').html(motivo);
        $('#modalRecusado').modal('open');
    });

    $('.voltar').click(function () {
        location.href = document.referrer;
    });
</script>