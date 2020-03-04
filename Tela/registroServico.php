<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['logado'])){
        header("Location: ./login.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastrar serviço</title>
    <?php
        include_once '../Base/header.php';
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row" style="margin-top: 1vh;">
        <div class="card col l8 offset-l2 m10 offset-m1 s10 offset-s1">
            <form action="../Controle/ServicoControle.php?function=inserirServico" method="post" enctype="multipart/form-data">
                <div class="row center">
                    <h4 class="textoCorPadrao2">Cadastrar Serviço</h4>
                </div>
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
                <div class="row">
                    <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                        <input type="text" name="nome" id="nome" required>
                        <label for="nome">Nome<samp class="red-text">*</samp></label>
                    </div>
                    <div class="input-field col s5 m5 s10 offset-s1">
                        <input type="text" name="salario" step="0.01" min="0" id="salario">
                        <label for="salario">Salario Mensal (Opcional)</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col l10 m10 s10 offset-l1 offset-s1 offset-m1">
                        <textarea id="textarea1" class="materialize-textarea" required name="descricao"></textarea>
                        <label for="textarea1">Descrição<samp class="red-text">*</samp></label>
                        <div class="row right">
                            <samp class="red-text">*</samp><samp class="grey-text"> Campos obrigatórios</samp>
                        </div>
                    </div>
                </div>
                <div class="row center">
                    <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                    <input type="submit" class="btn corPadrao2" value="Cadastrar" name="cadastrar">
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
    $(document).ready(function () {
        $("#cnpj").mask("00.000.000/0000-00");
        $('#salario').mask('000.000.000.000.000,00', {reverse: true});
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
