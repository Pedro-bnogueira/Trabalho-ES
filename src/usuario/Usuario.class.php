<?php

class Usuario {
    private $nome;
    private $cpf;
    private $saldo;
    private $categoria;
    private $tickets;
    private $qtdeTickets;

    public function __construct($nome, $cpf, $saldo, Categoria $categoria, $qtdeTickets) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->saldo = $saldo;
        $this->categoria = $categoria;
        $this->qtdeTickets = $qtdeTickets;
    }

    // * Getters
    public function getNome() {
        return $this->nome;
    }

    public function getCategoria() {
        return $this->categoria->getNome();
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getQtdeTickets() {
        return $this->qtdeTickets;
    }

    // * Setter
    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    // * Funcoes de tickets
    public function adicionarTicket(Ticket $ticket) {
        $this->tickets[] = $ticket;
    }

    public function listarTickets() {
        $listaTickets = array();
        foreach ($this->tickets as $ticket) {
            $listaTickets[] = "ID: " . $ticket->getId() . ", Valor: " . $ticket->getValor();
        }
        return $listaTickets;
    }

    // * Banco de dados
    public function save($quantidade, $saldo) {
        $conn = Connection::getInstance();
        
        if (!$conn) {
            $mensagem = 'Problemas na conexão!!';
        } else {
            // Verifica se já existe um registro com o nome selecionado
            $checkSql = "SELECT * FROM Usuario WHERE nome = '" . $this->getNome() . "'";
            $result = mysqli_query($conn, $checkSql);
    
            if (!$result) {
                $mensagem = 'Erro ao verificar o registro existente: ' . mysqli_error($conn);
            } else {
                // Se já existir um registro com o nome do usuário selecionado, realiza o UPDATE
                if (mysqli_num_rows($result) > 0) {
                    $updateSql = "UPDATE Usuario SET qtd_tickets = qtd_tickets + '" . $quantidade . "', saldo = '" . $saldo . "' WHERE nome = '" . $this->getNome() . "'";
    
                    if (mysqli_query($conn, $updateSql)) {
                        $mensagem = "Dados atualizados para o usuário '" . $this->getNome() . "'";
                    } else {
                        $mensagem = 'Erro ao atualizar dados: ' . mysqli_error($conn);
                    }
                } else {
                    $mensagem = "Não foi encontrado nenhum registro com o nome '" . $this->getNome() . "'";
                }
            }
        }
        return $mensagem;
    }

}