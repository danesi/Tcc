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
    <div class="chips chips-autocomplete"></div>
    <button class="aaa">vai</button>
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