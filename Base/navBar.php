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
            
            <!--usuario-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='usuario'>Usuario</a>
                <ul id='usuario' class='dropdown-content'>
                    <!--usuariologin-->
                    <li><a href="<?php echo $pontos; ?>./Tela/login.php">login</a></li>
                    <!--usuariologin-->
                    <!--usuarioregistro-->
                    <li><a href="<?php echo $pontos; ?>./Tela/registroUsuario.php">registro</a></li>
                    <!--usuarioregistro-->
                    <!--usuariolistagem-->
                    <li><a href="<?php echo $pontos; ?>./Tela/listagemUsuario.php">listagem</a></li>
                    <!--usuariolistagem-->
                    <!--usuarioitem-->
                
                
                
                </ul>
            </li>
            <!--usuario-->
            
            <!--administrador-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='administrador'>Administrador</a>
                <ul id='administrador' class='dropdown-content'>
                    <!--administradorregistro-->
                    <li><a href="<?php echo $pontos; ?>./Tela/registroAdministrador.php">registro</a></li>
                    <!--administradorregistro-->
                    
                    <!--administradorlistagem-->
                    <li><a href="<?php echo $pontos; ?>./Tela/listagemAdministrador.php">listagem</a></li>
                    <!--administradorlistagem-->
                    <!--administradoritem-->
                
                
                
                </ul>
            </li>
            <!--administrador-->
            
            <!--empregado-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='empregado'>Empregado</a>
                <ul id='empregado' class='dropdown-content'>
                    <!--empregadoregistro-->
                    <li><a href="<?php echo $pontos; ?>./Tela/registroEmpregado.php">registro</a></li>
                    <!--empregadoregistro-->
                    <!--empregadolistagem-->
                    <li><a href="<?php echo $pontos; ?>./Tela/listagemEmpregado.php">listagem</a></li>
                    <!--empregadolistagem-->
                    <!--empregadoitem-->
                
                
                </ul>
            </li>
            <!--empregado-->
            
            <!--empregador-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='empregador'>Empregador</a>
                <ul id='empregador' class='dropdown-content'>
                    <!--empregadorregistro-->
                    <li><a href="<?php echo $pontos; ?>./Tela/registroEmpregador.php">registro</a></li>
                    <!--empregadorregistro-->
                    <!--empregadorlistagem-->
                    <li><a href="<?php echo $pontos; ?>./Tela/listagemEmpregador.php">listagem</a></li>
                    <!--empregadorlistagem-->
                    <!--empregadoritem-->
                
                
                </ul>
            </li>
            <!--empregador-->
            
            <!--endereco-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='endereco'>Endereco</a>
                <ul id='endereco' class='dropdown-content'>
                    <!--enderecoregistro-->
                    <li><a href="<?php echo $pontos; ?>./Tela/registroEndereco.php">registro</a></li>
                    <!--enderecoregistro-->
                    <!--enderecolistagem-->
                    <li><a href="<?php echo $pontos; ?>./Tela/listagemEndereco.php">listagem</a></li>
                    <!--enderecolistagem-->
                    <!--enderecoitem-->
                
                
                </ul>
            </li>
            <!--endereco-->
            
            <!--servico-->
            <li>
                <a class='dropdown-trigger center black-text' style="background-color: transparent" data-hover="true" href='#' data-target='servico'>Servico</a>
                <ul id='servico' class='dropdown-content'>
                    <!--servicoregistro-->
                    <li><a href="<?php echo $pontos; ?>./Tela/registroServico.php">registro</a></li>
                    <!--servicoregistro-->
                    <!--servicolistagem-->
                    <li><a href="<?php echo $pontos; ?>./Tela/listagemServico.php">listagem</a></li>
                    <!--servicolistagem-->
                    <!--servicoitem-->
                
                
                </ul>
            </li>
            <!--servico-->
            <!--proximo-->












        </ul>
    </div>
</nav>
<script>
$('.dropdown-trigger').dropdown({
        coverTrigger: false,
    });
</script>
