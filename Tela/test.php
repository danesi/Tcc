<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
        include_once '../Base/header.php';
        include_once '../Controle/EmpregadoPDO.php';
    ?>
<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="chips chips-autocomplete"></div>
    <button class="aaa">vai</button>


    <form action="../Controle/EmpregadoControle.php?function=selectAllAreasAtuacao" method="post">
        <input type="submit" value="busca">
    </form>
    <br>
    <br>
    <br>
    <br>
    <?php
        $empregadoPDO = new EmpregadoPDO();
        $areas = ['Domestica', 'Pintor'];
        $datas = $empregadoPDO->selectEmpregadoProArea($areas);
        print_r($datas);
        ?>
</main>
</body>
</html>
<script>
    $('.chips').chips();

    $('.chips-autocomplete').chips({
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
        }
    });

    $('.aaa').click(function () {

    });
</script>