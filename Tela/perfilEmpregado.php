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
            <!--            <div class="center">-->
            <!--                <h6 class="center">É dessa maneira que seu perfil sera mostrado para as outras pessoas</h6>-->
            <!--            </div>-->
            <div class="row center">
                <div class="col s3 offset-s1">
                    <div class="card z-depth-3">
                        <div class="card-image">
                            <img src="../<?= $usuario->getFoto() ?>">
                            <span class="card-title"><?= $usuario->getNome() ?></span>
                            <a class="btn-floating halfway-fab waves-effect waves-light orange darken-2 tooltipped"
                               data-position="bottom" data-tooltip="Nota do empregado">4.5</a>
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
                <div class="card col s6 offset-s1 z-depth-3">
                    <div class="card-title">Editar dados</div>
                    <div class="divider"></div>
                    <br>
                    <form action="../Controle/EmpregadoControle.php?function=editar" method="post">
                        <input name="id_usuario" value="<?= $empregado->getId_usuario() ?>" hidden>
                        <div class="input-field col l10 m5 s12 offset-l1 offset-m1">
                            <select name="escolaridade" required>
                                <option value="Fundamental - Incompleto" <?= $empregado->getEscolaridade() == "Fundamental - Incompleto" ? 'selected' : '' ?>>
                                    Fundamental - Incompleto
                                </option>
                                <option value="Fundamental - Completo" <?= $empregado->getEscolaridade() == "Fundamental - Completo" ? 'selected' : '' ?>>
                                    Fundamental - Completo
                                </option>
                                <option value="Médio - Incompleto" <?= $empregado->getEscolaridade() == "Médio - Incompleto" ? 'selected' : '' ?>>
                                    Médio - Incompleto
                                </option>
                                <option value="Médio - Completo" <?= $empregado->getEscolaridade() == "Médio - Completo" ? 'selected' : '' ?>>
                                    Médio - Completo
                                </option>
                                <option value="Superior - Incompleto" <?= $empregado->getEscolaridade() == "Superior - Incompleto" ? 'selected' : '' ?>>
                                    Superior - Incompleto
                                </option>
                                <option value="Superior - Completo" <?= $empregado->getEscolaridade() == "Superior - Completo" ? 'selected' : '' ?>>
                                    Superior - Completo
                                </option>
                            </select>
                        </div>
                        <div class="input-field col l10 offset-l1">
                            <textarea id="textarea1" class="materialize-textarea"
                                      name="area_atuacao"><?= $empregado->getArea_atuacao() ?></textarea>
                            <label for="textarea1">Áreas de atuação</label>
                        </div>
                        <div class="row">
                            <input type="submit" class="btn corPadrao2" value="salvar">
                        </div>
                    </form>
                    <div class="row">
                        <samp>* Para alterar outros dados pode acessar a pagina de <a
                                    href="./perfil.php">perfil</a></samp>
                    </div>
                </div>
                <div class="card col s6 offset-s1 z-depth-3">
                    <div class="card-title">Excluir perfil</div>
                    <samp>Lorem ipsum dolor sit amet consectetur adipiscing elit magna mi erat, dis pellentesque augue malesuada imperdiet eget euismod faucibus</samp>
                    <div class="row center">
                        <a href="#modalExcluir" class="waves-effect waves-light btn modal-trigger red darken-2">Excluir</a>
                    </div>
                </div>
            </div>
            <div class="row center">
                <a class="btn orange darken-2" href="../index.php">Voltar</a>
            </div>
        </div>

    </div>
    </div>
</main>
</body>
<div id="modalExcluir" class="modal">
    <div class="modal-content">
        <h4>Atenção</h4>
        <p>Você tem certeza que deseja excluir esse perfil de empregado?</p>
    </div>
    <div class="modal-footer">
        <a href="../Controle/EmpregadoControle.php?function=deletar&id_usuario=<?= $empregado->getId_usuario() ?>" class="modal-close waves-effect waves-green btn-flat red darken-2 white-text">Excluir</a>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat orange darken-2 white-text">Cancelar</a>
    </div>
</div>
</html>
<script>
    $('.tooltipped').tooltip();
    $('select').formSelect();
    $('.modal').modal();
</script>