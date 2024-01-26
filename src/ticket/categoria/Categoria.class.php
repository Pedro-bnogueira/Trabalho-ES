<?php
class Categoria {

    private $nome;
    private $desconto;

    public function __construct($nome, Desconto $desconto) {
        $this->nome = $nome;
        $this->desconto = $desconto;
    }

    public function getDesconto() {
        return $this->desconto->retornaDesconto();
    }

    public function getNome() {
        return $this->nome;
    }
}