<?php

    // * Habilitar o MyAutoload

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

    function MyCategoriaAutoload($className) { // carrega as classes da pasta categoria
        $extension = '.class.php';
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filePath = __DIR__ . '/src/ticket/categoria/' . $className . $extension;

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

    spl_autoload_register('MyTipoAutoload');
    spl_autoload_register('MyCategoriaAutoload');
    spl_autoload_register('MyUsuarioAutoload');
    spl_autoload_register('MyConnectionAutoload');

    function loadAll() {
        $conn = Connection::getInstance();
    
        if (!$conn) {
            return 'Problemas na conexão!!';
        } else {
            $selectSql = "SELECT * FROM Usuario";
            $result = mysqli_query($conn, $selectSql);
            
            
            if (!$result) {
                return 'Erro ao recuperar dados: ' . mysqli_error($conn);
            }
            else {
                $usuarios = array();
                
                if (mysqli_num_rows($result) > 0) {
                    // return 'usuário(s) encontrado.';
                } else {
                    return 'Nenhum usuário encontrado.';
                }

                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

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

                    $usuario = new Usuario(
                        $row['nome'],
                        $row['cpf'],
                        $row['saldo'],
                        new Categoria($row['categoria'], $desconto)
                    );

                    
                    
                    // Adiciona o usuário ao array
                    $usuarios[] = $usuario;
                }
                }
    
                return $usuarios;
            }
        // }
    }

    // Chama a função para recuperar todos os usuários
    $usuarios = loadAll();  
?>


<html>
<body>
<h1>Selecione o Usuário:</h1>
<p><font color="#AA0000">* campos obrigatórios</font></p>
<form method="post" action="interfaceCompra.php">

    <?php if (is_array($usuarios) && count($usuarios) > 0): ?>
        <!-- Exibe uma lista selecionável com os usuários -->
        <label for="usuarios">Selecione um usuário:<font color="#AA0000">*</font></label> <br>
            
            <?php foreach ($usuarios as $usuario): ?>
                <input type="radio" name="user" value="<?php echo $usuario->getNome(); ?>"><?php echo $usuario->getNome(); ?><br>
            <?php endforeach; ?>
    <?php else: ?>
        <!-- Exibe a mensagem de erro -->
        <p><?php echo isset($usuarios) ? $usuarios : ''; ?></p>
    <?php endif; ?>
    <br> <br>
    <input id="anvacarBtn" type="submit" value="Avançar"></input>

</form>
</body>
</html>