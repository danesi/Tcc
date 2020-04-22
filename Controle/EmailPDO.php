<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Controle/UsuarioPDO.php';
    include_once __DIR__.'/../Modelo/Usuario.php';
    include_once __DIR__.'/../Modelo/Email.php';

    use PHPMailer\PHPMailer\Exception;

    class EmailPDO
    {
        private $mail;

        public function __construct()
        {
            $this->mail = new Email();
        }

        function notificaNovoServico($nome_servico, Usuario $usuario)
        {
            try {
                $usuarioPDO = new UsuarioPDO();
                $adms = $usuarioPDO->selectAdms();
                while ($linha = $adms->fetch()) {
                    $adm = new Usuario($linha);
                    $this->mail->setNome($adm->getNome());
                    $this->mail->setAssunto("Novo serviço cadastrado");
                    $this->mail->setDestino($adm->getEmail());
                    $this->mail->setBody('
                   <!doctype html>
<html lang="br">
<head>
    <meta charset="UTF-8">
</head>
<style>
    div, h4, p {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
<body>
<div>
    <h4>Novo serviço cadastrado</h4>
    <p>O usuário '.$usuario->getNome().' solicitou o cadastro de um novo serviço, por favor acesse o link a baixo para
        avaliar essa solicitação</p>
    <a href="localhost/tcc/tela/solicitacoes.php?nome='.$nome_servico.'">Clique aqui para avaliar essa solicitação</a>
</div>
</body>
</html>
                ');
                    $this->mail->send();
                }
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }