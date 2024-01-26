<?php

$mensagem = "";
// Verifica se as variáveis estão definidas na URL
if (isset($_GET['mensagem'])) {
    // Recupera os valores
    $mensagem = $_GET['mensagem'];
}
?>

<html>
    <body>
    <h1>Sua compra foi confirmada!</h1>

    Mensagem: <font color="#AA0000"><?php echo $mensagem;?></font><br> <br>

    </body>
</html>