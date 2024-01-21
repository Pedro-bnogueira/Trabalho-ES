<?php

class Usuario {
    private $nome;
    private $cpf;
    private $saldo;
    private $categoria;
    private $tickets;

    public function __construct($nome, $cpf, $saldo, Categoria $categoria) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->saldo = $saldo;
        $this->categoria = $categoria;
    }

    // * Getters
    public function getNome() {
        return $this->nome;
    }

    public function getCategoria() {
        return $this->categoria->getNome();
    }

    // * Funcoes de tickets
    public function adicionarTicket(Ticket $ticket) {
        $this->tickets[] = $ticket;
    }

    public function getTickets() {
        return $this->tickets;
    }

    public function listarTickets() {
        $listaTickets = array();
        foreach ($this->tickets as $ticket) {
            $listaTickets[] = "ID: " . $ticket->getId() . ", Valor: " . $ticket->getValor();
        }
        return $listaTickets;
    }

    // funcao para remover um ticket especifico
    public function removerTicket($id) {
        foreach ($this->tickets as $key => $ticket) {
            if ($ticket->getId() === $id) {
                unset($this->tickets[$key]); // funcao do php que destroi uma variavel especificada
                return true; // ticket removido com sucesso
            }
        }
        return false; // ticket não encontrado
    }

    // ! rescunho provisório de como printar a lista -- nao ficara nessa classe
    // Exibir a lista
    // $listaTicketsUsuario = $usuario->listarTickets();
    // foreach ($listaTicketsUsuario as $infoTicket) {
    //     echo $infoTicket . "<br>";
    // }

    // ? É necessário uma funcao usarTicket se já existe a removerTicket?

    // * Funcoes de saldo
    public function adicionarSaldo($quantia) {
        $this->saldo += $quantia;
    }
}