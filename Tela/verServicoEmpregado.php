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
$empregador = new Empregador($empregadorPDO->selectEmpregadorId_usuario($_GET['id'])->fetch());
$usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($empregador->getId_usuario())->fetch());
?>
<main>
    <div class="row" style="margin-top: 1vh;">
        <div class="card col l10 m10 offset-l1 offset-m1 s12">
            <h4 class="textoCorPadrao2 center">Serviços de <?= $usuario->getNome() ?></h4>
            <div class="divider"></div>
            <div class="row">
                <ul class="collapsible popout">
                    <?php
                    $stmtServicos = $servicoPDO->selectServicoId_usuario($empregador->getId_usuario());
                    if ($stmtServicos) {
                        while ($linha = $stmtServicos->fetch()) {
                            $servico = new Servico($linha);
                            ?>
                            <li>
                                <div class="collapsible-header"><b><?= $servico->getNome() ?></b></div>
                                <div class="collapsible-body">
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
                                </div>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="card-title center">Nenhum serviço para esse usuário</div>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="row center">
                <a class="btn orange darken-1 voltar">Voltar</a>
            </div>
        </div>
    </div>
</main>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    $('.collapsible').collapsible();

    $('.voltar').click(function () {
        location.href = document.referrer;
    });
</script>