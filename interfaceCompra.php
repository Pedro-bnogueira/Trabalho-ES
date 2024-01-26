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
    $infoUsuario = "";
    
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
                        new Categoria($row['categoria'], $desconto),
                        $row['qtd_tickets']
                    );
    
                    return $usuario;
                } else {
                    return "Não foi encontrado nenhum usuário com o Nome '" . $nomeUsuario . "'";
                }
            }
        }
    }
     
    $infoUsuario = loadOne($_POST["user"]);

    $mensagemAlerta1 = alerta($infoUsuario);
    $mensagemAlerta2 = categoria($infoUsuario);

    // * Alerta

    function alerta($infoUsuario) {
        if($infoUsuario instanceof Usuario) {
            if ($infoUsuario->getQtdeTickets() > 1) {
                return 'Quantidade atual de tickets: ' . $infoUsuario->getQtdeTickets() . '<br><br>';
            } else {
                return 'Atenção! Você possui ' . $infoUsuario->getQtdeTickets() . ' ticket<br><br>';
            }

        } else {
            return '';
        }
    }

    function categoria($infoUsuario) {
        if($infoUsuario instanceof Usuario) {
            $infoUsuario->getCategoria();
            return 'Para o seu usuário é permitido a categoria: '. $infoUsuario->getCategoria() . '<br> <br>';
        } else {
            return '';
        }
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
        // Verifica se o input "user" foi enviado do formulário anterior
        if (isset($_POST["user"])) {
            $nomeUsuario = $_POST["user"];
            $_SESSION["usuario"] = loadOne($nomeUsuario);            
        }
        

        // Verifica se os campos foram enviados no formulário atual
        if (isset($_POST["tipo"]) && isset($_POST["categoria"]) && isset($_POST["quantidade"])) {
            $tipo = test_input($_POST["tipo"]);
            $categoria = test_input($_POST["categoria"]);
            $quantidade = test_input($_POST["quantidade"]);

            // Obtém o usuário a partir da sessão
            if (isset($_SESSION["usuario"])) {
                $categoriaUsuario = $_SESSION["usuario"]->getCategoria();
                // Serializa o objeto para uma string
                $usuario_serialized = serialize($_SESSION["usuario"]);

                if ($categoriaUsuario != $categoria && $categoria != 'Padrao') {
                    $mensagem = 'Você não pode comprar tickets dessa categoria!';
                } else {
                    session_write_close(); // Fecha a sessão

                    // Redireciona para interfaceConfirmacao.php
                    header("Location: /es/trabalho-final/interfaceConfirmacao.php?tipo=$tipo&categoria=$categoria&quantidade=$quantidade&usuario_serialized=" . urlencode($usuario_serialized));
                    exit();
                }
            } else {
                // Caso o usuário não esteja definido
                $mensagem = "Erro: Usuário não definido.";
            }
        }
    }
?>

<html>
<body>
<h1>Compra de Tickets</h1>


<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <input type="hidden" name="form_submitted" value="1">
    
    <font ><?php echo $mensagemAlerta1;?></font>
    <font ><?php echo $mensagemAlerta2;?></font>
    <p><font color="#AA0000">* campos obrigatórios</font></p>
    
    Tipo:<font color="#AA0000">*</font>
    <input type="radio" name="tipo" value="individual" title="Selecione uma opção" required>Individual (R$ 05,00)
    <input type="radio" name="tipo" value="multiplo" title="Selecione uma opção" required>Múltiplo (R$ 10,00)
    <input type="radio" name="tipo" value="integrado" title="Selecione uma opção" required>Integrado (R$ 08,20)<br><br>
    Categoria:<font color="#AA0000">*</font>
    <input type="radio" name="categoria" value="Padrao" title="Selecione uma opção" required>Padrão
    <input type="radio" name="categoria" value="Estudante" title="Selecione uma opção" required>Estudante
    <input type="radio" name="categoria" value="Profissional" title="Selecione uma opção" required>Profissional
    <input type="radio" name="categoria" value="Idoso" title="Selecione uma opção" required>Idoso <br><br>
    Quantidade:<font color="#AA0000">*</font> <input type="text" name="quantidade" pattern="[0-9]+" title="Digite apenas números" required> <br><br>
    (Obs: a categoria Padrao é válida para todos!) <br> <br>
    <input type="submit" value="Avançar"><br> <br>
    <font color="#AA0000"><?php echo $mensagem;?></font><br> <br>

</form>
</body>
</html>
