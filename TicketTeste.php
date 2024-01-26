<?php
use PHPUnit\Framework\TestCase;

function MyTicketAutoload($className) { // carrega as classes da pasta ticket
    $extension = '.class.php';
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $filePath = __DIR__ . '/src/ticket/' . $className . $extension;

    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

function MyTipoAutoload($className) { // carrega as classes da pasta tipo
    $extension = '.class.php';
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $filePath = __DIR__ . '/src/ticket/tipo/' . $className . $extension;

    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

function MyCategoriaAutoload($className) { // carrega as classes da pasta categoria
    $extension = '.class.php';
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $filePath = __DIR__ . '/src/ticket/categoria/' . $className . $extension;

    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

spl_autoload_register('MyTicketAutoload');
spl_autoload_register('MyTipoAutoload');
spl_autoload_register('MyCategoriaAutoload');

class TicketTeste extends TestCase {

    public function testGetIdIncrements() {
        $tipoTicket = new TipoTicketIndividual();
        $desconto = new DescontoPadrao();
        $tipo = new Tipo('individual', $tipoTicket);
        $categoria = new Categoria('padrao', $desconto);
        $ticket1 = new Ticket($tipo, $categoria);
        $ticket2 = new Ticket($tipo, $categoria);

        $this->assertEquals(1, $ticket1->getId());
        $this->assertEquals(2, $ticket2->getId());
    }

    public function testGetCategoria() {
        $tipoTicket = new TipoTicketIndividual();
        $desconto = new DescontoPadrao();
        $tipo = new Tipo('individual', $tipoTicket);
        $categoria = new Categoria('padrao', $desconto);
        $ticket = new Ticket($tipo, $categoria);

        $this->assertEquals('padrao', $ticket->getCategoria());
    }

    public function testGetDescontoTicket() {
        $tipoTicket = new TipoTicketIndividual();
        $desconto = new DescontoPadrao();
        $tipo = new Tipo('individual', $tipoTicket);
        $categoria = new Categoria('padrao', $desconto);
        $ticket = new Ticket($tipo, $categoria);

        $this->assertEquals(0.0, $ticket->getDescontoTicket());
    }

    public function testGetValor() {
        $tipoTicket = new TipoTicketIndividual();
        $desconto = new DescontoPadrao();
        $tipo = new Tipo('individual', $tipoTicket);
        $categoria = new Categoria('padrao', $desconto);
        $ticket = new Ticket($tipo, $categoria);
        
        $this->assertEquals(5.0, $ticket->getValor()); 
    }

    public function testGetTipo() {
        $tipoTicket = new TipoTicketIndividual();
        $desconto = new DescontoPadrao();
        $tipo = new Tipo('individual', $tipoTicket);
        $categoria = new Categoria('padrao', $desconto);
        $ticket = new Ticket($tipo, $categoria);

        $this->assertEquals('individual', $ticket->getTipo());
    } 
}

