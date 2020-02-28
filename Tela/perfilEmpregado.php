<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once "../Modelo/Usuario.php";
    include_once "../Modelo/Empregado.php";
    include_once "../Controle/EmpregadoPDO.php";
    $usuario = new Usuario(unserialize($_SESSION['logado']));
    $empregadoPDO = new EmpregadoPDO();
    $empregado = new Empregado($empregadoPDO->selectEmpregadoId_usuario($usuario->getId_usuario())->fetch());
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

        <div class="card col s10 offset-s1">
            <h4 class="textoCorPadrao2 center">Perfil de empregado</h4>
            <div class="divider"></div>
            <div class="center">
                <h6 class="center">É dessa maneira que seu perfil sera mostrado para as outras pessoas</h6>
            </div>
            <div class="row center">
                <div class="col s3 offset-s1">
                    <div class="card">
                        <div class="card-image">
                            <img src="../<?= $usuario->getFoto() ?>">
                            <span class="card-title"><?=$usuario->getNome() ?></span>
                            <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped" data-position="bottom" data-tooltip="Nota do empregado">4.5</a>
                        </div>
                        <ul class="card-content">
                            <h5>Áreas de atuação</h5>
                                <?php $areas = explode(",", $empregado->getArea_atuacao());
                                    foreach ($areas as $area) { ?>
                                        <div class="chip"><?= $area ?></div>
                                <?php
                                    }
                                ?>
                            <h5>Ecolaridade</h5>
                            <div class="chip"><?= $empregado->getEscolaridade() ?></div>
                        </div>
                    </div>
                    <div class="right-divider"></div>
                    <div class="card col s6 offset-s1">
                        <div class="card-title">Editar dados</div>
                        <form action="">

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
</body>
</html>
<script>
    $('.tooltipped').tooltip();
</script>