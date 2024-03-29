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
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
    include_once '../Modelo/Usuario.php';
    $usuario = new Usuario(unserialize($_SESSION['logado']));
?>
<main>
    <div class="row" >
        <div class="card col l8 offset-l2 m10 offset-m1 s12 ">
            <form action="../Controle/EmpregadoControle.php?function=inserirEmpregado" method="post" id="form"
                  enctype="multipart/form-data">
                <div class="row">
                    <h4 class="textoCorPadrao2 center">Complemente suas infomaçãoes</h4>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="center">
                            <a href="#!" id="linkfoto">
                                <div style="height: 150px; width: 150px; margin: auto;">
                                    <img class="prev-img fotoPerfil center"
                                         src="../<?= $usuario->getFoto() ?>">
                                </div>
                                <div class="fotoPerfil" style="position: relative; margin-top: -150px; z-index: 1">
                                    <div class="linkfoto white-text center">Adicionar Foto</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="file-field input-fiel">
                        <div>
                            <input type="file" class="file-chos" name="foto" id="btnFile" hidden>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" name="imagem" id="foto" type="text"
                                   placeholder="Selecione a foto" hidden>
                        </div>
                    </div>
                    <div class="input-field col s8 m8 s10 offset-s1 offset-l2 offset-m2">
                        <select name="escolaridade" required class="validate" id="selectEscolaridade">
                            <option value="" disabled selected>Escolha sua escolaridade</option>
                            <option value="Fundamental - Incompleto">Fundamental - Incompleto</option>
                            <option value="Fundamental - Completo">Fundamental - Completo</option>
                            <option value="Médio - Incompleto">Médio - Incompleto</option>
                            <option value="Médio - Completo">Médio - Completo</option>
                            <option value="Superior - Incompleto">Superior - Incompleto</option>
                            <option value="Superior - Completo">Superior - Completo</option>
                        </select>
                        <label>Escolaridade<samp class="red-text">*</samp></label>
                    </div>
                    <div class="input-field col s10 m8 l8 offset-l2 offset-m2 offset-s1">
                        <div class="chips black-text tooltipped" data-position="bottom" data-tooltip="Escreva a área e após pressione enter"></div>
                        <input name="area_atuacao" value="" hidden class="area">
                        <div class="row right">
                            <samp class="red-text">*</samp><samp class="grey-text"> Campos obrigatórios</samp>
                        </div>
                    </div>
                </div>
                <div class="row center">
                    <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                    <input type="submit" value="cadastrar" class="btn blue darken-1" name="cadastrar">
                </div>
            </form>
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
    $('select').formSelect();
    $('.chips').chips({
        autocompleteOptions: {
            data: {
                'Desenvolvedor': null,
                'Trabalhador rual': null,
                'Trabalhador urbano': null,
                'Domestica': null,
                'Pintor': null,
            },
            limit: Infinity,
            minLength: 1
        },
        placeholder: 'Áreas de atuação*',
        secondaryPlaceholder: '+Áreas',
    });

    $("#selectEscolaridade").on('invalid', function () {
        M.toast({html: 'Selecione a escolaridade'});
    });

    $("#form").submit(function () {
        var foto = $('#btnFile').val();
        var src = $('.fotoPerfil').attr('src');
        if ((foto === "" || foto == null) && src === '../Img/Perfil/default.png') {
            M.toast({html: 'Insira uma foto!'});
            return false;
        } else {
            var value = $('.chips').text();
            var areas = value.split('close');
            if (areas.length <= 1) {
                M.toast({html: 'Adicione áreas de atuação'});
                return false;
            } else {
                console.log(areas);
                $('.area').val(areas);
                return true;
            }
        }
    });


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
        };
    }
    $('.tooltipped').tooltip();
</script>
