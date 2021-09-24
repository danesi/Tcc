<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EasyJobs</title>
    <?php
    include_once './Base/header.php';
    ?>
<body class="homeimg">
<?php
include_once './Base/iNav.php';
?>
<style>
    #title-site {
        position: absolute;
        margin-top: -30%;
        margin-left: 15%;
    }

    .text-title {
        font-size: 100px
    }

    .text-descripion {
        margin-top: -5vh;
        font-size: 20px
    }

    #title-site-mobile {
        position: absolute;
        margin-top: -150%;
        margin-left: -4%;
    }

    .text-title-mobile {
        font-size: 75px
    }

    .text-descripion-mobile {
        margin-top: -5vh;
        margin-left: 3%;
        margin-right: 3%;
        font-size: 17px
    }

    #desce {
        margin-top: 8vh
    }

    #desce-mobile {
        margin-top: 8vh;
        margin-left: -1%;
    }


    @media only screen and (max-width: 1400px) {
        .text-title {
            margin-top: -10%;
            margin-left: -23%;
        }

        .text-title {
            font-size: 100px
        }

        .text-descripion {
            margin-top: -5vh;
            font-size: 20px;
            margin-left: -23%;
        }

        #desce {
            margin-left: -24%;
        }
    }
</style>
<main>
    <div class="row">
        <!--        <img src="Img/fundo.jpg" alt="" id="imagem" class="hide-on-small-only">-->
        <!--        <img src="Img/fundoMobile.png" alt="" id="imagem" class="hide-on-med-and-up">-->

        <div class="parallax-container">
            <div class="parallax"><img src="Img/fundo.jpg"></div>
        </div>
        <div class="section white">
            <div class="row" id="mais">
                <div class="container">
                    <div class="section">
                        <div class="row center hide-on-small-only" id="title-site">
                            <p class="white-text text-title"><b>EasyJobs</b></p>
                            <p class="white-text text-descripion">Uma plataforma simples e fácil, para dar
                                mais visibilidade para você e sua empresa</p>
                            <a id="desce" class="btn blue darken-1">Saiba mais</a>
                        </div>
                        <div class="row center hide-on-med-and-up" id="title-site-mobile">
                            <p class="white-text text-title-mobile"><b>EasyJobs</b></p>
                            <p class="white-text text-descripion-mobile">Uma plataforma simples e fácil, para dar
                                mais visibilidade para você e sua empresa</p>
                            <a id="desce-mobile" class="btn blue darken-1">Saiba mais</a>
                        </div>
                        <div class="row">
                            <div class="col s12 m4">
                                <div class="icon-block">
                                    <h2 class="center light-blue-text"><i class="medium material-icons">flash_on</i>
                                    </h2>
                                    <h5 class="center">Agilidade</h5>
                                    <p class="light center">
                                        Um site limpo e direto ao ponto, para você ter a facilidade de disponibilizar seu
                                        serviço, ou até mesmo colocar sua vaga de emprego a disposição de quem precisa.
                                    </p>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="icon-block">
                                    <h2 class="center light-blue-text"><i class="medium material-icons">group</i></h2>
                                    <h5 class="center">Visibilidade</h5>
                                    <p class="light center">
                                        Com nós seu serviço tem mais alcance. Estando cadastrado em nosso site, você poderá ser
                                        encontrado por qualquer pessoa, que necessite dos seus serviços.
                                    </p>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="icon-block">
                                    <h2 class="center light-blue-text"><i class="medium material-icons">chat</i></h2>
                                    <h5 class="center">Chat</h5>
                                    <p class="light center">
                                        Nosso site conta com um chat simples e eficiente, para que você possa de forma fácil
                                        entrar em contato com quem for do seu interesse.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="container">
                    <div class="row">
                        <a href="Tela/servicos.php">
                            <div class="card col l5 blue darken-1">
                                <div class="card-title center"><i
                                            class="large material-icons white-text">work_outline</i></div>
                                <div class="card-title center white-text"><b>Serviços</b></div>
                                <p class="light center white-text">
                                    Aqui você pode procurar por serviços que estão precisando de algum trabalhador. Contamos com
                                    filtros para que sua busca seja rápida e eficiente.
                                </p>
                                <div class="row center">
                                    <a href="Tela/servicos.php" class="btn blue">Acessar</a>
                                </div>
                            </div>
                        </a>
                        <a href="Tela/empregados.php">
                            <div class="card col l5 offset-l2 orange darken-1">
                                <div class="card-title center"><i
                                            class="large material-icons white-text">person_outline</i>
                                </div>
                                <div class="card-title center white-text"><b>Empregados</b></div>
                                <p class="light center white-text">
                                    Aqui você pode procurar por pessoas que estão oferecendo sua mão de obra. Contamos também
                                    com
                                    filtros
                                </p>
                                <div class="row center">
                                    <a href="Tela/empregados.php" class="btn orange">Acessar</a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="parallax-container">
            <div class="parallax"><img src="Img/fundo.jpg"></div>
        </div>
    </div>

</main>
<?php
include_once './Base/footer.php';
?>
</body>
</html>
<script>
    $('.parallax').parallax();
    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        indicators: false
    });
    <?php
    if (!isset($_SESSION['logado'])) { ?>
    $("#imagem").css("margin-top", "-11vh");
    <?php } ?>

    $("#desce").click(function () {
        window.scroll({       // 1
            top: document
                .querySelector('#mais')
                .offsetTop,       // 2
            left: 0,
            behavior: 'smooth'// 3
        });
    });
</script>

