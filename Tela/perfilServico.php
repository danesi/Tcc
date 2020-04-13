<?php
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
                    <div class="col l3 m3 s10 offset-s1">
                        <div class="card z-depth-3">
                            <div class="card-image">
                                <img src="../<?= $foto->getCaminho() ?>" height="270" width="100">
                                <span class="card-title black-text"><?= $servico->getNome() ?></span>
                                <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped"
                                   data-position="bottom" data-tooltip="Nota do serviço">4.5</a>
                            </div>
                            <ul class="card-content">
                                <h5>Descrição</h5>
                                <?php echo $servico->getDescricao();
                                ?>
                                <h5>Salário mensal</h5>
                                <div class="chip">R$ <?= $servico->getSalario() ?></div>
                                <br>
                                <br>
                                <div class="row center">
                                    <a href="#modalexcluirServico" class="btn red darken-2 modal-trigger btnExcluirServico" id_servico="<?=$servico->getId_servico()?>">Excluir</a>
                                    <a href="./editarServico.php?id_servico=<?= $servico->getId_servico() ?>&info"
                                       class="btn blue darken-2">Editar</a>
                                </div>
                            </ul>

                        </div>
                    </div>
                    <?php
                } ?>
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
</script>