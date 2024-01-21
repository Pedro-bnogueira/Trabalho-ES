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
    public function getCategoria() {
        return $this->categoria->getNome();
    }
    public function getId() {
        return $this->id;
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

    // private function definirEstrategia() {
    //     // Obtém o tipo selecionado
    //     $select = $_POST['tipoTicket'];
    //     $tipoSelecionado = $select->value;  
      
    //     // Altera o tipo
    //     switch ($tipoSelecionado) {
    //       case "integral":
    //         $this->estrategiaTipo = new TipoTicketIntegrado();
    //         break;
    //       case "multiplo":
    //         $this->estrategiaTipo = new TipoTicketMultiplo();
    //         break;
    //       case "individual":
    //         $this->estrategiaTipo = new TipoTicketIndividual();
    //         break;
    //     }
      
    //   }
}