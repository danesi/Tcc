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
include_once "../Modelo/Empregado.php";
include_once "../Controle/UsuarioPDO.php";
include_once "../Controle/ServicoPDO.php";
include_once "../Controle/EnderecoPDO.php";
include_once "../Controle/EmpregadorPDO.php";
include_once "../Controle/EmpregadoPDO.php";
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
    <link rel="stylesheet" href="../css/slider.css">
<body class="homeimg">
<?php
include_once '../Base/iNav.php';
$usuarioPDO = new UsuarioPDO();
$servicoPDO = new ServicoPDO();
$enderecoPDO = new EnderecoPDO();
$fotoservicoPDO = new FotoservicoPDO();
$empregadorPDO = new EmpregadorPDO();
$servico = new Servico($servicoPDO->selectServicoId_servico($_GET['id'])->fetch());
$logado = new Usuario(unserialize($_SESSION['logado']));
$usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($servico->getId_usuario())->fetch());
$empregado = new Empregador($empregadorPDO->selectEmpregadorId_usuario($usuario->getId_usuario())->fetch());
?>
<main>
    <div id="user" hidden>
        <div class="nome">Proprietário <?= $usuario->getNome() ?></div>
        <span hidden class="id"><?= $empregado->getId_usuario() ?></span>
    </div>

    <div class="row" style="margin-top: 1vh;">
        <div class="card col l10 m10 offset-l1 offset-m1 s12">
            <h4 class="textoCorPadrao2 center">Serviço <?= $servico->getNome() ?></h4>
            <div class="divider"></div>
            <div class="card-title center">Fotos</div>
            <div class="row foto">
                <div class="slideshow-container">
                    <?php
                    $stmtFotos = $fotoservicoPDO->selectTodasFotos($servico->getId_servico());
                    $num = $stmtFotos->rowCount();
                    while ($linha = $stmtFotos->fetch()) {
                        $fotos = new Fotoservico($linha);
                        ?>
                        <div class="mySlides fade">
                            <img class="materialboxed imgBoxed" src="../<?= $fotos->getCaminho() ?>" style="width:100%">
                        </div>
                        <?php
                    }
                    ?>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <div style="text-align:center">
                    <?php
                    for ($i = 1; $i <= $num; $i++) {
                        echo '<span class="dot" onclick="currentSlide(' . $i . ')"></span>';
                    }
                    ?>
                </div>
            </div>
            <div class="card-title center">Perfil</div>
            <div class="divider"></div>
            <br>
            <div class="row">
                <?php
                $foto = new Fotoservico($fotoservicoPDO->selectFotoPrincipalServico($servico->getId_servico())->fetch());
                ?>
                <div class="col s10 m6 l3 offset-s1 offset-l1 center">
                    <div class="card bot z-depth-3">
                        <div class="card-image ">

                            <div class="center-block"
                                 style="background-image: url('<?= "../" . $foto->getCaminho(); ?>');
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
                    <?php
                    $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($servico->getId_endereco())->fetch());
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
<?php
include_once "../Base/chat2.php";
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

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
</script>