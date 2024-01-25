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
    $tipoUsuario = $_POST["user"];

    // * Usuario

    switch ($tipoUsuario) { // criacao do objeto de usuario de acordo com a resposta de interfaceUsuario
        case "estudante":
            $usuario = new Usuario("Pedro", "111.111.111-11", 0, new Categoria("estudante", new DescontoEstudante()));
            break;
        case "profissional":
            $usuario = new Usuario("Rafael", "222.222.222-22", 0, new Categoria("profissional", new DescontoProfissional()));
            break;
        case "padrao":
            $usuario = new Usuario("João", "333.333.333-33", 0, new Categoria("padrao", new DescontoPadrao()));
            break;
        case "idoso":
            $usuario = new Usuario("José", "444.444.444-44", 0, new Categoria("idoso", new DescontoIdoso()));
            break;
        default:
            break;
    }

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
            $tipoUsuario = $_POST["user"];

            switch ($tipoUsuario) {
                case "estudante":
                    $_SESSION["usuario"] = new Usuario("Pedro", "111.111.111-11", 0, new Categoria("estudante", new DescontoEstudante()));
                    break;
                case "profissional":
                    $_SESSION["usuario"] = new Usuario("Rafael", "222.222.222-22", 0, new Categoria("profissional", new DescontoProfissional()));
                    break;
                case "padrao":
                    $_SESSION["usuario"] = new Usuario("João", "333.333.333-33", 0, new Categoria("padrao", new DescontoPadrao()));
                    break;
                case "idoso":
                    $_SESSION["usuario"] = new Usuario("José", "444.444.444-44", 0, new Categoria("idoso", new DescontoIdoso()));
                    break;
                default:
                    break;
            }
        }

        // Verifica se os campos foram enviados no formulário atual
        if (isset($_POST["tipo"]) && isset($_POST["categoria"]) && isset($_POST["quantidade"])) {
            $tipo = test_input($_POST["tipo"]);
            $categoria = test_input($_POST["categoria"]);
            $quantidade = test_input($_POST["quantidade"]);

            // Obtém a categoria do usuário a partir da sessão
            if (isset($_SESSION["usuario"])) {
                $categoriaUsuario = $_SESSION["usuario"]->getCategoria();
                $user = $_SESSION["usuario"];

                // Agora você pode comparar $categoriaUsuario com $categoria
                if ($categoriaUsuario != $categoria && $categoria != 'padrao') {
                    $mensagem = "Você não pode comprar tickets dessa categoria!";
                } else {
                    // Prossiga com a compra
                    // Redireciona para interface2.php com os valores necessários
                    header("Location: /es/trabalho-final/interfaceConfirmacao.php?tipo=$tipo&categoria=$categoria&quantidade=$quantidade");
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
