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
        include_once '../Controle/EmpregadorPDO.php';
        include_once '../Controle/UsuarioPDO.php';
        include_once '../Modelo/Empregador.php';
        include_once '../Modelo/Usuario.php';
        $empregadorPDO = new EmpregadorPDO();
        $usuarioPDO = new UsuarioPDO();
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row " style="margin-top: 5vh;">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <div class="card-title center">Empregadores</div>
            <div class="divider"></div>
            <div class="row">
                <table class="highlight responsive-table col l10 offset-l1 hide-on-small-only">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Razão social</th>
                        <th>CNPJ</th>
                        <th>Nota</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $stmtEmpregadores = $empregadorPDO->selectEmpregador();
                        while ($linha = $stmtEmpregadores->fetch()) {
                            $empregador = new Empregador($linha);
                            $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($empregador->getId_usuario())->fetch());
                            ?>
                            <tr>
                                <td><?= $usuario->getNome() ?></td>
                                <td><?= $empregador->getRazao_social() ?></td>
                                <td><?= $empregador->getCnpj() ?></td>
                                <td><?= $empregador->getNota() == "" ? '0' : $empregador->getNota() ?></td>
                                <td>
                                    <a href="./verServicoEmpregado.php?id=<?= $empregador->getId_usuario() ?>"
                                       class="tooltipped" data-position="bottom" data-tooltip="Ver serviços"><i
                                                class="material-icons black-text">work_outline</i></a>
                                    <a href="#!" class="tooltipped excluirEmpregador"
                                       id_usuario="<?= $empregador->getId_usuario() ?>" data-position="bottom"
                                       data-tooltip="Deletar"><i class="material-icons black-text">delete</i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <ul class="collapsible hide-on-med-and-up popout">
                    <?php
                        $stmtEmpregadores = $empregadorPDO->selectEmpregador();
                        while ($linha = $stmtEmpregadores->fetch()) {
                            $empregador = new Empregador($linha);
                            $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($empregador->getId_usuario())->fetch());
                            ?>
                            <li>
                                <div class="collapsible-header"><b><?= $usuario->getNome() ?></b></div>
                                <div class="collapsible-body">
                                    <p><b>Razão social: </b> <?= $empregador->getRazao_social() ?></p>
                                    <p><b>CNPJ: </b> <?= $empregador->getCnpj() ?></p>
                                    <p><b>Nota: </b> <?= $empregador->getNota() == "" ? '0' : $empregador->getNota() ?>
                                    </p>
                                    <div class="row center">
                                        <a href="./verServicoEmpregado.php?id=<?= $empregador->getId_usuario() ?>"
                                           class="btn blue darken-1">Ver serviços</a>
                                        <a href="#!" class="btn red darken-1"
                                           id_usuario="<?= $empregador->getId_usuario() ?>">Deletar</a>
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
<div id="modalExluirEmpregador" class="modal">
    <form action="../Controle/EmpregadorControle.php?function=deletar" method="post">
        <div class="modal-content">
            <input type="text" name="id_usuario" id="inputIdEmpregador" value="" hidden>
            <h4>Atenção</h4>
            <p>Você relamente deseja excluir esse empregador?</p>
            <p>Caso exclua, você estará excluindo todos os seus serviços relacionados a ele.</p>
            <p id="servicos"></p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="btn modal-close waves-effect orange darken-1">Voltar</a>
            <button type="submit" class="btn waves-effect red darken-1">Deletar</button>
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

    $('.excluirEmpregador').click(function () {
        var id_usuario = $(this).attr('id_usuario');
        $('#inputIdEmpregador').val(id_usuario);
        $.ajax({
            url: "../Controle/ServicoControle.php?function=selectServicoIdEmpregador",
            data: {
                id_empregador : id_usuario
            },
            type: 'post',
            success: function (data) {
                $('#servicos').html(data);
                $('#modalExluirEmpregador').modal('open');
            }
        });
    });

    $('.voltar').click(function () {
        location.href = document.referrer;
    });
</script>