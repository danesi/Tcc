<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
        include_once '../Base/header.php';
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<?php
    include_once '../Controle/ServicoPDO.php';
    include_once '../Controle/EnderecoPDO.php';
    include_once '../Modelo/Endereco.php';
    $Servico = new servicoPDO();
    $enderecoPDO = new EnderecoPDO();
    $stmt = $Servico->selectServicoId_usuario($_GET['id_servico']);
    $servico = new Servico($stmt->fetch());
?>
<main>
    <div class="row" style="margin-top: 1vh;">
        <div class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1">
            <h4 class="textoCorPadrao2 center">Editar Serviço</h4>
            <div class="divider"></div>
            <div class="row center">
                <ul class="collapsible popout">
                    <li <?= isset($_GET['info']) ? "class='active'" : "" ?>>
                        <div class="collapsible-header"><i class="material-icons">info_outline</i>Informações</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <form action="../Controle/ServicoControle.php?function=editar" method="post">
                                    <div class="row">
                                        <input type="text" name="id_servico" value="<?= $servico->getId_servico() ?>" hidden>
                                        <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                            <input type="text" name="nome" id="nome" required
                                                   value="<?= $servico->getNome() ?>">
                                            <label for="nome">Nome<samp class="red-text">*</samp></label>
                                        </div>
                                        <div class="input-field col s5 m5 s10 offset-s1">
                                            <input type="text" name="salario" step="0.01" min="0" id="salario"
                                                   value="<?= $servico->getSalario() ?>">
                                            <label for="salario">Salario Mensal (Opcional)</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col l10 m10 s10 offset-l1 offset-s1 offset-m1">
                                        <textarea id="textarea1" class="materialize-textarea" required
                                                  name="descricao"><?= $servico->getDescricao() ?></textarea>
                                            <label for="textarea1">Descrição<samp class="red-text">*</samp></label>
                                            <div class="row right">
                                                <samp class="red-text">*</samp><samp class="grey-text"> Campos
                                                    obrigatórios</samp>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row center">
                                        <input type="submit" class="btn corPadrao2" value="Alterar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li <?= isset($_GET['foto']) ? "class='active'" : "" ?>>
                        <div class="collapsible-header"><i class="material-icons">photo</i>Fotos</div>
                        <div class="collapsible-body">
                            <div class="row">
                                <div class="col s6 m4 l3" style="margin-bottom: 30px">
                                    <div style="height: 150px; width: 150px; margin: auto; position:relative; top:0px; left:0px;">
                                        <img class="fotoEditarServico materialboxed"
                                             src="../<?php echo $servico->getFoto(); ?>">

                                        <a
                                                href="#"><i class="small material-icons black-text right grey lighten-4"
                                                            style="border-radius: 50%;
                                                                height: 30px; width: 30px;
                                                                position:absolute; top:5px; left:100px;
                                                                z-index: 156"
                                                            title="Deletar">close</i>


                                        </a>
                                    </div>
                                </div>

                                <form action="../Controle/fotoquartoControle.php?function=addFoto"
                                      enctype="multipart/form-data" method="post" id="addFoto">
                                    <div class="row">
                                        <a href="#!" id="linkfoto" class="col s6 m4 l3">
                                            <div style="height: 150px; width: 150px; margin: auto;">
                                                <img class="prev-img fotoEditarServico center" src="../Img/tcc.jfif">
                                            </div>
                                            <div class="fotoEditarServico"
                                                 style="position: relative; margin-top: -150px; z-index: 1">
                                                <div class="linkfoto white-text center" style="border-radius: 10%">
                                                    Adicionar Foto
                                                </div>
                                            </div>
                                            <div id="loader"
                                                 class="fotoPerfilLoader preloader-wrapper big active center hide"
                                                 style="position: absolute; margin-top: -120px; z-index: 1; margin-left: -20px; margin-right: auto">
                                                <div class="spinner-layer spinner-blue-only center">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="file-field input-fiel">
                                        <div>
                                            <input type="file" class="file-chos" name="foto" id="btnFile"
                                                   accept=".jpg,.jpeg,.bmp,.png,.jfif,.svg,.webp" hidden>
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" name="imagem" id="fotoQuarto" type="text"
                                                   placeholder="Selecione a foto" hidden>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li <?= isset($_GET['endereco']) ? "class='active'" : "" ?>>
                        <div class="collapsible-header"><i class="material-icons">location_on</i>Endereço</div>
                        <div class="collapsible-body">
                            <?php
                                $stmtEndereco = $enderecoPDO->selectEnderecoId_endereco($servico->getId_endereco());
                                if ($stmtEndereco) {
                                $endereco = new Endereco($stmtEndereco->fetch());
                            ?>
                            <form action="../Controle/EnderecoControle.php?function=editarEnderecoServico"
                                  method="post">
                                <?php
                                    } else {
                                ?>
                                <form action="../Controle/EnderecoControle.php?function=inserirEnderecoServico"
                                      method="post">
                                    <?php
                                        $endereco = new Endereco();
                                        }
                                    ?>
                                    <div class="row">
                                        <input name="id_endereco" hidden value="<?= $endereco->getId_endereco() ?>">
                                        <input name="id_servico" hidden value="<?= $servico->getId_servico() ?>">
                                        <div class="row">
                                            <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                                <input type="text" name="cep" id="cep" class="validate" required
                                                       value="<?= $endereco->getCep() ?>">
                                                <label for="cep" class="active">CEP<samp
                                                            class="red-text">*</samp></label>
                                            </div>
                                            <div class="input-field col s5 m5 s10 offset-s1">
                                                <input type="text" name="endereco" id="endereco" class="validate"
                                                       required
                                                       value="<?= $endereco->getEndereco() ?>">
                                                <label for="endereco">Endereço<samp class="red-text">*</samp></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col l5 m5 s10 offset-l1">
                                                <input type="text" name="numero" id="numero" class="validate"
                                                       value="<?= $endereco->getNumero() ?>">
                                                <label for="numero">Número</label>
                                            </div>
                                            <div class="input-field col s5 m5 s10 offset-s1">
                                                <input type="text" name="complemento" id="complemento" class="validate"
                                                       value="<?= $endereco->getComplemento() ?>">
                                                <label for="complemento">Complemento</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                                <input type="text" name="cidade" id="cidade" class="validate" required
                                                       value="<?= $endereco->getCidade() ?>">
                                                <label for="cidade">Cidade<samp class="red-text">*</samp></label>
                                            </div>
                                            <div class="input-field col s5 m5 s10 offset-s1">
                                                <input type="text" name="estado" id="estado" class="validate" required
                                                       value="<?= $endereco->getEstado() ?>">
                                                <label for="estado">Estado<samp class="red-text">*</samp></label>
                                                <div class="row right">
                                                    <samp class="red-text">*</samp><samp class="grey-text"> Campos
                                                        obrigatórios</samp>
                                                </div>
                                            </div>
                                            <div class="row center">
                                                <?php
                                                    if ($stmtEndereco) {
                                                        ?>
                                                        <input type="submit" class="btn corPadrao2" value="Alterar">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <input type="submit" class="btn corPadrao2" value="Cadastrar">
                                                        <?php
                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row center">
                <a href="../index.php" class="corPadrao3 btn">Voltar</a>
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
    $('.materialboxed').materialbox();
    $("#cep").mask("00000-000");
    $('#cep').blur(function () {
        cep = $(this).val();
        cep = cep.replace(/\D/g, '');
        $.ajax({
            url: 'https://viacep.com.br/ws/' + cep + '/json/unicode',
            dataType: 'json',
            success: function ({localidade, uf, complemento, logradouro, gia}) {
                $('#cidade').val(localidade).focus();
                $('#estado').val(uf).focus();
                $('#complemento').val(complemento).focus();
                $('#endereco').val(logradouro).focus();
                $('#numero').val(gia).focus();
            }
        })
    });
</script>

