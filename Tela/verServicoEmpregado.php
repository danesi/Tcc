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
                        while ($linha = $stmtServicos->fetch()) {
                            $servico = new Servico($linha);
                            ?>
                            <li>
                                <div class="collapsible-header"><b><?=$servico->getNome() ?></b></div>
                                <div class="collapsible-body">
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
                                </div>
                            </li>
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