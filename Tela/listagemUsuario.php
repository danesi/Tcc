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
        include_once '../Controle/UsuarioPDO.php';
        include_once '../Controle/EnderecoPDO.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Modelo/Endereco.php';
        $usuarioPDO = new UsuarioPDO();
        $enderecoPDO = new EnderecoPDO();
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
                <table class="highlight responsive-table centered">
                    <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Nascimento</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                        $stmtUsuario = $usuarioPDO->selectUsuario();
                        while ($linha = $stmtUsuario->fetch()) {
                            $usuario = new Usuario($linha);
                            $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($usuario->getId_endereco())->fetch());
                            ?>
                            <tr>
                                <td>
                                    <div class="center-block"
                                         style="background-image: url('<?= '../'.$usuario->getFoto(); ?>');
                                                 border-radius: 10%;
                                                 height: 75px; width: 75px;
                                                 background-position: center;
                                                 background-size: cover;
                                                 background-position: center;
                                                 background-repeat: no-repeat;
                                                 object-fit: cover;
                                                 object-position: center;
                                                 ">
                                    </div>
                                </td>
                                <td><?= $usuario->getNome() ?></td>
                                <td><?= $usuario->getCpf() ?></td>
                                <td><?= $usuario->getNascimentoDate()->format('d/m/Y') ?></td>
                                <td><?= $usuario->getTelefone() ?></td>
                                <td><?= $usuario->getEmail() ?></td>
                                <td><?= $endereco->getEndereco().' - '.$endereco->getCidade() ?></td>
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