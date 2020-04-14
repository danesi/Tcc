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
        <div class="card col l10 offset-l1">
            <div class="card-title center">Empregadores</div>
            <div class="divider"></div>
            <div class="row">
                <table class="highlight responsive-table col l10 offset-l1">
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
                                    <a href="" class="tooltipped" data-position="bottom" data-tooltip="Ver mais"><i class="material-icons black-text">zoom_in</i></a>
                                    <a href="" class="tooltipped" data-position="bottom" data-tooltip="Ver serviços"><i class="material-icons black-text">work_outline</i></a>
                                    <a href="" class="tooltipped" data-position="bottom" data-tooltip="Deletar"><i class="material-icons black-text">delete</i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="row center">
                <a href="" class="btn orange darken-1">Voltar</a>
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
    $('.tooltipped').tooltip();
</script>