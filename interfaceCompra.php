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

    spl_autoload_register('MyTipoAutoload');
    spl_autoload_register('MyCategoriaAutoload');
    spl_autoload_register('MyTicketAutoload');
    spl_autoload_register('MyUsuarioAutoload');

    // * Variáveis

    $tipo = $categoria = $quantidade = $mensagem = "";
    $usuario = "";
    
    // * Usuario
    
    function loadOne($nomeUsuario) {
        $conn = Connection::getInstance();
    
        if (!$conn) {
            return 'Problemas na conexão!!';
        } else {
            $selectSql = "SELECT * FROM Usuario WHERE nome = '" . $nomeUsuario . "'";
            $result = mysqli_query($conn, $selectSql);
    
            if (!$result) {
                return 'Erro ao recuperar dados: ' . mysqli_error($conn);
            } else {
                // Verifica se encontrou algum registro com o ID fornecido
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    switch ($row['categoria']) { 
                        case "Estudante":
                            $desconto = new DescontoEstudante();
                            break;
                        case "Profissional":
                            $desconto =new DescontoProfissional();
                            break;
                        case "Padrao":
                            $desconto = new DescontoPadrao();
                            break;
                        case "Idoso":
                            $desconto = new DescontoIdoso();
                            break;
                        default:
                            break;
                    }
    
                    // Cria um novo objeto Usuario e preenche com os dados recuperados
                    $usuario = new Usuario(
                        $row['nome'],
                        $row['cpf'],
                        $row['saldo'],
                        new Categoria($row['categoria'], $desconto)
                    );
    
                    return $usuario;
                } else {
                    return "Não foi encontrado nenhum usuário com o Nome '" . $nomeUsuario . "'";
                }
            }
        }
    }

    $mensagem = $_POST["user"];
            

    // * Validacoes
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    // * Envio do formulario
    session_start(); // Inicia ou resume a sessão

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica se o campo "user" foi enviado no formulário anterior
        if (isset($_POST["user"])) {
            $nomeUsuario = $_POST["user"];
            $_SESSION["usuario"] = loadOne($nomeUsuario);            
        }
        

        // Verifica se os campos foram enviados no formulário atual
        if (isset($_POST["tipo"]) && isset($_POST["categoria"]) && isset($_POST["quantidade"])) {
            $tipo = test_input($_POST["tipo"]);
            $categoria = test_input($_POST["categoria"]);
            $quantidade = test_input($_POST["quantidade"]);

            // Obtém a categoria do usuário a partir da sessão
            if (isset($_SESSION["usuario"])) {
                $categoriaUsuario = $_SESSION["usuario"]->getCategoria();
                // Serializa o objeto para uma string
                $usuario_serialized = serialize($_SESSION["usuario"]);

                // Agora você pode comparar $categoriaUsuario com $categoria
                if ($categoriaUsuario != $categoria && $categoria != 'padrao') {
                    $mensagem = "Você não pode comprar tickets dessa categoria!";
                } else {
                    session_write_close(); // Fecha a sessão
                    // Prossiga com a compra
                    // Redireciona para interface2.php com os valores necessários
                    header("Location: /es/trabalho-final/interfaceConfirmacao.php?tipo=$tipo&categoria=$categoria&quantidade=$quantidade&usuario_serialized=" . urlencode($usuario_serialized));
                    exit(); // Certifica-se de que a execução do script é encerrada após o redirecionamento
                }
            } else {
                // Lógica a ser executada se a sessão do usuário não estiver definida
                $mensagem = "Erro: Usuário não definido.";
            }
        }
    }
?>

<html>
<body>
<h1>Compra de Tickets</h1>
<p><font color="#AA0000">* campos obrigatórios</font></p>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <input type="hidden" name="form_submitted" value="1">

    Tipo:<font color="#AA0000">*</font>
    <input type="radio" name="tipo" value="individual" title="Selecione uma opção" required>Individual
    <input type="radio" name="tipo" value="multiplo" title="Selecione uma opção" required>Múltiplo
    <input type="radio" name="tipo" value="integrado" title="Selecione uma opção" required>Integrado <br><br>
    Categoria:<font color="#AA0000">*</font>
    <input type="radio" name="categoria" value="padrao" title="Selecione uma opção" required>Padrão
    <input type="radio" name="categoria" value="estudante" title="Selecione uma opção" required>Estudante
    <input type="radio" name="categoria" value="profissional" title="Selecione uma opção" required>Profissional
    <input type="radio" name="categoria" value="idoso" title="Selecione uma opção" required>Idoso <br><br>
    Quantidade:<font color="#AA0000">*</font> <input type="text" name="quantidade" pattern="[0-9]+" title="Digite apenas números" required> <br><br>
    <input type="submit" value="Avançar"><br> <br>
    Mensagem: <font color="#AA0000"><?php echo $mensagem;?></font><br> <br>

</form>
</body>
</html>
