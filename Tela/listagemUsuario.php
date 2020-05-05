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
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <div class="card-title center">Serviços</div>
            <div class="divider"></div>
            <div class="row">
                <table class="highlight responsive-table centered hide-on-small-only">
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
                                    <a href="./verUsuario.php?id=<?= $usuario->getId_usuario() ?>" class="tooltipped"
                                       data-position="bottom" data-tooltip="Ver mais"><i
                                                class="material-icons black-text">zoom_in</i></a>
                                    <a href="#!" class="tooltipped excluirUsuario"
                                       id_usuario="<?= $usuario->getId_usuario() ?>" data-position="bottom"
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
                        $stmtUsuario = $usuarioPDO->selectUsuario();
                        while ($linha = $stmtUsuario->fetch()) {
                            $usuario = new Usuario($linha);
                            $endereco = new Endereco($enderecoPDO->selectEnderecoId_endereco($usuario->getId_endereco())->fetch());
                            ?>
                            <li>
                                <div class="collapsible-header">
                                    <div class="left-align"
                                         style="background-image: url('<?php echo '../'.$usuario->getFoto(); ?>');
                                                 float: left;
                                                 margin: 0 8px 0 -5px;
                                                 border-radius: 50%;
                                                 height: 25px; width: 25px;
                                                 background-position: center;
                                                 background-size: cover;
                                                 background-position: center;
                                                 background-repeat: no-repeat;
                                                 object-fit: cover;
                                                 object-position: center;
                                                 ">
                                    </div>
                                    <?php echo $usuario->getNome(); ?>
                                </div>
                                <div class="collapsible-body">
                                    <p><b>CPF: </b><?= $usuario->getCpf() ?></p>
                                    <p><b>Nascimento: </b><?= $usuario->getNascimentoDate()->format('d/m/Y') ?></p>
                                    <p><b>Telefone: </b><?= $usuario->getTelefone() ?></p>
                                    <p><b>Email: </b><?= $usuario->getEmail() ?></p>
                                    <p><b>Endereço: </b><?= $endereco->getEndereco().' - '.$endereco->getCidade() ?></p>
                                    <div class="row center">
                                        <a href="./verUsuario.php?id=<?= $usuario->getId_usuario() ?>"
                                           class="btn blue darken-1">Ver mais</a>
                                        <a href="#!" class="btn red darken-1 excluirUsuario"
                                           id_usuario="<?= $usuario->getId_usuario() ?>">Deletar</a>
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
<div id="modalExcluirUsuario" class="modal">
    <form action="../Controle/UsuarioControle.php?function=deletar" method="post">
        <div class="modal-content">
            <input type="text" name="id_usuario" id="inputIdUsuario" value="" hidden>
            <h4>Atenção</h4>
            <p>Você realmente deseja deletar esse usuário?</p>
            <p>Ao deleta-lo, você deleta também todas as coisas associadas a ele.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn orange darken-1">voltar</a>
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

    $('.excluirUsuario').click(function () {
        var id_usuario = $(this).attr('id_usuario');
        $('#inputIdUsuario').val(id_usuario);
        $('#modalExcluirUsuario').modal('open');
    });
</script>