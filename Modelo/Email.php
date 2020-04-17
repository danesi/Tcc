<?php
    include_once __DIR__.'/../Controle/conexao.php';
    include_once __DIR__.'/../Controle/usuarioPDO.php';
    include_once __DIR__.'/../Modelo/Usuario.php';
    include_once __DIR__.'/../Modelo/Email.php';
    require_once __DIR__.'/../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Email
    {

        private $destino;
        private $assunto;
        private $bodyHTML;
        private $body;

        public function send() : bool
        {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = true;
                $mail->isSMTP();
                $mail->Host       = 'email-smtp.sa-east-1.amazonaws.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'AKIAZ3OWA5SLUVKQLB5D';
                $mail->Password   = 'BBiAFEeNqD1c/Jf278NKCQ1B4SliMvxok4rBOYswRsjx';
                $mail->SMTPSecure = "tls";
                $mail->Port       = 587;
                $mail->CharSet = "utf-8";

                //Recipients
                $mail->setFrom('daniel.o.anesi@outlook.com', 'EasyJobs');
                $mail->addAddress('daniel.o.anesi@gmail.com', 'Daniel Anesi');
                $mail->isHTML(true);
                $mail->Subject = $this->assunto;
                $mail->Body    = $this->body;
                $mail->AltBody = $this->bodyHTML;
                $mail->send();
                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                return false;
            }
        }

        /**
         * @return mixed
         */
        public function getDestino()
        {
            return $this->destino;
        }

        /**
         * @param mixed $destino
         */
        public function setDestino($destino): void
        {
            $this->destino = $destino;
        }

        /**
         * @return mixed
         */
        public function getAssunto()
        {
            return $this->assunto;
        }

        /**
         * @param mixed $assunto
         */
        public function setAssunto($assunto): void
        {
            $this->assunto = $assunto;
        }

        /**
         * @return mixed
         */
        public function getBody()
        {
            return $this->body;
        }

        /**
         * @param mixed $body
         */
        public function setBody($body): void
        {
            $this->body = $body;
        }

        /**
         * @return mixed
         */
        public function getBodyHTML()
        {
            return $this->bodyHTML;
        }

        /**
         * @param mixed $bodyHTML
         */
        public function setBodyHTML($bodyHTML): void
        {
            $this->bodyHTML = $bodyHTML;
        }

    }
