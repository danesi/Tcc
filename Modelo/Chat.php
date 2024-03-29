<?php


class Chat
{
    private $id_chat;
    private $id_remetente;
    private $id_destinatario;
    private $is_midia;
    private $caminho_midia;
    private $mensagem;
    private $data_envio;


    public function __construct()
    {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    function atualizar($vetor)
    {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

    public function getIdChat()
    {
        return $this->id_chat;
    }

    public function setIdChat($id_chat): void
    {
        $this->id_chat = $id_chat;
    }

    public function getIdRemetente()
    {
        return $this->id_remetente;
    }

    public function setIdRemetente($id_remetente): void
    {
        $this->id_remetente = $id_remetente;
    }

    public function getIdDestinatario()
    {
        return $this->id_destinatario;
    }

    public function setIdDestinatario($id_destinatario): void
    {
        $this->id_destinatario = $id_destinatario;
    }

    public function getIsMedia()
    {
        return $this->is_midia;
    }

    public function setIsMedia($is_midia): void
    {
        $this->is_midia = $is_midia;
    }

    public function getCaminhoMedia()
    {
        return $this->caminho_midia;
    }

    public function setCaminhoMedia($caminho_midia): void
    {
        $this->caminho_midia = $caminho_midia;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setMensagem($mensagem): void
    {
        $this->mensagem = $mensagem;
    }

    public function getDataEnvio()
    {
        return $this->data_envio;
    }

    public function setDataEnvio($data_envio): void
    {
        $this->data_envio = $data_envio;
    }


}