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
    include_once $pontos.'Modelo/Usuario.php';
    include_once $pontos.'Controle/EmpregadoPDO.php';
    include_once $pontos.'Controle/ServicoPDO.php';
    $empregadoPDO = new EmpregadoPDO();
    $servicoPDO = new ServicoPDO();
    $usuario = new Usuario(unserialize($_SESSION['logado']));
?>

    <nav class="nav-extended white">
        <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">
            <a href="#" data-target="slide-out" class="sidenav-trigger">
                <i class="material-icons black-text">menu</i>
            </a>
            <a href="<?php echo $pontos; ?>./index.php" class="brand-logo left black-text hide-on-small-only">EasyJobs</a>
            <a href="<?php echo $pontos; ?>./index.php" class="brand-logo black-text center hide-on-med-and-up">EasyJobs</a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <?php if (!$empregadoPDO->verificaEmpregado($usuario->getId_usuario())) { ?>
                        <a href="<?php echo $pontos; ?>./Tela/registroEmpregado.php">
                            <div class="chip blue darken-1 white-text">Quero trabalhar</div>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo $pontos; ?>./Tela/perfilEmpregado.php">
                            <div class="chip blue darken-1 white-text">Perfil empregado</div>
                        </a>
                    <?php } ?>
                </li>
                <li>
                    <?php if (!$servicoPDO->verificaServico($usuario->getId_usuario())) { ?>
                        <a href="#modalEmpregador" class="modal-trigger">
                            <div class="chip orange darken-1 white-text">Quero disponibilizar</div>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo $pontos; ?>./Tela/perfilServico.php">
                            <div class="chip orange darken-1 white-text">Perfil servico</div>
                        </a>
                    <?php } ?>
                </li>
                <li>
                    <a class="dropdown-trigger black-text" data-target='dropListagens'>
                        <div class="chip detalheSuave black-text">Listagens</div>
                    </a>
                    <ul id='dropListagens' class=' dropdown-content'>
                        <li><a href="<?php echo $pontos ?>Tela/listagemEmpregado.php" class="black-text">Empregados</a>
                        </li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemEmpregador.php"
                               class="black-text">Empregadores</a></li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemServico.php" class="black-text">Serviços</a>
                        </li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemUsuario.php" class="black-text">Usuários</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $pontos ?>./Tela/solicitacoes.php">
                        <div class="chip detalheSuave black-text">Solicitações</div>
                    </a>
                </li>
                <li>
                    <a class="dropdown-trigger black-text" data-target='dropPerfil'>
                        <div class="chip">
                            <img src="<?php echo $usuario->getFoto() != null ? $pontos.$usuario->getFoto() : $pontos."/Img/Perfil/default.png" ?>"
                                 alt="Contact Person">
                            <?php echo $usuario->getNome(); ?>
                        </div>
                    </a>
                    <ul id='dropPerfil' class=' dropdown-content'>
                        <li><a href="<?php echo $pontos ?>Tela/perfil.php" class="black-text">Meu Perfil</a></li>
                        <li><a href="<?php echo $pontos; ?>./Controle/usuarioControle.php?function=logoff"
                               class="black-text">Sair</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="<?php echo $pontos; ?>Img/bg1.jpg">
                </div>
                <a href="#user">
                    <div class="fotoPerfil left-align"
                         style="background-image: url('<?php echo $pontos.$usuario->getFoto(); ?>');background-size: cover;
                                 background-position: center;
                                 background-repeat: no-repeat;
                                 max-height: 20vh; max-width: 20vh;">
                    </div>
                </a>
                <a href="#name"><span class="white-text name"><?php echo $usuario->getNome(); ?></span></a>
                <a href="#email"><span class="white-text email"><?php echo $usuario->getEmail(); ?></span></a>
            </div>
        </li>
        <ul class="collapsible">

            <a href="<?php echo $pontos; ?>./index.php" class="black-text">
                <li>
                    <div class="headerMeu black-text" style="margin-left: 16px">
                        Inicio
                    </div>
                </li>
            </a>

            <?php if (!$empregadoPDO->verificaEmpregado($usuario->getId_usuario())) { ?>
                <a href="<?php echo $pontos; ?>./Tela/registroEmpregado.php">
                    <li>
                        <div class="headerMeu black-text" style="margin-left: 16px">
                            Quero trabalhar
                        </div>
                    </li>
                </a>
            <?php } else { ?>
                <a href="<?php echo $pontos; ?>./Tela/perfilEmpregado.php">
                    <li>
                        <div class="headerMeu black-text" style="margin-left: 16px">
                            Perfil empregado
                        </div>
                    </li>
                </a>
            <?php } ?>

            <?php if (!$servicoPDO->verificaServico($usuario->getId_usuario())) { ?>
                <a href="#modalEmpregador" class="modal-trigger">
                    <li>
                        <div class="headerMeu black-text" style="margin-left: 16px">
                            Quero disponibilizar
                        </div>
                    </li>
                </a>
            <?php } else { ?>
                <a href="<?php echo $pontos; ?>./Tela/perfilServico.php">
                    <li>
                        <div class="headerMeu black-text" style="margin-left: 16px">
                            Perfil serviço
                        </div>
                    </li>
                </a>
            <?php } ?>

            <li>
                <div class="collapsible-header anime" x="0">Listagens<i class="large material-icons animi">arrow_drop_down</i>
                </div>
                <div class="collapsible-body">
                    <ul class="grey lighten-2">
                        <li><a href="<?php echo $pontos ?>Tela/listagemEmpregado.php" class="black-text">Empregados</a>
                        </li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemEmpregador.php"
                               class="black-text">Empregadores</a></li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemServico.php" class="black-text">Serviços</a>
                        </li>
                        <li><a href="<?php echo $pontos; ?>Tela/listagemUsuario.php" class="black-text">Usuários</a>
                        </li>
                    </ul>
                </div>
            </li>

            <a href="<?php echo $pontos; ?>./Tela/solicitacoes.php">
                <li>
                    <div class="headerMeu black-text" style="margin-left: 16px">
                        Solicitações
                    </div>
                </li>
            </a>

            <li>
                <div class="collapsible-header anime" x="0"><?= $usuario->getNome() ?><i
                            class="large material-icons animi">arrow_drop_down</i></div>
                <div class="collapsible-body">
                    <ul class="grey lighten-2">
                        <li><a href="<?php echo $pontos ?>Tela/perfil.php" class="black-text">Meu Perfil</a></li>
                        <li><a href="<?php echo $pontos; ?>./Controle/usuarioControle.php?function=logoff"
                               class="black-text">Sair</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </ul>

    <div id="modalEmpregador" class="modal">
        <div class="modal-content">
            <h4 class="textoCorPadrao2">Atenção</h4>
            <p>Para você disponibilizar um serviço, você precisa ter um perfil de empregador com algumas informação a
                mais...</p>
            <p>Logo após esse pocesso você poderá cadastrar seu serviço normalmente.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat orange darken-2 white-text">Voltar</a>
            <a href="<?php echo $pontos ?>Tela/registroEmpregador.php"
               class="modal-close waves-effect waves-green btn-flat white-text blue darken-2">Continuar</a>
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
<?php
