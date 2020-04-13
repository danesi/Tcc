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
        include_once '../Controle/EmpregadoPDO.php';
        include_once '../Modelo/Empregado.php';
        $empregadoPDO = new EmpregadoPDO();
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="row">
        <div class="card col l10 m10 s12 offset-l1 offset-m1">
            <span class="card-title col l2 m2 hide-on-small-only" style="margin-top: 3vh">Serviços</span>
            <span class="card-title col s12 center hide-on-med-and-up" style="margin-top: 3vh">Serviços</span>
            <div class="col l5 m5 s12">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input placeholder="Busque por cidade, UF ou CEP" type="text" class="localizacao">
                    <label>Buscar</label>
                </div>
            </div>
            <div class="col l5 m5 s12">
                <div class="input-field">
                    <i class="material-icons prefix hide-on-med-and-up">search</i>
                    <input placeholder="Busque por Nome" type="text" class="FindNome" id="nome">
                    <label>Buscar</label>
                </div>
            </div>
        </div>

        <div class="card col l10 m10 s12 offset-l1 offset-m1 servico">

        </div>
    </div>
</main>
<?php
    include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    $(document).ready(function(){
        buscarTodos();
    });

    $(".localizacao").keyup(function () {
        buscaPorLocal();
    });

    $(".FindNome").keyup(function () {
        buscarPorNome();
    });

    function buscarPorNome() {
        var dados = $("#nome").val();
        console.log(dados);
        if (dados === ""){
            buscarTodos();
        } else {
            $.ajax({
                url: '../Controle/servicoControle.php?function=selectPorNome',
                data: {'nome': dados},
                type: 'post',
                success: function (data) {
                    $(".servico").html(data);
                }
            });
        }
    }
    function buscaPorLocal() {
        var dados = $(".localizacao").val();
        if (dados === ""){
            buscarTodos();
        } else {
            $.ajax({
                url: '../Controle/servicoControle.php?function=selectPorLocalizacao',
                data: {'local': dados},
                type: 'post',
                success: function (data) {
                    $(".servico").html(data);
                }
            });
        }
    }

    function buscarTodos() {
        $.ajax({
            url: '../Controle/servicoControle.php?function=selectAllServicosAjax',
            success: function (data) {
                $(".servico").html(data);
            }
        });
    }



</script>