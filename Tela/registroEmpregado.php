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
        <main>
            <div class="row" style="margin-top: 1vh; padding-right: 5vh">
                <div class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1">
                    <form action="../Controle/empregadoControle.php?function=inserirEmpregado"  method="post" id="form" enctype="multipart/form-data">
                        <div class="row center">
                            <h4 class="textoCorPadrao2">Complemente suas infomaçãoes</h4>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="center">
                                    <a href="#!" id="linkfoto">
                                        <div style="height: 150px; width: 150px; margin: auto;">
                                            <img  class="prev-img fotoPerfil center" src="../Img/tcc.jfif">
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
                                    <input class="file-path validate" name="imagem" id="foto" type="text" placeholder="Selecione a foto" required hidden>
                                </div>
                            </div>
                                <div class="input-field col s5 m5 s12 offset-l1 offset-m1">
                                    <select name="escolaridade" required>
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
                                <div class="input-field col l5">
                                    <textarea id="textarea1" class="materialize-textarea" name="area_atuacao"></textarea>
                                    <label for="textarea1">Áreas de atuação</label>
                                </div>
                            </div>
                            <div class="row center">
                                <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                                <input type="submit" value="cadastrar" class="btn blue darken-1" name="cadastrar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>
<script>
    $("#form").submit(function () {
        var senha1 = $("#senha1").val();
        var senha2 = $("#senha2").val();
        if (senha1 != senha2) {
            M.toast({html: 'As senhas não são iguais!'});
            return false;
        }
    });
    $('select').formSelect();
    $(document).ready(function () {
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
    });

    $("#foto").on('invalid', function () {
        M.toast({html: 'Insira uma foto!'});
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
</script>
