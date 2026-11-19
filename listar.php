<?php
$dsn = 'pgsql:host=localhost;port=5432;dbname=projeto_crud';
$usuario = 'postgres';
$senha = 'sua_senha';

$tarefas = [];
$erro = '';

try {
    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT id, titulo, descricao, status FROM tarefas ORDER BY id');
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $erro = 'Erro: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
</head>
<body>
    <h2>Tarefas</h2>

    <?php if ($erro): ?>
        <p><?= htmlspecialchars($erro) ?></p>
    <?php else: ?>
        <table border="1" cellpadding="6">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Status</th>
            </tr>
            <?php foreach ($tarefas as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['id']) ?></td>
                    <td><?= htmlspecialchars($t['titulo']) ?></td>
                    <td><?= htmlspecialchars($t['descricao'] ?? '') ?></td>
                    <td><?= htmlspecialchars($t['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>