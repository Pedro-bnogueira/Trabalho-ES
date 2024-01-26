<?php

$mensagem = "";
// Verifica se as variável está vindo da URL
if (isset($_GET['mensagem'])) {
    // Recupera os valor
    $mensagem = $_GET['mensagem'];
}
?>

<html>
    <body>
    <h1>Sua compra foi confirmada!</h1>

    <font color="#AA0000"><?php echo $mensagem;?></font><br> <br>

    </body>
</html>