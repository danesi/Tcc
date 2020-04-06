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
        <div class="card col s10 offset-s1">
            <span class="card-title col s6" style="margin-top: 3vh">Empregados</span>
            <div class="col s6">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <select multiple name="areas[]" class="area">
                        <option value="" disabled>Busque por áreas</option>
                        <?php
                            $areas = $empregadoPDO->selectAllAreasAtuacao();
                            foreach ($areas as $area) {
                                ?>
                                <option value="<?= $area ?>"><?= $area ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <label>Buscar</label>
                </div>
            </div>
        </div>

        <div class="card col s10 offset-s1 empregado">
            <div class="row center">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
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
    $(document).ready(function () {
        getDados();

    });

    $(".area").change(function () {
        getDados();
    });

    function getDados() {
        var dados = [];
        $.each($(".area option:selected"), function () {
            dados.push($(this).val());
        });
        $.ajax({
            url: "../Controle/empregadoControle.php?function=selectEmpregadoProArea",
            data: {'data': dados},
            type: 'post',
            success: function (data) {
                $(".empregado").html(data);
            }
        });
        $('.tooltipped').tooltip();
    }
</script>

