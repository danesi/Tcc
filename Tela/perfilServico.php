<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once "../Modelo/Usuario.php";
    include_once "../Modelo/Servico.php";
    include_once "../Modelo/Endereco.php";
    include_once "../Modelo/Empregador.php";
    include_once "../Controle/ServicoPDO.php";
    include_once "../Controle/EnderecoPDO.php";
    include_once "../Controle/EmpregadorPDO.php";
    $usuario = new Usuario(unserialize($_SESSION['logado']));
    $servicoPDO = new ServicoPDO();
    $enderecoPDO = new EnderecoPDO();
    $empregadorPDO = new EmpregadorPDO();
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
        <div class="card col s10 offset-s1">
            <h4 class="textoCorPadrao2 center">Perfil dos seus serviços</h4>
            <div class="divider"></div>
            <div class="row center">
                <?php while ($linha = $stmtServicos->fetch()) {
                    $servico = new Servico($linha);
                    ?>
                    <div class="col s3">
                        <div class="card z-depth-3">
                            <div class="card-image">
                                <img src="../<?= $servico->getFoto() ?>" height="270" width="100">
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
                                    <a href="" class="btn red darken-2">Excluir</a>
                                    <a href="./editarServico.php?id_servico=<?= $servico->getId_servico() ?>&info" class="btn blue darken-2">Editar</a>
                                </div>
                            </ul>

                        </div>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
</main>
<?php
    include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    $('.tooltipped').tooltip();
</script>