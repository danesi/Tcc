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
        include_once '../Controle/EmpregadoPDO.php';
        include_once '../Controle/UsuarioPDO.php';
        include_once '../Modelo/Empregado.php';
        include_once '../Modelo/Usuario.php';
        $empregadoPDO = new EmpregadoPDO();
        $usuarioPDO = new UsuarioPDO();
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row " style="margin-top: 5vh;">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <div class="card-title center">Empregados</div>
            <div class="divider"></div>
            <div class="row">
                <table class="highlight responsive-table col l10 offset-l1 hide-on-small-only">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Escolaridade</th>
                        <th>Áreas de atuaçao</th>
                        <th>Nota</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $stmtEmpregados = $empregadoPDO->selectEmpregado();
                        while ($linha = $stmtEmpregados->fetch()) {
                            $empregado = new Empregado($linha);
                            $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($empregado->getId_usuario())->fetch());
                            ?>
                            <tr>
                                <td><?= $usuario->getNome() ?></td>
                                <td><?= $empregado->getEscolaridade() ?></td>
                                <td><?= $empregado->getArea_atuacao() ?></td>
                                <td><?= $empregado->getNota() == "" ? '0' : $empregado->getNota() ?></td>
                                <td>
                                    <a href="./verEmpregado.php?id=<?= $empregado->getId_usuario() ?>"
                                       class="tooltipped" data-position="bottom" data-tooltip="Ver mais"><i
                                                class="material-icons black-text">zoom_in</i></a>
                                    <a href="#!" class="tooltipped modal-trigger exluirEmpregado" id_usuario="<?= $empregado->getId_usuario()?>"
                                       data-position="bottom" data-tooltip="Deletar"><i
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
                        $stmtEmpregados = $empregadoPDO->selectEmpregado();
                        while ($linha = $stmtEmpregados->fetch()) {
                            $empregado = new Empregado($linha);
                            $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($empregado->getId_usuario())->fetch());
                            ?>
                            <li>
                                <div class="collapsible-header"><b><?= $usuario->getNome() ?></b></div>
                                <div class="collapsible-body">
                                    <p><b>Escolaridade: </b> <?= $empregado->getEscolaridade() ?></p>
                                    <p><b>Áreas de atuaçao: </b> <?= $empregado->getArea_atuacao() ?></p>
                                    <p><b>Nota: </b> <?= $empregado->getNota() == "" ? '0' : $empregado->getNota() ?>
                                    </p>
                                    <div class="row center">
                                        <a href="./verEmpregado.php?id=<?= $empregado->getId_usuario() ?>"
                                           class="btn blue darken-1">Ver mais</a>
                                        <a class="btn red darken-1 modal-trigger exluirEmpregado" id_usuario="<?= $empregado->getId_usuario()?>">Deletar</a>
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
<div id="modalExluirEmpregado" class="modal">
    <form action="../Controle/EmpregadoControle.php?function=deletar" method="post">
        <div class="modal-content">
            <h4>Antenção</h4>
            <p>Você realmente deseja deletar esse empregado?</p>
            <input type="text" id="inputIdUsuario" name="id_usuario" value="" hidden>
        </div>
        <div class="modal-footer">
            <a href="#!" class="btn modal-close waves-effect orange darken-1">Voltar</a>
            <button type="submit" class=" btn waves-effect red darken-1">Deletar</button>
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

    $('.exluirEmpregado').click(function () {
        var id_usuario = $(this).attr('id_usuario');
        $('#inputIdUsuario').val(id_usuario);
        $('#modalExluirEmpregado').modal('open');
    });

    $('.voltar').click(function () {
        location.href = document.referrer;
    });
</script>