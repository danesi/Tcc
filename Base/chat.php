<?php
if (!isset($_SESSION)) {
    session_start();
}
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}
?>
<div class="sideChat z-depth-3" style="display: none; z-index: 99999">
    <div class="headChat">
        <div><b class="left" style="margin-left: 2vh">Contatos </b><a href="#!" class="closeChatList"><i
                        class="material-icons right white-text" style="margin-right: 15px;">close</i></a></div>
    </div>
    <div class="bodyChat">
        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <?php
                    include_once $pontos . "Modelo/Usuario.php";
                    include_once $pontos . "Controle/chatPDO.php";
                    $chatPDO = new chatPDO();
                    $stmt = $chatPDO->selectListaContatos();
                    $logado = new Usuario(unserialize($_SESSION['logado']));
                    while ($linha = $stmt->fetch()) {
                        $usuario = new usuario($linha);
                        $notificacao = $chatPDO->verificaNotificacao($usuario->getId_usuario(), $logado->getId_usuario())->fetch();
                        echo "  <li class='hoverable vali waves-effect openChat collection-item' id_destinatario='" . $usuario->getId_usuario() . "'>
                                       
                                        <div class='fotoPerfil le' style='background-image: url(" . $pontos . $usuario->getFoto() . ");
                                        float: left;
                                        margin: 0 8px 0 -12px;
                                        background-position: center;
                                        background-repeat: no-repeat;
                                        height: 40px;
                                        width: 40px'
                                        ></div>
                                      
                                        <span class='title'>" . $usuario->getNome() . "</span>".($notificacao['newMessages']==0?"":"<span class='badge orange darken-1 white-text'>".$notificacao['newMessages']."</span>")."
                                </li>";

                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<form action="#!" id="testeArquivo" method="post" class="hide" enctype="multipart/form-data">
    <div class="row">
        <div class="input-field col s12">
            <input type="file" id="arquivo" name="arquivo">
            <input type="submit">
        </div>
    </div>
</form>
<div class="chatBox z-depth-3" style="display: none; z-index: 999999">
    <div class="headChatBox"><b><span id="nameDestinatario" class="left" style="margin-left: 1vh; margin-top: 1vh"></span></b> <a href="#!" class="closeChat"><i
                    class="material-icons right white-text" style="margin-right: 15px;">close</i></a></div>
    <div class="bodyChatBox"></div>
    <div class="horizontal-divider" style="width: 100%"></div>
    <!--    <div class="inputChat" style="overflow: auto;">-->
    <form method="post" action="#!" id="formMensagem">
        <div class="row">
            <div class="input-field col s9">
                <input id="mensagem" name="mensagem" type="text" autocomplete="off">
                <label for="mensagem">Mensagem</label>
            </div>
            <div class="col s1" id="btnImagen">
                <div class="file-field input-field">
                    <a class="btn" href="#!" id="enviaImagem" hidden><i class="material-icons">image</i></a>
                </div>
            </div>
            <div class="col s1" id="btnPreloadImagen" hidden>
                <div class="file-field input-field">
                    <a class="btn-flat" href="#!">
                        <div class="preloader-wrapper small active">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
    <div class="fixed-action-btn" id="btnChat">
        <a class="btn-floating btn-large blue darken-1" id="openChatList" >
            <i class="large material-icons">chat</i>
        </a>
    </div>



<script>
    $("#enviaImagem").click(function () {
        $("#arquivo").click();
        carregarFoto();
    });
    function carregarFoto() {
        const s = document.querySelector.bind(document);
        const fileChooser = s('#arquivo');

        fileChooser.onchange = e => {
            const fileToUpload = e.target.files.item(0);
            const reader = new FileReader();
            reader.readAsDataURL(fileToUpload);
            $("#testeArquivo").submit();
        };
    }
    $("#openChatList").click(function () {
        $(".sideChat").show();
        $(this).hide();
    });

    $(".verMensagem").click(function () {
        $(".sideChat").show();
        $(this).hide();
    });

    $(".closeChatList").click(function () {
        $("#openChatList").show();
        $(".sideChat").hide();
        notification();
    });

    var refreshChat;
    var ajax;
    var id_destinatario = 0;
    var x = 0;
    $(".openChat").click(function () {
        var nome = $(this).find($(".title")).html();
        var id = $(this).attr("id_destinatario");
        id_destinatario = id;
        openChat(nome);

    });
    $(".closeChat").click(function () {
        $("#openChatList").show();
        $(".chatBox").hide();
        ajax.abort();
        $(".bodyChatBox").html("");
        $(".bodyChat").load("<?= $pontos ?>Controle/chatControle.php?function=refreshBodyChat&pontos=<?= $pontos ?>", function () {
            $(".openChat").click(function () {
                var nome = $(this).find($(".title")).html();
                var id = $(this).attr("id_destinatario");
                id_destinatario = id;
                openChat(nome);

            });
        });
        notification();
    });

    $("#formMensagem").submit(function () {
        var dados = $(this).serialize();
        $("#mensagem").val("");
        $.ajax({
            url: "<?= $pontos; ?>Controle/chatControle.php?function=enviaMensagem&destinatario=" + id_destinatario,
            data: dados,
            type: "post",
            success: function (data) {
                //TODO confirmação de envio
            }
        });
        return false;
    });
    $("#testeArquivo").submit(function () {
        var formData = new FormData(this);
        $('#btnImagen').attr("hidden", true);
        $('#btnPreloadImagen').removeAttr("hidden");
        $.ajax({
            url: "<?= $pontos; ?>Controle/chatControle.php?function=enviaMedia&destinatario=" + id_destinatario,
            type: 'POST',
            data: formData,
            success: function (data) {
                //TODO reação a envio positivo
                $('#btnPreloadImagen').attr("hidden", true);
                $('#btnImagen').removeAttr("hidden");
            },
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
        return false;
    });

    function openChat(nome_destinatario) {
        x = 0;
        $("#nameDestinatario").html(nome_destinatario);
        $(".sideChat").hide();
        $(".chatBox").show();
        $(".bodyChatBox").load("<?= $pontos; ?>Controle/chatControle.php?function=selectConversa&pontos=<?=$pontos?>&destinatario=" + id_destinatario, startPushListener);
    }

    function intervalo() {
        var lastId = $(".last_id:last").val();
        if(lastId != 'undefined') {
            if (x < 1) {
                $(".bodyChatBox").scrollTop($(".bodyChatBox").height() * 150);
                x++;
                ajax = $.ajax({
                    url: "<?= $pontos; ?>Controle/chatControle.php?function=getNewMessage&destinatario=" + id_destinatario + "&last_id=" + lastId+"&pontos=<?=$pontos?>",
                    success: function (data) {
                        x--;
                        $(".bodyChatBox").append(data);
                        $(".bodyChatBox").scrollTop($(".bodyChatBox").height() * 150);
                        $(".materialboxed").materialbox();
                    }
                });
            }
        }
    }

    function startPushListener() {
        $(".materialboxed").materialbox();
        $(".bodyChatBox").scrollTop($(".bodyChatBox").height() * 150);
        refreshChat = setInterval(intervalo, 500);
    }

    $(".bodyChat").load("<?php echo $pontos ?>Controle/chatControle.php?function=refreshBodyChat&pontos=<?php echo $pontos ?>", function () {
        $(".openChat").click(function () {
            var nome = $(this).find($(".title")).html();
            var id = $(this).attr("id_destinatario");
            id_destinatario = id;
            openChat(nome);

        });
    });

    function notification() {
        var id = <?= $logado->getId_usuario() ?>;
        $.ajax({
            url: "<?= $pontos; ?>Controle/chatControle.php?function=CountNotificacao&id="+id,
            success: function (data) {
                console.log(data);
                if (data > 0) {
                    $('#openChatList').addClass("pulse");
                } else {
                    $('#openChatList').removeClass("pulse");
                }
            }
        });
    }

    setInterval(function () {
        notification();
    }, 20000);

    notification();
</script>


