<?php
use PHPUnit\Framework\TestCase;

class CategoriaTest extends TestCase {

    public function testGetDesconto() {
        // Criar um simulacro para a classe Desconto
        $descontoMock = $this->getMockBuilder(Desconto::class)->getMock();

        // Definir um valor de retorno para o metodo retornaDesconto()
        $descontoMock->method('retornaDesconto')->willReturn(0.1); // Substitua 0.1 pelo valor desejado para o teste

        // Criar uma instancia da classe Categoria com o simulacro de Desconto
        $categoria = new Categoria('NomeCategoria', $descontoMock);

        // Executar o teste
        $this->assertEquals(0.1, $categoria->getDesconto());
    }

    public function testGetNome() {
        // Criar um simulacro para a classe Desconto (nao usado neste teste)
        $descontoMock = $this->getMockBuilder(Desconto::class)->getMock();

        // Criar uma instancia da classe Categoria
        $categoria = new Categoria('NomeCategoria', $descontoMock);

        // Executar o teste
        $this->assertEquals('NomeCategoria', $categoria->getNome());
    }
}

class DescontoEstudanteTest extends TestCase {

    public function testRetornaDesconto() {
        $descontoEstudante = new DescontoEstudante();
        $this->assertEquals(0.5, $descontoEstudante->retornaDesconto());
    }
}

class DescontoIdosoTest extends TestCase {

    public function testRetornaDesconto() {
        $descontoIdoso = new DescontoIdoso();
        $this->assertEquals(0.3, $descontoIdoso->retornaDesconto());
    }
}

class DescontoPadraoTest extends TestCase {

    public function testRetornaDesconto() {
        $descontoPadrao = new DescontoPadrao();
        $this->assertEquals(0.0, $descontoPadrao->retornaDesconto());
    }
}

class DescontoProfissionalTest extends TestCase {

    public function testRetornaDesconto() {
        $descontoProfissional = new DescontoProfissional();
        $this->assertEquals(0.2, $descontoProfissional->retornaDesconto());
    }
}

class TipoTest extends TestCase {

    public function testGetPreco() {
        // Criar um simulacro para a classe TipoTicket
        $tipoTicketMock = $this->getMockBuilder(TipoTicket::class)->getMock();

        // Definir um valor de retorno para o metodo getPreco()
        $tipoTicketMock->method('getPreco')->willReturn(50.0); // Substitua 50.0 pelo valor desejado para o teste

        // Criar uma instancia da classe Tipo com o simulacro de TipoTicket
        $tipo = new Tipo('NomeTipo', $tipoTicketMock);

        // Executar o teste
        $this->assertEquals(50.0, $tipo->getPreco());
    }

    public function testGetNome() {
        // Criar um simulacro para a classe TipoTicket (não usado neste teste)
        $tipoTicketMock = $this->getMockBuilder(TipoTicket::class)
            ->getMock();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('NomeTipo', $tipoTicketMock);

        // Executar o teste
        $this->assertEquals('NomeTipo', $tipo->getNome());
    }
}

class TicketTest extends TestCase {

    public function testGetCategoria() {
        // Criar um simulacro para a classe Categoria
        $categoriaMock = $this->getMockBuilder(Categoria::class)->getMock();

        // Definir um valor de retorno para o metodo getNome()
        $categoriaMock->method('getNome')->willReturn('NomeCategoria'); // Substitua 'NomeCategoria' pelo valor desejado para o teste

        // Criar uma instancia da classe Ticket com simulacros de Tipo e Categoria
        $ticket = new Ticket($this->getTipoMock(), $categoriaMock);

        // Executar o teste
        $this->assertEquals('NomeCategoria', $ticket->getCategoria());
    }

    public function testGetId() {
        // Criar simulacros para as classes Tipo e Categoria (nao usados neste teste)
        $tipoMock = $this->getTipoMock();
        $categoriaMock = $this->getMockBuilder(Categoria::class)->getMock();

        // Criar uma instancia da classe Ticket
        $ticket = new Ticket($tipoMock, $categoriaMock);

        // Executar o teste
        $this->assertGreaterThanOrEqual(1, $ticket->getId());
    }

    public function testGetValor() {
        // Criar simulacros para as classes Tipo e Categoria
        $tipoMock = $this->getTipoMock();
        $categoriaMock = $this->getMockBuilder(Categoria::class)->getMock();

        // Definir um valor de retorno para o metodo getDesconto()
        $categoriaMock->method('getDesconto')->willReturn(0.1); // Substitua 0.1 pelo valor desejado para o teste

        // Criar uma instancia da classe Ticket com simulacros de Tipo e Categoria
        $ticket = new Ticket($tipoMock, $categoriaMock);

        // Executar o teste
        $this->assertEquals(9.0, $ticket->getValor()); // Substitua 9.0 pelo valor esperado apos aplicar o desconto
    }

    public function testGetTipo() {
        // Criar um simulacro para a classe Tipo
        $tipoMock = $this->getTipoMock();

        // Definir um valor de retorno para o metodo getNome()
        $tipoMock->method('getNome')->willReturn('NomeTipo'); // Substitua 'NomeTipo' pelo valor desejado para o teste

        // Criar uma instância da classe Ticket com simulacros de Tipo e Categoria
        $ticket = new Ticket($tipoMock, $this->getMockBuilder(Categoria::class)->getMock());

        // Executar o teste
        $this->assertEquals('NomeTipo', $ticket->getTipo());
    }

    private function getTipoMock() {
        // Criar um simulacro para a classe Tipo
        $tipoMock = $this->getMockBuilder(Tipo::class)->getMock();

        // Definir um valor de retorno para o metodo getPreco() (nao usado neste teste)
        $tipoMock->method('getPreco')->willReturn(20.0);

        // Definir um valor de retorno para o metodo getNome()
        $tipoMock->method('getNome')->willReturn('NomeTipo');

        return $tipoMock;
    }
}