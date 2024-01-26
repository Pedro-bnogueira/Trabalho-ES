<?php

class Ticket {

    private $id;
    private $tipo;
    private $categoria;
    private $valor;

    private static $idSoma = 0;

    public function __construct(Tipo $tipo, Categoria $categoria) {
        $this->id = ++self::$idSoma;
        $this->tipo = $tipo;
        $this->categoria = $categoria;
        $this->precoFinal();
    }

    public function getId() {
        return $this->id;
    }

    public function getCategoria() {
        return $this->categoria->getNome();
    }

    public function getDescontoTicket() {
        return $this->categoria->getDesconto();
    }
    
    public function getValor() {
        return $this->valor;
    }

    public function getTipo() {
        return $this->tipo->getNome();
    }
    private function precoFinal() {
        $this->valor = $this->tipo->getPreco() * (1 - $this->categoria->getDesconto());
    }
}