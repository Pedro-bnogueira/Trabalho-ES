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

                // Carrega a classe do usuário (ajuste o caminho conforme necessário)
                require_once(__DIR__ . '/src/usuario/Usuario.class.php');

                // Recupera a string serializada do usuário da requisição
                $usuario_serialized = $_GET['usuario_serialized'];

                // Desserializa a string para obter o objeto original
                $usuario = unserialize(urldecode($usuario_serialized));
            }

            // Criacao do Tipo do Ticket com base no que foi selecionado em interface
            switch ($tipo) {
                case "integrado":
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
                case "Padrao":
                    $categoriaTicket = new Categoria("padrao", new DescontoPadrao());
                    break;
                case "Estudante":
                    $categoriaTicket = new Categoria("estudante", new DescontoEstudante());
                    break;
                case "Profissional":
                    $categoriaTicket = new Categoria("profissional", new DescontoProfissional());
                    break;
                case "Idoso":
                    $categoriaTicket = new Categoria("idoso", new DescontoIdoso());
                default:
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
            
            // Verifica se a solicitação foi feita via POST
            session_start(); // Inicia ou resume a sessão
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if($usuario->getSaldo() >= ($ticket->getValor() * $quantidade)){
                    $usuario->setSaldo($usuario->getSaldo() - ($ticket->getValor() * $quantidade));
                    $usuario->adicionarTicket($ticket);
                    
                    // Chama o método save() do objeto $usuario
                    $mensagem = $usuario->save($quantidade);

                    // Redireciona de volta para a página original com os parâmetros
                    header("Location: /es/trabalho-final/mensagem.php?mensagem=$mensagem");

                    exit();
                } else {
                    $mensagem = "Você não possui saldo suficiente para efetuar essa compra!";
                }
                
            } 
        ?>

        <html>
        <body>
        <h1>Confirmação de compra</h1>
            <form id="formConfirmacao" method="post">
                <font color="#AA0000"> Resumo do Pedido: <br><br><br> </font>   
                    Tipo do ticket: <?php echo $ticket->getTipo();?><br><br>
                    Categoria do ticket: <?php echo $ticket->getCategoria();?><br><br>
                    Quantidade: <?php echo $quantidade;?><br><br>
                    Preço Final: R$ <?php echo ($ticket->getValor() * $quantidade);?><br><br> <br><br>

                <!-- Botões de Ação -->
                <a href="http://localhost/es/trabalho-final/interfaceUsuario.php"><button id="cancelarBtn"type="button">Cancelar</button></a>
                <input id="confirmarBtn" type="submit" value="Confirmar"> <br><br>

                <!-- Exibição da Mensagem -->

                Mensagem: <font color="#AA0000"><?php echo $mensagem;?></font><br> <br>

            </form>

        </body>
        </html>