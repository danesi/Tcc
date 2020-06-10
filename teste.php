<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
        include_once './Base/header.php';
    ?>
<body class="homeimg">
<?php
    include_once './Base/iNav.php';
?>
<style>
    .rating {
        unicode-bidi: bidi-override;
        direction: rtl;
    }
    .rating > span {
        display: inline-block;
        position: relative;
        width: 1.1em;
    }
    .rating > span:hover:before,
    .rating > span:hover ~ span:before {
        content: "\2605";
        position: absolute;
    }
</style>
<main style="margin-top: 100px;">
    <div class="rating">
        <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
    </div>
</main>
<?php
    include_once './Base/footer.php';
?>
</body>
</html>
<script>
    $('.carousel').carousel();
    $('.materialboxed').materialbox();
</script>
