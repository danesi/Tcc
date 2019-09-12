<?php
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
?>

<nav class="nav-extended white">
    <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
        <a href="<?php echo $pontos; ?>./Tela/home.php" class="brand-logo left black-text">Tcc</a>
        <ul class="right hide-on-med-and-down">
            <li>
                <a href="<?php echo $pontos; ?>./Tela/registroEmpregado.php" class="waves-effect waves-light btn blue darken-1">Quero trabalhar</a>
            </li>
            <li>
                <a class="waves-effect waves-light btn orange darken-1">Quero disponibilizar</a>
            </li>
        </ul>
    </div>
</nav>

<ul class="sidenav">
    <li><div class="user-view">
            <a href="#user"><div class="fotoPerfil left-align" style="background-image: url('../Img/tcc.jfif');background-size: cover;
                                 background-position: center;
                                 background-repeat: no-repeat;
                                 max-height: 20vh; max-width: 20vh;"></div></a>
            <a href="#name"><span class="white-text name">aa</span></a>
        </div></li>
    <div class="divider"></div>
    <ul class="collapsible">
        <a href="/index.php" class="black-text">
            <li>
                <div class="headerMeu" style="margin-left: 16px">
                    Início
                </div>
            </li>
        </a>
        <li>
            <div class="collapsible-header anime" x="0">Meu Perfil<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul>
                    <li><a href="Tela/perfil.php" id="linkprestador" class="black-text modal-trigger">Ver Meu Perfil</a></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header anime" x="0">Administração<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul>
                    <li>
                        <a href="Tela/listagemUsuario.php" class="black-text">Ver Usuários
                        </a>
                    </li>
                    <li>
                        <a href="Tela/cadastroUsuarioAdm.php" class="black-text">
                            Cadastrar Usuário
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header anime" x="0">Funcionários<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul>
                    <li><a href="Tela/registroPrestador.php" id="linkprestador" class="black-text modal-trigger">Cadastrar</a></li>
                    <li><a href="Tela/listagemPrestador.php" class="black-text">Ver funcionários</a></li>
                </ul>
            </div>
        </li>
        <li>
            <div class="collapsible-header anime" x="0">Serviços<i class="large material-icons right animi">arrow_drop_down</i></div>
            <div class="collapsible-body">
                <ul>
                    <li><a href="Tela/registroServico.php" class="black-text modal-trigger">Cadastrar</a></li>
                    <li><a href="Tela/listagemServico.php" class="black-text">Ver Serviços</a></li>
                </ul>
            </div>
        </li>
        <a href="Controle/usuarioControle.php?function=logout&url=" class="black-text">
            <li>
                <div class="headerMeu" style="margin-left: 16px">
                    Sair
                </div>
            </li>
        </a>
    </ul>
</ul> 
<script>
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
