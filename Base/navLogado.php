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
include_once $pontos . 'Modelo/Usuario.php';
include_once $pontos.'Controle/EmpregadoPDO.php';
include_once $pontos.'Controle/EmpregadorPDO.php';
$empregadoPDO = new EmpregadoPDO();
$empregadorPDO = new EmpregadorPDO();

$usuario = new Usuario(unserialize($_SESSION['logado']));
?>

<nav class="nav-extended white">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="<?php echo $pontos; ?>./index.php" class="brand-logo left black-text">Tcc</a>
        <ul class="right hide-on-med-and-down">
            <li>
                <?php if(!$empregadoPDO->verificaEmpregado($usuario->getId_usuario())) { ?>
                    <a href="<?php echo $pontos; ?>./Tela/registroEmpregado.php" class="waves-effect waves-light btn blue darken-1">Quero trabalhar</a>
                <?php } else { ?>
                    <a href="<?php echo $pontos; ?>./Tela/perfilEmpregado.php" class="waves-effect waves-light btn blue darken-1">Perfil empregado</a>
                <?php } ?>
            </li>
            <li>
                <?php if(!$empregadorPDO->verificaEmpregador($usuario->getId_usuario())) { ?>
                    <a class="waves-effect waves-light btn orange darken-1 modal-trigger" href="#modalEmpregador">Quero disponibilizar</a>
                <?php } else { ?>
                    <a href="<?php echo $pontos; ?>./Tela/perfilServico.php" class="waves-effect waves-light btn orange darken-1">Perfil servico</a>
                <?php } ?>
            </li>
            <li>
                <a class="dropdown-trigger black-text" data-target='dropPerfil'>
                    <div class="chip">
                        <img src="<?php echo $usuario->getFoto() != null ? $pontos . $usuario->getFoto() : $pontos . "/Img/Perfil/default.png"?>" alt="Contact Person">
                        <?php echo $usuario->getNome(); ?>
                    </div>
                </a>
                <ul id='dropPerfil' class=' dropdown-content'>
                    <li><a href="<?php echo $pontos ?>Tela/perfil.php" class="black-text">Meu Perfil</a></li>
                    <li><a href="<?php echo $pontos; ?>./Controle/usuarioControle.php?function=logoff" class="black-text">Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div id="modalEmpregador" class="modal">
    <div class="modal-content">
        <h4 class="textoCorPadrao2">Atenção</h4>
        <p>Para você disponibilizar um serviço, você precisa ter um perfil de empregador com algumas informação a mais...</p>
        <p>Logo após esse pocesso você poderá cadastrar seu serviço normalmente.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat orange darken-2 white-text">Voltar</a>
        <a href="<?php echo $pontos ?>Tela/registroEmpregador.php" class="modal-close waves-effect waves-green btn-flat white-text blue darken-2">Continuar</a>
    </div>
</div>

<script>
    $('.modal').modal();

    $('.dropdown-trigger').dropdown({
        coverTrigger: false,
    });
    $('.collapsible').collapsible();
    $(document).ready(function () {
        $('.sidenav').sidenav();
    });


    $(".anime").click(function () {
        if ($(this).attr("x") == 0) {
            $(".anime").attr("x", "0");
            $(".animi").attr("style", "transform: rotate(0deg);");
            $(this).children($(".animi")).attr("style", "transform: rotate(180deg);");
            $(this).attr("x", "1");
        } else {
            $(this).children($(".animi")).attr("style", "transform: rotate(0deg);");
            $(this).attr("x", "0");
        }
    });
</script>
