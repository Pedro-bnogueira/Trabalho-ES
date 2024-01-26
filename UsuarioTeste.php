<?php
use PHPUnit\Framework\TestCase;

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

function MyTicketAutoload($className) { // carrega as classes da pasta ticket
    $extension = '.class.php';
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $filePath = __DIR__ . '/src/ticket/' . $className . $extension;

    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

function MyUsuarioAutoload($className) { // carrega as classes da pasta usuario
    $extension = '.class.php';
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $filePath = __DIR__ . '/src/usuario/' . $className . $extension;

    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

spl_autoload_register('MyTipoAutoload');
spl_autoload_register('MyCategoriaAutoload');
spl_autoload_register('MyTicketAutoload');
spl_autoload_register('MyUsuarioAutoload');

class UsuarioTeste extends TestCase {

    public function testGetNome() {
        $desconto = new DescontoPadrao();
        $categoria = new Categoria('padrao', $desconto);
        $usuario = new Usuario('Bartolomeu', '433.235.765-70', 100.0, $categoria, 5);

        $this->assertEquals('Bartolomeu', $usuario->getNome());
    }

    public function testGetCategoria() {
        $desconto = new DescontoPadrao();
        $categoria = new Categoria('padrao', $desconto);
        $usuario = new Usuario('Pedro', '356.987.535-90', 80.0, $categoria, 7);

        $this->assertEquals('padrao', $usuario->getCategoria());
    }

    public function testGetSaldo() {
        $desconto = new DescontoPadrao();
        $categoria = new Categoria('padrao', $desconto);
        $usuario = new Usuario('Cristiano Ronaldo', '756.948.383-20', 150.0, $categoria, 1);

        $this->assertEquals(150.0, $usuario->getSaldo());
    }

    public function testGetQtdeTickets() {
        $desconto = new DescontoPadrao();
        $categoria = new Categoria('padrao', $desconto);
        $usuario = new Usuario('Marcos', '834.467.218-73', 50.0, $categoria, 4);

        $this->assertEquals(4, $usuario->getQtdeTickets());
    }

    public function testSetSaldo() {
        $desconto = new DescontoPadrao();
        $categoria = new Categoria('padrao', $desconto);
        $usuario = new Usuario('Abel Ferreira', '898.233.566-77', 77.0, $categoria, 2);

        $usuario->setSaldo(230.0);

        $this->assertEquals(230.0, $usuario->getSaldo());
    }

    public function testAdicionarTicket() {
        $desconto = new DescontoPadrao();
        $categoria = new Categoria('padrao', $desconto);
        $usuario = new Usuario('Marta Vieira', '234.343.757-65', 100.0, $categoria, 5);

        $tipoTicket = new TipoTicketIndividual();
        $tipo = new Tipo('individual', $tipoTicket);
        $ticket = new Ticket($tipo, $categoria);

        $usuario->adicionarTicket($ticket);

        $this->assertCount(1, $usuario->listarTickets());
    }
}

