<?php
$enviado = $_SERVER['REQUEST_METHOD'] === 'POST';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Contato</title>
</head>
<body>
<?php if ($enviado): ?>
    <h2>Dados recebidos</h2>
   <p>Nome: <?= htmlspecialchars(filter_input(INPUT_POST, 'nome') ?? '') ?></p>
<p>Mensagem: <?= htmlspecialchars(filter_input(INPUT_POST, 'mensagem') ?? '') ?></p>
<?php else: ?>
    <form method="POST" action="contato.php">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>Mensagem: <textarea name="mensagem" required></textarea></label><br>
        <button type="submit">Enviar</button>
    </form>
<?php endif; ?>
</body>
</html>