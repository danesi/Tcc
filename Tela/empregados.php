<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EasyJobs</title>
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
        <div class="card col l10 offset-l1 m10 offset-m1 s12">
            <span class="card-title col l6 m6 hide-on-small-only" style="margin-top: 3vh">Empregados</span>
            <span class="card-title col s12 center hide-on-med-and-up" style="margin-top: 3vh">Empregados</span>
            <div class="col l6 m6 s12">
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

        <div class="card col l10 offset-l1 m10 offset-m1 s12 empregado">

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

