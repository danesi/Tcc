<?php
    include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listagem Empregado</title>
    <?php
        include_once '../Base/header.php';
        include_once '../Controle/ServicoPDO.php';
        include_once '../Controle/EnderecoPDO.php';
        include_once '../Controle/UsuarioPDO.php';
        include_once '../Modelo/Servico.php';
        include_once '../Modelo/Endereco.php';
        include_once '../Modelo/Usuario.php';
        $empregadorPDO = new EmpregadorPDO();
        $servicoPDO = new ServicoPDO();
        $enderecoPDO = new EnderecoPDO();
        $usuarioPDO = new UsuarioPDO();
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row " style="margin-top: 5vh;">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <div class="card-title center">Serviços</div>
            <div class="divider"></div>
            <div class="row">
                <table class="highlight responsive-table col l10 offset-l1 centered hide-on-small-only">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Salário</th>
                        <th>Endereco</th>
                        <th>Dono</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $stmtServicos = $servicoPDO->selectServico();
                        while ($linha = $stmtServicos->fetch()) {
                            $servico = new Servico($linha);
                            $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($servico->getId_usuario())->fetch());
                            $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($servico->getId_endereco())->fetch());
                            ?>
                            <tr>
                                <td><?= $servico->getNome() ?></td>
                                <td><?= $servico->getDescricao() ?></td>
                                <td><?= 'R$ '.$servico->getSalario() ?></td>
                                <td><?= $endereco->getEndereco().' - '.$endereco->getCidade() ?></td>
                                <td><?= $usuario->getNome() ?></td>
                                <td>
                                    <a href="./verServico.php?id=<?= $servico->getId_servico() ?>" class="tooltipped"
                                       data-position="bottom" data-tooltip="Ver mais"><i
                                                class="material-icons black-text">zoom_in</i></a>
                                    <a href="#!" class="tooltipped excluirServico"
                                       id_servico="<?= $servico->getId_servico() ?>" data-position="bottom"
                                       data-tooltip="Deletar"><i
                                                class="material-icons black-text">delete</i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <ul class="collapsible hide-on-med-and-up popout">
                    <?php
                        $stmtServicos = $servicoPDO->selectServico();
                        while ($linha = $stmtServicos->fetch()) {
                        $servico = new Servico($linha);
                        $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($servico->getId_usuario())->fetch());
                        $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($servico->getId_endereco())->fetch());
                    ?>
                    <li>
                        <div class="collapsible-header"><b><?= $servico->getNome() ?></b></div>
                        <div class="collapsible-body">
                            <p><b>Descrição: </b><?= $servico->getDescricao() ?></p>
                            <p><b>Salário: </b><?= 'R$ '.$servico->getSalario() ?></p>
                            <p><b>Endereco: </b><?= $endereco->getEndereco().' - '.$endereco->getCidade() ?></p>
                            <p><b>Dono: </b><?= $usuario->getNome() ?></p>
                            <div class="row center">
                                <a href="./verServico.php?id=<?= $servico->getId_servico() ?>"
                                   class="btn blue darken-1">Ver mais</a>
                                <a href="" class="btn red darken-1">Deletar</a>
                            </div>
                        </div>
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
<div id="modalEscluirServico" class="modal">
    <form action="../Controle/ServicoControle.php?function=deletar" method="post">
        <input type="text" id="inputIdServico" name="id_servico" value="" hidden>
        <div class="modal-content">
            <h4>Atenção</h4>
            <p>Você realmente deseja deletar esse serviço?</p>
            <p id="DemaisServicos"></p>
            <div id="alert" class="hide">
                <ul class='collection'>
                    <li class='collection-item yellow accent-3'>
                        <i class="material-icons left ">report_problem</i>
                        Você está deletando todos os serviços desse usuário, deseja deletar o usuário também?
                        <br>
                    </li>
                </ul>
                <p>
                    <label>
                        <input class="with-gap" name="deleteUser" value="true" type="radio"/>
                        <span class="black-text">Deletar</span>
                    </label>
                </p>
                <p>
                    <label>
                        <input class="with-gap" name="deleteUser" value="false" type="radio" checked/>
                        <span class="black-text">Não deletar</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect btn orange darken-1">Voltar</a>
            <button class="btn red darken-1" type="submit">Deletar</button>
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
    $('.collapsible').collapsible();
    $('.modal').modal();

    $('.voltar').click(function () {
        location.href = document.referrer;
    });

    $('.excluirServico').click(function () {
        var id_servico = $(this).attr('id_servico');
        $.ajax({
            url: "../Controle/ServicoControle.php?function=selectServicosDoMesmoUsuario",
            data: {
                id_servico: id_servico,
            },
            type: 'post',
            success: function (data) {
                $('#inputIdServico').val(id_servico);
                $('#DemaisServicos').html(data);
                $('#modalEscluirServico').modal('open');
                $('#alert').addClass('hide');
                $("input[type='checkbox'].selectServicos").change(function () {
                    var checkbox = $("input[type='checkbox'].selectServicos");
                    if (checkbox.length == checkbox.filter(":checked").length) {
                        $('#alert').removeClass('hide');
                    } else {
                        $('#alert').addClass('hide');
                    }
                });

            }
        });
    });
</script>