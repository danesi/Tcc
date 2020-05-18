<?php
    include_once '../Base/requerLogin.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
        include_once '../Base/header.php';
        include_once '../Modelo/Usuario.php';
        include_once '../Controle/EmpregadoPDO.php';
        include_once '../Controle/ServicoPDO.php';
        $usuario = new Usuario(unserialize($_SESSION['logado']));
        $empregadoPDO = new EmpregadoPDO();
        $servicoPDO = new ServicoPDO();
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row">
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <h4 class="textoCorPadrao2 center">Perfil</h4>
            <div class="divider"></div>
            <div class="row">
                <div class="col l4 offset-l1 s12 center">
                    <div class="row">
                        <div class="center card-title">Foto de perfil</div>
                        <br>
                        <a href="#!" id="linkfoto" class="center" style="width: 100%">
                            <div style="margin: auto" class="circle ">
                                <img class=" prev-img fotoPagePerfil center" width="150" height="150"
                                     src="../<?php echo $usuario->getFoto() ?>">
                            </div>
                            <div class="fotoPagePerfil" style="position: relative; margin-top: -205px; z-index: 2">
                                <div class="linkfotoPerfil white-text center">Alterar Foto</div>
                            </div>
                        </a>
                        <div class="row center">
                            <div id="loader" class="fotoPerfilLoader preloader-wrapper big active center"
                                 style="display: none;">
                                <div class="spinner-layer spinner-black-only center">
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
                        </div>
                        <form action="../Controle/UsuarioControle.php?function=alteraFoto" method="post" id="formFoto"
                              enctype="multipart/form-data">
                            <div class="file-field input-fiel">
                                <div>
                                    <input type="file" class="file-chos" name="imagem" id="btnFile"
                                           accept=".jpg,.jpeg,.bmp,.png,.jfif,.svg,.webp,.gif" hidden>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" name="imagem" type="text"
                                           placeholder="Selecione a foto"
                                           required hidden>
                                </div>
                            </div>
                            <input type="text" hidden name="SendCadImg">
                        </form>
                    </div>
                    <div class="row center">
                        <?php if(!$empregadoPDO->verificaEmpregado($usuario->getId_usuario())) { ?>
                            <a href="./registroEmpregado.php" class="waves-effect waves-light btn blue darken-1">Quero trabalhar</a>
                        <?php } else { ?>
                            <a href="./perfilEmpregado.php" class="waves-effect waves-light btn blue darken-1">Perfil empregado</a>
                        <?php } ?>
                        <br><br>
                        <?php if(!$servicoPDO->verificaServico($usuario->getId_usuario())) { ?>
                            <a class="waves-effect waves-light btn orange darken-1 modal-trigger" href="#modalEmpregador">Quero disponibilizar</a>
                        <?php } else { ?>
                            <a href="./perfilServico.php" class="waves-effect waves-light btn orange darken-1">Perfil servico</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col l6">
                    <div class="card">
                        <div class="card-title center">Informações pessoais</div>
                        <div class="divider"></div>
                        <div class="row">
                            <form action="../Controle/UsuarioControle.php?function=editar" method="post">
                                <input name="id_usuario" value="<?= $usuario->getId_usuario() ?>" hidden>
                                <div class="input-field col s10 offset-s1">
                                    <input type="text" name="nome" id="nome" class="validate" required
                                           value="<?= $usuario->getNome() ?>">
                                    <label for="nome" class="active">Nome<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s10 offset-s1">
                                    <input type="text" name="cpf" id="cpf" class="validate" required
                                           value="<?= $usuario->getCpf() ?>">
                                    <label for="cpf">CPF<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s10 offset-s1">
                                    <input type="text" name="nascimento" id="nascimento" class="datepicker" required
                                           value="<?= $usuario->getNascimentoDate()->format('d/m/Y') ?>">
                                    <label for="nascimento">Data de nascimento<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s10 offset-s1">
                                    <input type="text" name="telefone" id="telefone" class="validate" required
                                           value="<?= $usuario->getTelefone() ?>">
                                    <label for="telefone">Telefone<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s10 offset-s1">
                                    <input type="email" id="email" name="email" class="validate" require
                                           value="<?= $usuario->getEmail() ?>">
                                    <label for="email">E-mail<samp class="red-text">*</samp></label>
                                    <div class="row right">
                                        <samp class="red-text">*</samp><samp class="grey-text"> Campos
                                            obrigatórios</samp>
                                    </div>
                                </div>
                                <div class="row center">
                                    <button type="submit" value="Alterar" class="btn blue darken-2">Alterar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
    $("#linkfoto").click(function () {
        M.updateTextFields();
        $('#btnFile').click();
        carregarFoto();
    });

    function carregarFoto() {
        const s = document.querySelector.bind(document);
        const previewImg = s('.prev-img');
        const fileChooser = s('.file-chos');

        fileChooser.onchange = e => {
            const fileToUpload = e.target.files.item(0);
            const reader = new FileReader();
            reader.onload = e => previewImg.src = e.target.result;
            reader.readAsDataURL(fileToUpload);
            $('#linkfoto').hide();
            $('#loader').show();
            $("#formFoto").submit();
        };
    }

        $("#telefone").mask("(00) 00000-0000");
        $("#cpf").mask("000.000.000-00");
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            i18n: {
                cancel: 'Cancelar',
                clear: 'Limpar',
                done: 'Ok',
                months: [
                    'Janeiro',
                    'Fevereiro',
                    'Março',
                    'Abril',
                    'Maio',
                    'Junho',
                    'Julho',
                    'Agosto',
                    'Setembro',
                    'Outubro',
                    'Novembro',
                    'Dezembro'
                ],
                weekdays: [
                    'Domingo',
                    'Segunda-Feira',
                    'Terça-Feira',
                    'Quarta-Feira',
                    'Quinta-Feira',
                    'Sexta-Feira',
                    'Sábado'
                ],
                monthsShort: [
                    'Janeiro',
                    'Fevereiro',
                    'Março',
                    'Abril',
                    'Maio',
                    'Junho',
                    'Julho',
                    'Agosto',
                    'Setembro',
                    'Outubro',
                    'Novembro',
                    'Dezembro'
                ],
                weekdaysShort: [
                    'Dom',
                    'Seg',
                    'Ter',
                    'Qua',
                    'Qui',
                    'Sex',
                    'Sáb'
                ],
                weekdaysAbbrev: ['Do', 'Se', 'Te', 'Qa', 'Qi', 'Se', 'Sa']
            }
        });

    $('#nascimento').focusin(function () {
        $(".datepicker").datepicker('open');
    });
</script>