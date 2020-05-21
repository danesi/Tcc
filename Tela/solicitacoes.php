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
        include_once '../Controle/ServicoPDO.php';
        include_once '../Controle/EnderecoPDO.php';
        include_once '../Controle/UsuarioPDO.php';
        include_once '../Controle/EmpregadorPDO.php';
        include_once '../Controle/FotoservicoPDO.php';
        include_once '../Modelo/Servico.php';
        include_once '../Modelo/Endereco.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Modelo/Empregador.php';
        include_once '../Modelo/Fotoservico.php';
        $empregadorPDO = new EmpregadorPDO();
        $servicoPDO = new ServicoPDO();
        $enderecoPDO = new EnderecoPDO();
        $usuarioPDO = new UsuarioPDO();
        $fotoservicoPDO = new FotoservicoPDO();
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row " style="margin-top: 5vh;">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <div class="card-title center">Serviços pendentes</div>
            <div class="divider"></div>
            <div class="row">
                <div class="col l10 m10 s12 offset-l1 offset-m1">
                    <?php
                        $nome = "";
                        if (isset($_GET['nome'])) {
                            $nome = $_GET['nome'];
                        }
                        $stmtServicos = $servicoPDO->selectServicosPendentes();
                        if ($stmtServicos) {
                    ?>
                    <ul class="collapsible">
                        <?php
                            while ($linha = $stmtServicos->fetch()) {
                                $servico = new Servico($linha);
                                $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($servico->getId_usuario())->fetch());
                                $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($servico->getId_endereco())->fetch());
                                $empregador = new Empregador($empregadorPDO->selectEmpregadorId_usuario($servico->getId_usuario())->fetch());
                                ?>
                                <li <?= $nome == $servico->getNome() ? "class='active'" : ''?>>
                                    <div class="collapsible-header"><b><?= $servico->getNome() ?></b></div>
                                    <div class="collapsible-body">
                                        <div class="row">
                                            <div class="col l6 m10 s12 offset-m1">
                                                <ul class="collection with-header">
                                                    <li class="collection-header">
                                                        <div class="card-title">Serviço</div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Nome</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $servico->getNome() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Descrição</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $servico->getDescricao() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Salário</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= "R$".$servico->getSalario() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Endereço</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $endereco->getEndereco().' - '.$endereco->getCidade() ?></a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col l6 m10 s12 offset-m1">
                                                <ul class="collection with-header">
                                                    <li class="collection-header">
                                                        <div class="card-title">Empregador</div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Nome</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $usuario->getNome() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Telefone</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $usuario->getTelefone() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>E-mail</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $usuario->getEmail() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>Razão social</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $empregador->getRazao_social() ?></a>
                                                        </div>
                                                    </li>
                                                    <li class="collection-item">
                                                        <div>
                                                            <b>CNPJ</b>
                                                            <a href="#!"
                                                               class="secondary-content black-text"><?= $empregador->getCnpj() ?></a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <ul class="collapsible">
                                                <li>
                                                    <div class="collapsible-header"><i
                                                                class="material-icons">photo</i>Fotos
                                                    </div>
                                                    <div class="collapsible-body">
                                                        <div class="row">
                                                            <?php
                                                                $stmtFoto = $fotoservicoPDO->selectTodasFotos($servico->getId_servico());
                                                                $cont = 0;
                                                                while ($linha = $stmtFoto->fetch()) {
                                                                    $foto = new Fotoservico($linha);
                                                                    ?>
                                                                    <div class="col s6 m4 l3"
                                                                         style="margin-bottom: 30px">
                                                                        <div style="height: 150px; width: 150px; margin: auto; position:relative; top:0px; left:0px;">
                                                                            <img class="fotoEditarServico materialboxed"
                                                                                 src="../<?php echo $foto->getCaminho(); ?>">
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    $cont++;
                                                                    if ($cont == 4 || $cont == 8) {
                                                                        ?>
                                                                        <div class="row"></div>
                                                                        <?php
                                                                    }
                                                                } ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="row center">
                                            <a href="#modalRecusar" class="btn red darken-1 btnRecusar"
                                               id_servico="<?= $servico->getId_servico() ?>">Recusar</a>
                                            <a href="../Controle/ServicoControle.php?function=aceitar&id_servico=<?= $servico->getId_servico() ?>"
                                               class="btn blue darken-1">Aceitar</a>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        ?>
                    </ul>
                <?php } else {
                            ?>
                            <div class="row center">
                                <h4>Nunhum serviço pendente</h4>
                            </div>
                            <?php
                        } ?>
                </div>
            </div>
            <div class="row center">
                <a href="../index.php" class="btn orange darken-1">Voltar</a>
            </div>
        </div>
    </div>
</main>
<div id="modalRecusar" class="modal">
    <form action="../Controle/ServicoControle.php?function=recusar" method="post">
        <div class="modal-content">
            <h4>Recusar serviço</h4>
            <p>Por favor, antes de recusar nos informe o motivo</p>
            <input type="text" name="id_servico" value="" id="inputIdServico" hidden>
            <div class="input-field col s10 offset-s1">
                <textarea id="motivo" class="materialize-textarea" name="motivo" required></textarea>
                <label for="motivo">Motivo</label>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn orange darken-1 white-text">Voltar</a>
            <button type="submit" class="modal-close waves-effect waves-green btn red darken-1 white-text">Recusar
            </button>
        </div>
    </form>
</div><?php
    include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    $('.tooltipped').tooltip();
    $('.collapsible').collapsible();
    $('.materialboxed').materialbox();
    $('.modal').modal();

    $(".btnRecusar").click(function () {
        var id_servico = $(this).attr("id_servico");
        $("#inputIdServico").val(id_servico);
        $('#modalRecusar').modal('open');
    });
</script>