<?php
include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EasyJobs</title>
    <?php
    include_once '../Base/header.php';
    include_once '../Controle/UsuarioPDO.php';
    include_once '../Controle/EmpregadorPDO.php';
    include_once '../Controle/ServicoPDO.php';
    include_once '../Controle/EnderecoPDO.php';
    include_once '../Modelo/Empregador.php';
    include_once '../Modelo/Usuario.php';
    include_once '../Modelo/Servico.php';
    include_once '../Modelo/Endereco.php';
    $usuarioPDO = new UsuarioPDO();
    $empregadoPDO = new EmpregadoPDO();
    $servicoPDO = new ServicoPDO();
    $enderecoPDO = new EnderecoPDO();
    ?>
<body class="homeimg">
<?php
include_once '../Base/iNav.php';
$usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($_GET['id'])->fetch());
$endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($usuario->getId_endereco())->fetch());
$stmtEmpregado = $empregadoPDO->selectEmpregadoId_usuario($usuario->getId_usuario());
if ($stmtEmpregado) {
    $empregado = new Empregado($stmtEmpregado->fetch());
}
?>
<main>
    <div class="row " style="margin-top: 5vh;">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <div class="card-title center"><?= $usuario->getNome() ?></div>
            <div class="divider"></div>
            <div class="row">
                <div class="col l3 offset-l1 m3 offset-m1 s10 offset-s1">
                    <div class="card z-depth-3">
                        <div class="card-image">
                            <img src="../<?= $usuario->getFoto() ?>">
                            <span class="card-title"><?= $usuario->getNome() ?></span>
                            <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped center"
                               data-position="bottom" data-tooltip="Nota do empregado">4.5</a>
                        </div>
                        <ul class="card-content center">
                            <?php
                            if (isset($empregado)) {
                                $areas = explode(",", $empregado->getArea_atuacao());
                                echo '<h5>Áreas de atuação</h5>';
                                foreach ($areas as $area) { ?>
                                    <div class="chip"><?= $area ?></div>
                                    <?php
                                }
                                ?>
                                <h5>Ecolaridade</h5>
                                <div class="chip"><?= $empregado->getEscolaridade() ?></div>
                                <?php
                            } else {
                                ?>
                                <div class="card-title">Esse usuário não possui perfil de empregado</div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <div class="card col l6 offset-l1 m6 offset-m1 s10 offset-s1">
                    <div class="card-title center">
                        Serviços
                    </div>
                    <div class="collection">
                        <?php
                        $stmtServicos = $servicoPDO->selectServicoId_usuario($usuario->getId_usuario());
                        if ($stmtServicos) {
                            while ($linha = $stmtServicos->fetch()) {
                                $servico = new Servico($linha);
                                ?>
                                <a href="./verServico.php?id=<?= $servico->getId_servico() ?>"
                                   class="collection-item black-text"><b><?= $servico->getNome() ?></b></a>
                                <?php
                            }
                        } else {
                            ?>
                            <p class="center">Nenhum serviço para esse usuário </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="card col l6 offset-l1 m6 offset-m1 s10 offset-s1">
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
    </div>
</main>
</body>
<?php
include_once '../Base/footer.php';
?>
</html>
<script>
    $('.voltar').click(function () {
        location.href = document.referrer;
    });
</script>
