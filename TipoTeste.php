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

spl_autoload_register('MyTipoAutoload');

class TipoTeste extends TestCase {
    public function testGetPreco(){
        // * Teste para Individual
        $tipoIndividual = new TipoTicketIndividual();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('individual', $tipoIndividual);

        // Executar o teste
        $this->assertEquals(5.0, $tipo->getPreco());

        // * Teste para Integrado
        $tipoIntegrado = new TipoTicketIntegrado();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('integrado', $tipoIntegrado);

        // Executar o teste
        $this->assertEquals(8.2, $tipo->getPreco());

        // * Teste para Multiplo
        $tipoMultiplo = new TipoTicketMultiplo();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('multiplo', $tipoMultiplo);

        // Executar o teste
        $this->assertEquals(10.0, $tipo->getPreco());
    } 

    public function testGetNome(){
        // * Teste para Individual
        $tipoIndividual = new TipoTicketIndividual();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('individual', $tipoIndividual);

        // Executar o teste
        $this->assertEquals('individual', $tipo->getNome());

        // * Teste para Integrado
        $tipoIntegrado = new TipoTicketIntegrado();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('integrado', $tipoIntegrado);

        // Executar o teste
        $this->assertEquals('integrado', $tipo->getNome());

        // * Teste para Multiplo
        $tipoMultiplo = new TipoTicketMultiplo();

        // Criar uma instancia da classe Tipo
        $tipo = new Tipo('multiplo', $tipoMultiplo);

        // Executar o teste
        $this->assertEquals('multiplo', $tipo->getNome());
    } 

}
