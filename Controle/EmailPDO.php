<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Controle/UsuarioPDO.php';
    include_once __DIR__.'/../Controle/ServicoPDO.php';
    include_once __DIR__.'/../Controle/EmpregadoPDO.php';
    include_once __DIR__.'/../Modelo/Usuario.php';
    include_once __DIR__.'/../Modelo/Servico.php';
    include_once __DIR__.'/../Modelo/Empregado.php';
    include_once __DIR__.'/../Modelo/Email.php';

    use PHPMailer\PHPMailer\Exception;

    class EmailPDO
    {
        private $mail;

        public function __construct()
        {
            $this->mail = new Email();
        }

        function notificaNovoServico($nome_servico, Usuario $usuario): bool
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

        public function notificaAceitamento($id_servico): bool
        {
            try {
                $servicoPDO = new ServicoPDO();
                $usuarioPDO = new UsuarioPDO();
                $servico = new Servico($servicoPDO->selectServicoId_servico($id_servico)->fetch());
                $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($servico->getId_usuario())->fetch());
                $this->mail->setNome($usuario->getNome());
                $this->mail->setAssunto("Serviço aceito");
                $this->mail->setDestino($usuario->getEmail());
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
    <h4>Seu serviço '.$servico->getNome().' foi aceito</h4>
    <p>Nosso administradores avaliaram seu serviço e ele foi aceito. Agora ele estará visivél para todos os usuário do sistema</p>
</div>
</body>
</html>
                ');
                $this->mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function notificaRecusamento($id_servico, $motivo)
        {
            try {
                $servicoPDO = new ServicoPDO();
                $usuarioPDO = new UsuarioPDO();
                $servico = new Servico($servicoPDO->selectServicoId_servico($id_servico)->fetch());
                $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($servico->getId_usuario())->fetch());
                $this->mail->setAssunto("Serviço recusado");
                $this->mail->setNome($usuario->getNome());
                $this->mail->setDestino($usuario->getEmail());
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
    <h4>Seu serviço '.$servico->getNome().' foi recusado</h4>
    <p>Nosso administradores avaliaram seu serviço e ele foi recusado.</p>
    <p>O motivo foi: <b>'.$motivo.'</b></p>
    <p>Por favor tente respeitar esse motivo e cadastre um novo serviço</p>
</div>
</body>
</html>
                ');
                $this->mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function notificaEmpregadoDeletado($id_empregado)
        {
            try {
                $empregadoPDO = new EmpregadoPDO();
                $usuarioPDO = new UsuarioPDO();
                $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($id_empregado)->fetch());
                $this->mail->setAssunto("Perfil de empregado deletado");
                $this->mail->setNome($usuario->getNome());
                $this->mail->setDestino($usuario->getEmail());
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
    <h4>Perfil exlcuido</h4>
    <p>Lamentamos, mas um de nossos administradores excluiu seu perfil de empregado</p>
</div>
</body>
</html>');
                $this->mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function teste()
        {
            try {
                $this->mail->setAssunto("Perfil de empregado deletado");
                $this->mail->setNome('Anesi');
                $this->mail->setDestino('daniel.o.anesi@gmail.com');
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
    <h4>Perfil exlcuido</h4>
    <p>Lamentamos, mas um de nossos administradores excluiu seu perfil de empregado</p>
</div>
</body>
</html>');
                print_r($this->mail->send());
//                return true;
            } catch (Exception $e) {
//                return false;
                print_r($e);
            }
        }
    }