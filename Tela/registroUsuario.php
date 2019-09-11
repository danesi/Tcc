<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    
    if (!isset($_SESSION['logado'])) {
        $_SESSION['msg'] = "Você não tem permissão para acessar essa página";
        header("Location: ../index.php");
    }
?>
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
                <div class="card col l9 offset-l3 m10 offset-m1 s10 offset-s1">
                    <form action="../Controle/usuarioControle.php?function=inserirUsuario"  method="post" id="form">
                        <div class="row center">
                            <h4 class="textoCorPadrao2">Cadastrar Usuario</h4>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="text" name="nome" id="nome" class="validate" required>
                                    <label for="nome" class="active">Nome<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="cpf" id="cpf" class="validate" required>
                                    <label for="cpf">CPF<samp class="red-text">*</samp></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="text" name="nascimento" class="datepicker" class="validate" required>
                                    <label>Data de nascimento<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="telefone" id="telefone" class="validate" required>
                                    <label>Telefone<samp class="red-text">*</samp></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="email" name="email" class="validate" required>
                                    <label>E-mail<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="text" name="id_endereco" class="validate" required>
                                    <label>id_endereco</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s5 m5 s10 offset-l1 offset-m1 offset-s1">
                                    <input type="password" name="senha1" class="validate" required id="senha1">
                                    <label>Senha<samp class="red-text">*</samp></label>
                                </div>
                                <div class="input-field col s5 m5 s10 offset-s1">
                                    <input type="password" name="senha2" class="validate" required id="senha2">
                                    <label>Repita a senha<samp class="red-text">*</samp></label>
                                    <div class="row right">
                                        <samp class="red-text">*</samp><samp class="grey-text"> Campos obrigatórios</samp>
                                    </div>
                                </div>
                            </div>
                            <div class="row center">
                                <a href="../index.php" class="corPadrao3 btn">Voltar</a>
                                <button type="submit" class="btn corPadrao2" id="cadastrar">Cadastrar</button>
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
</script>

