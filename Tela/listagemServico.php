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
        <div class="card col l10 offset-l1">
            <div class="card-title center">Serviços</div>
            <div class="divider"></div>
            <div class="row">
                <table class="highlight responsive-table col l10 offset-l1 centered">
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
                                    <a href="" class="tooltipped" data-position="bottom" data-tooltip="Ver mais"><i
                                                class="material-icons black-text">zoom_in</i></a>
                                    <a href="" class="tooltipped" data-position="bottom" data-tooltip="Deletar"><i
                                                class="material-icons black-text">delete</i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
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
    $('.tooltipped').tooltip();
    $('.voltar').click(function () {
        location.href = document.referrer;
    });
</script>