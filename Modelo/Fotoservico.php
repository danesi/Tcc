<?php

    class Fotoservico
    {
        private $id_fotoservico;
        private $id_servico;
        private $caminho;

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

        public function getIdFotoservico()
        {
            return $this->id_fotoservico;
        }

        public function setIdFotoservico($id_fotoservico)
        {
            $this->id_fotoservico = $id_fotoservico;
        }

        public function getIdServico()
        {
            return $this->id_servico;
        }

        public function setIdServico($id_servico)
        {
            $this->id_servico = $id_servico;
        }

        public function getCaminho()
        {
            return $this->caminho;
        }

        public function setCaminho($caminho)
        {
            $this->caminho = $caminho;
        }


    }