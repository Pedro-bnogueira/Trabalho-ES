<?php
use PHPUnit\Framework\TestCase;
function MyCategoriaAutoload($className) { // carrega as classes da pasta categoria
    $extension = '.class.php';
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $filePath = __DIR__ . '/src/ticket/categoria/' . $className . $extension;

    if (file_exists($filePath)) {
        require_once($filePath);
    }
}

spl_autoload_register('MyCategoriaAutoload');


class CategoriaTeste extends TestCase {

    public function testGetDesconto() {
        
        // * Teste categoria Padrao
        $descontoPadrao = new DescontoPadrao();

        // Criar uma instancia da classe Categoria com o simulacro de Desconto
        $categoria = new Categoria('padrao', $descontoPadrao);

        // Executar o teste
        $this->assertEquals(0.0, $categoria->getDesconto());

        // * Teste categoria Estudante

        $descontoEstudante = new DescontoEstudante();

        // Criar uma instancia da classe Categoria com o simulacro de Desconto
        $categoria = new Categoria('estudante', $descontoEstudante);

        // Executar o teste
        $this->assertEquals(0.5, $categoria->getDesconto());

        // * Teste categoria Profissional

        // Definir um valor de retorno para o metodo retornaDesconto()
        $descontoProfissional = new DescontoProfissional();

        // Criar uma instancia da classe Categoria com o simulacro de Desconto
        $categoria = new Categoria('profissional', $descontoProfissional);

        // Executar o teste
        $this->assertEquals(0.2, $categoria->getDesconto());
    
        // * Teste categoria Idoso
        $descontoIdoso = new DescontoIdoso();
        
        // Criar uma instancia da classe Categoria com o simulacro de Desconto
        $categoria = new Categoria('idoso', $descontoIdoso);

        // Executar o teste
        $this->assertEquals(1, $categoria->getDesconto());
    }

    public function testGetNome() {
        // * Teste para Padrao
        $descontoMock = $this->getMockBuilder(DescontoPadrao::class)->getMock();

        // Criar uma instancia da classe Categoria
        $categoria = new Categoria('Padrao', $descontoMock);

        // Executar o teste
        $this->assertEquals('Padrao', $categoria->getNome());

        // * Teste para Estudante
        $descontoMock = $this->getMockBuilder(DescontoEstudante::class)->getMock();

        // Criar uma instancia da classe Categoria
        $categoria = new Categoria('Estudante', $descontoMock);

        // Executar o teste
        $this->assertEquals('Estudante', $categoria->getNome());

        // * Teste para Profissional
        $descontoMock = $this->getMockBuilder(DescontoProfissional::class)->getMock();

        // Criar uma instancia da classe Categoria
        $categoria = new Categoria('Profissional', $descontoMock);

        // Executar o teste
        $this->assertEquals('Profissional', $categoria->getNome());

        // * Teste para Idoso
        $descontoMock = $this->getMockBuilder(DescontoIdoso::class)->getMock();

        // Criar uma instancia da classe Categoria
        $categoria = new Categoria('Idoso', $descontoMock);

        // Executar o teste
        $this->assertEquals('Idoso', $categoria->getNome());
    }
}