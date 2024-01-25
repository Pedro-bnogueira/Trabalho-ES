<?php

    // * Habilitar o MyAutoload
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

    function MyConnectionAutoload($className) { // carrega as classes da pasta usuario
        $extension = '.class.php';
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filePath = __DIR__ . '/src/conexao-bd' . $className . $extension;

        if (file_exists($filePath)) {
            require_once($filePath);
        }
    }

    spl_autoload_register('MyTipoAutoload');
    spl_autoload_register('MyCategoriaAutoload');
    spl_autoload_register('MyTicketAutoload');
    spl_autoload_register('MyUsuarioAutoload');
    spl_autoload_register('MyConnectionAutoload');

    // * Variáveis
    $tipo = $categoria = $quantidade = $mensagem = $usuario = "";

    // Verifica se as variáveis estão definidas na URL
    if (isset($_GET['tipo']) && isset($_GET['categoria']) && isset($_GET['quantidade'])) {
        // Recupera os valores
        $tipo = $_GET['tipo'];
        $categoria = $_GET['categoria'];
        $quantidade = $_GET['quantidade'];
        $usuario = $_SESSION["usuario"];
    }

    // Criacao do Tipo do Ticket com base no que foi selecionado em interface
    switch ($tipo) {
        case "integral":
            $tipoTicket = new Tipo("integrado", new TipoTicketIntegrado());
            break;
        case "multiplo":
            $tipoTicket = new Tipo("multiplo", new TipoTicketMultiplo());
            break;
        case "individual":
            $tipoTicket = new Tipo("individual", new TipoTicketIndividual());
            break;
        default:
            // Trate outros casos conforme necessário
            break;
    }

    // Criacao da Categoria com base no que foi selecionado em interface
    switch ($categoria) {
        case "padrao":
            $categoriaTicket = new Categoria("padrao", new DescontoPadrao());
            break;
        case "estudante":
            $categoriaTicket = new Categoria("estudante", new DescontoEstudante());
            break;
        case "profissional":
            $categoriaTicket = new Categoria("profissional", new DescontoProfissional());
            break;
        case "idoso":
            $categoriaTicket = new Categoria("idoso", new DescontoIdoso());
        default:
            // Trate outros casos conforme necessário
            break;
    }

    function test_input($data) {
        $data = trim ($data);
        $data = stripslashes ($data);
        $data = htmlspecialchars ($data);
        return $data;
    }

    $ticket = new Ticket($tipoTicket, $categoriaTicket);

    // $mensagem = $usuario->getNome(); 
?>

<html>
<body>
<h1>Confirmação de compra</h1>

    <font color="#AA0000"> Resumo do Pedido: <br><br><br> </font>   
        Tipo do ticket: <?php echo $ticket->getTipo();?><br><br>
        Categoria do ticket: <?php echo $ticket->getCategoria();?><br><br>
        Quantidade: <?php echo $quantidade;?><br><br>
        Preço Final: R$ <?php echo ($quantidade * $ticket->getValor());?><br><br> <br><br>

    <!-- Botões de Ação -->
    <button id="cancelarBtn" onclick="cancelar()" >Cancelar</button>
    <button id="confirmarBtn" onclick="confirmar()" >Confirmar</button>

    <!-- Exibição da Mensagem -->
    <p id="mensagem" style="color: #008000;"><?php echo $mensagem;?></p>

    Mensagem: <font color="#AA0000"><?php echo $mensagem;?></font><br> <br>

    <script>
        function cancelar() {
            // Redireciona o usuário
            window.location.href = '/es/trabalho-final/interfaceUsuario.php';
        }

        function confirmar() {
            // Exibe a mensagem de confirmação
            document.getElementById("mensagem").innerText = "Compra confirmada com sucesso!";

            // Desabilita os botões após a confirmação
            document.getElementById("cancelarBtn").disabled = true;
            document.getElementById("confirmarBtn").disabled = true;

            // Redireciona para a próxima página após 5 segundos
            setTimeout(function() {
                window.location.href = '/es/trabalho-final/interfaceUsuario.php';
            }, 5000); // Tempo em milissegundos (5 segundos neste exemplo)
        }
    </script>

</body>
</html>