<?php
include_once __DIR__ . '/../Modelo/Chat.php';
include_once __DIR__ . "/../Modelo/Usuario.php";
include_once __DIR__ . "/../Controle/conexao.php";

class chatPDO
{
    private $logado;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->logado = new usuario(unserialize($_SESSION['logado']));
        session_write_close();
    }

    function enviaMensagem()
    {

        $chat = new Chat($_REQUEST);
        if ($chat->getMensagem() == "") {
            echo "vazio";
            exit();
        }
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into chat values (default , :id_remetente , :id_destinatario , 0 , '' , :mensagem , default , 0)");
        $stmt->bindValue(":id_remetente", $this->logado->getId_usuario());
        $stmt->bindValue(":id_destinatario", $_GET['destinatario']);
        $stmt->bindValue(":mensagem", $chat->getMensagem());
        if ($stmt->execute()) {
            echo "true";
        } else {
            var_dump($chat);
            echo "false";
        }
    }

    function getNewMessage()
    {
        $pontos = $_GET['pontos'];
        session_write_close();
        if ($_GET['last_id'] == "undefined") {
            sleep(3);
            exit();
        }
        set_time_limit(120);
        $x = 0;
        while ($x < 240) {

            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("select * from chat where (id_remetente = :id_destinatario or id_destinatario = :id_destinatario) and (id_destinatario = :id_remetente or id_remetente = :id_remetente) and id_chat > :id_chat order by data_envio");
            $stmt->bindValue(":id_remetente", $this->logado->getId_usuario());
            $stmt->bindValue(":id_remetente", $this->logado->getId_usuario());
            $stmt->bindValue(":id_destinatario", $_GET['destinatario']);
            $stmt->bindValue(":id_destinatario", $_GET['destinatario']);
            $stmt->bindValue(":id_chat", $_GET['last_id']);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmtUpdate = $pdo->prepare("update chat set visualizado = 1 where id_chat in(select s.* from (select id_chat from chat where (id_remetente = :id_destinatario and id_destinatario = :id_destinatario)) as s)");
                $stmtUpdate->bindValue(":id_remetente", $this->logado->getId_usuario());
                $stmtUpdate->bindValue(":id_destinatario", $_GET['destinatario']);
                $stmtUpdate->execute();
                while ($linha = $stmt->fetch()) {
                    $chat = new Chat($linha);
                    $this->drowMessage($chat, $pontos);
                }
                break;
            }
            $x++;
            usleep(250000);
        }
    }

    private $swich = true;

    function drowMessage(Chat $chat, $pontos)
    {

        $hora = new DateTime($chat->getDataEnvio());

        if ($chat->getIsMedia() == 1) {
            if (strstr($chat->getCaminhoMedia(), ".mp4") === false) {
                if ($this->logado->getId_usuario() == $chat->getIdRemetente()) {
                    echo "
                            <div class='row '>
                            <div class='col l7 s9 offset-s2 offset-l4 card cyan lighten-5'>
                            <div class='card-image'>
                   
                                <img class='materialboxed' src='" . $pontos.  $chat->getCaminhoMedia() . "'>
                                <input class='last_id' hidden value='" . $chat->getIdChat() . "'/>
                                </div>
                                <div class='card-content right'>
                                <span style='color: #5A5A5A; text-align: right; font-size: 9px; margin-left: 5px' >" . $hora->format('d/m H:i') . "</span>
                                </div>
                                </div>
                            </div>
                            ";
                    $this->swich = true;
                } else {
                    echo "
                            <div class='row'>
                            <div class='col l8 s10 offset-s1 offset-l1 card'>
                            <div class='card-image'>
                                
                                <img class='materialboxed' src='" . $pontos.  $chat->getCaminhoMedia() . "'>
                                <input class='last_id' hidden value='" . $chat->getIdChat() . "'/>
                                </div>
                                <div class='card-content'>
                                <p style='color: #5A5A5A; text-align: right; font-size: 9px; margin-left: 5px' >" . $hora->format('d/m H:i') . "</p>
                                </div>
                                </div>
                            </div>
                            ";
                    $this->swich = false;
                }
            } else {
                if ($this->logado->getId_usuario() == $chat->getIdRemetente()) {
                    echo "
                            <div class='row '>
                            <div style='width: 80%; margin-left: 20%'>
                                <video  controls='controls' width='100%' height='auto'>
                                <source src='" . $pontos.  $chat->getCaminhoMedia() . "' type='video/mp4'><source src=\"mov_bbb.flv\" type=\"video/flv\"> Browser Not Supporting
                                </video>
                                <input class='last_id' hidden value='" . $chat->getIdChat() . "'/>            
                                <span style='color: #5A5A5A; text-align: right; font-size: 9px; margin-left: 5px' >" . $hora->format('d/m H:i') . "</span>
                                
                            </div>
                            ";
                    $this->swich = true;
                } else {
                    echo "
                            <div class='row '>
                             <div style='width: 80%; '>
                             <video  controls='controls' width='100%' height='auto'>
                                <source src='" . $pontos.  $chat->getCaminhoMedia() . "' type='video/mp4'><source src=\"mov_bbb.flv\" type=\"video/flv\"> Browser Not Supporting
                                </video>
                                <input class='last_id' hidden value='" . $chat->getIdChat() . "'/>
                               
                                <p style='color: #5A5A5A; text-align: right; font-size: 9px; margin-left: 5px' >" . $hora->format('d/m H:i') . "</p>
                                </div>
                            </div>
                            ";
                    $this->swich = false;
                }
            }
        } else {

            if ($this->logado->getId_usuario() == $chat->getIdRemetente()) {
                echo "
                            <div class='row' style='margin-bottom: 0px'>
                            <div class='col l7 s9 offset-s2 offset-l4 card cyan lighten-5' style='margin-bottom: 2px; margin-top: " . ($this->swich ? "0px" : "10px") . ";'>
                                <span class=' messageChat right-align' style='word-wrap: break-word;'>" .$chat->getMensagem() . "</span>
                                <p style='color: #5A5A5A; text-align: right; font-size: 9px;'class='col s12 messageChat'>" . $hora->format('d/m H:i') . "</p>
                                <input class='last_id' hidden value='" . $chat->getIdChat() . "'/>
                                </div>
                            </div>
                            ";
                $this->swich = true;
            } else {
                echo "
                                <div class='row' style='margin-bottom: 0px'>
                                <div class='col l8 s10 offset-s1 offset-l1 card' style='margin-bottom: 2px; margin-top: " . ($this->swich ? "10px" : "0px") . ";'>
                                    <span class='messageChat ' style='word-wrap: break-word'>" . $chat->getMensagem() . "</span>
                                    <p style='color: #5A5A5A; text-align: left; font-size: 9px;' class='col s12 messageChat'>" . $hora->format('d/m H:i') . "</p>
                                    <input class='last_id' hidden value='" . $chat->getIdChat() . "'/>
                                    </div>
                                    <div class='col l4 hide-on-small-only'></div>
                                </div>
                                ";
                $this->swich = false;
            }
        }
    }

    function selectConversa()
    {

        $pontos = $_GET['pontos'];
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from chat where (id_remetente = :id_destinatario or id_destinatario = :id_destinatario) and (id_destinatario = :id_remetente or id_remetente = :id_remetente) order by data_envio desc limit 20");
        $stmt->bindValue(":id_remetente", $this->logado->getId_usuario());
        $stmt->bindValue(":id_remetente", $this->logado->getId_usuario());
        $stmt->bindValue(":id_destinatario", $_GET['destinatario']);
        $stmt->bindValue(":id_destinatario", $_GET['destinatario']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $updateStmt = $pdo->prepare("update chat set visualizado = 1 where id_chat in (select s.* from (select id_chat from chat where (id_remetente = :id_destinatario) and (id_destinatario = :id_remetente )) as s)");
            $updateStmt->bindValue(":id_remetente", $this->logado->getId_usuario());
            $updateStmt->bindValue(":id_destinatario", $_GET['destinatario']);
            $updateStmt->execute();
            $arrStmt = [];
            while ($linha = $stmt->fetch()) {
                $arrStmt[] = $linha;

            }
            $arrStmt = array_reverse($arrStmt);
            foreach ($arrStmt as $linha) {
                $chat = new Chat($linha);
                $this->drowMessage($chat, $pontos);
            }
        } else {
            echo "De um oi!";
        }
    }

    public function isFirstMessage()
    {
        $id_remetente = $_GET['id_remetente'];
        $id_destinatario = $_GET['id_destinatario'];
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from chat where (id_remetente = :id_remetente and id_destinatario = :id_destinatario) or (id_remetente = :id_destinatario and id_destinatario = :id_remetente)");
        $stmt->bindValue(":id_remetente", $id_remetente);
        $stmt->bindValue(":id_destinatario", $id_destinatario);
        $stmt->execute();
        echo $stmt->rowCount();
    }

    function selectCaixaCompleta($id_usuario)
    {
        //TODO select de auditoria
    }

    function enviaMedia()
    {
//        if(!realpath("../Img/Chat/Media")){
//            mkdir("../Img/Chat/Media");
//        }
        $nome_imagem = hash_file('md5', $_FILES['arquivo']['tmp_name']);
        $ext = explode('.', $_FILES['arquivo']['name']);
        $extensao = "." . $ext[(count($ext) - 1)];
        $extensao = strtolower($extensao);
        $extFinal = ".webp";
        switch ($extensao) {
            case '.jfif':
            case '.jpeg':
            case '.jpg':
                imagewebp(imagecreatefromjpeg($_FILES['arquivo']['tmp_name']), __DIR__ . '/../Img/Chat/Media/' . $nome_imagem . '.webp', 45);
            $extFinal = ".webp";
                break;
            case '.svg':
                move_uploaded_file($_FILES['arquivo']['tmp_name'], __DIR__ . '/../Img/Chat/Media/' . $nome_imagem . '.svg');
                $extFinal = ".svg";
                break;
            case '.png':
                $img = imagecreatefrompng($_FILES['arquivo']['tmp_name']);
                imagepalettetotruecolor($img);
                imagewebp($img, __DIR__ . '/../Img/Chat/Media/' . $nome_imagem . '.webp', 45);
                $extFinal = ".webp";
                break;
            case '.webp':
                imagewebp(imagecreatefromwebp($_FILES['arquivo']['tmp_name']), __DIR__ . '/../Img/Chat/Media/' . $nome_imagem . '.webp', 45);
                $extFinal = ".webp";
                break;
            case '.bmp':
                imagewebp(imagecreatefromwbmp($_FILES['arquivo']['tmp_name']), __DIR__ . '/../Img/Chat/Media/' . $nome_imagem . '.webp', 45);
                $extFinal = ".webp";
                break;
            case '.mp4':
                move_uploaded_file($_FILES['arquivo']['tmp_name'], __DIR__ . '/../Img/Chat/Media/' . $nome_imagem . '.mp4');
                $extFinal = ".mp4";
                break;
        }

        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into chat values (default , :id_remetente , :id_destinatario , 1 , './Img/Chat/Media/" . $nome_imagem . $extFinal . "' , '' , default , 0)");
        $stmt->bindValue(":id_remetente", $this->logado->getId_usuario());
        $stmt->bindValue(":id_destinatario", $_GET['destinatario']);
        if ($stmt->execute()) {
            echo "true";
        } else {

            echo "false";
        }
    }

    function selectListaContatos()
    {
        $con = new conexao();
        $pdo = $con->getConexao();
            $stmt = $pdo->prepare('select u.*  , count(ch.id_chat) as newMessages from usuario as u left outer join  chat as ch on ch.id_remetente = u.id_usuario or ch.id_destinatario = u.id_usuario where (ch.id_remetente = :id_destinatario or ch.id_destinatario = :id_destinatario) and u.id_usuario != :id_destinatario group by u.id_usuario, u.nome asc');
        $stmt->bindValue(':id_destinatario', $this->logado->getId_usuario());
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public function verificaNotificacao($id_remetente, $id_destinatario)
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select count(id_chat) as newMessages from chat where id_destinatario = :id_destinatario and id_remetente = :id_remetente and visualizado = 0;");
        $stmt->bindValue(":id_destinatario", $id_destinatario);
        $stmt->bindValue(":id_remetente", $id_remetente);
        $stmt->execute();
        return $stmt;
    }

    public function CountNotificacao()
    {
        $id_destinatario = $_GET['id'];
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select count(id_chat) as newMessages from chat where id_destinatario = :id_destinatario and visualizado = 0;");
        $stmt->bindValue(":id_destinatario", $id_destinatario);
        $stmt->execute();
        echo $stmt->fetch()['newMessages'];
    }

    function refreshBodyChat()
    {

        $pontos = $_GET['pontos'];
        echo "
        <div class='row'>
            <div class='col s12'>
                <ul class='collection'>
                        ";
        $stmt = $this->selectListaContatos();
        while ($linha = $stmt->fetch()) {
            $usuario = new Usuario($linha);
            $logado = new Usuario(unserialize($_SESSION['logado']));
            $notificacao = $this->verificaNotificacao($usuario->getId_usuario(), $logado->getId_usuario())->fetch();
            echo "  <li class='hoverable vali waves-effect openChat collection-item' id_destinatario='" . $usuario->getId_usuario() . "'>
                                       
                                        <div class='fotoPerfil le' style='background-image: url(" . $pontos . $usuario->getFoto() . ");
                                        float: left;
                                        margin: 0 8px 0 -12px;
                                        background-position: center;
                                        background-repeat: no-repeat;
                                        height: 40px;
                                        width: 40px'
                                        ></div>
                                      
                                        <span class='title'>" . $usuario->getNome() . "</span>".($notificacao['newMessages']==0?"":"<span class='badge corPadrao3 white-text'>".$notificacao['newMessages']."</span>")."
                                </li>";

        }
        echo "            
                </ul>
            </div>
        </div>";
    }

    public function verificaExistChat($id_usuario)
    {
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("select * from chat where id_remetente=:id_usuario or id_destinatario = :id_usuario");
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

}