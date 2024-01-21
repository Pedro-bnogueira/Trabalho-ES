<?php

class Tipo {

    private $nome;
    private $tipoTicket;

    public function __construct($nome, TipoTicket $tipoTicket) {
        $this->nome = $nome;
        $this->tipoTicket = $tipoTicket;
    }

    public function getPreco() {
        return $this->tipoTicket->getPreco();
    }
    public function getNome() {
        return $this->nome;
    }
}