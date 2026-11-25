
<?php

$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$usuario = "postgres";
$senha = "postgre";

$tarefas = [];
$erro = "";

try {

    $pdo = new PDO($dsn, $usuario, $senha);

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $sql = "SELECT id, titulo, descricao, status, prioridade,
                   data_inicio, data_prazo
            FROM tasks
            ORDER BY id";

    $stmt = $pdo->query($sql);

    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $erro = "Erro ao buscar tarefas: " . $e->getMessage();

}
?>

<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 30px;
            color: #1e293b;
        }

        h1 {
            color: #2563eb;
        }

        .botao {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .botao:hover {
            background-color: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px #cbd5e1;
        }

        th {
            background-color: #1e40af;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            border: 1px solid #cbd5e1;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        tr:hover {
            background-color: #dbeafe;
        }
    </style>
</head>


<body>

    <h1>Lista de Tarefas</h1>
    <a href="cadastrar.php" class="botao">
    + Cadastrar Nova Tarefa
</a>

    <?php if ($erro != ''): ?>

        <p><?php echo htmlspecialchars($erro); ?></p>

    <?php else: ?>

        <table border="1" cellpadding="8">

            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Prioridade</th>
                <th>Data de início</th>
                <th>Prazo</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($tarefas as $tarefa): ?>

                <tr>
                    <td>
                        <?php echo htmlspecialchars($tarefa['id']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($tarefa['titulo']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($tarefa['descricao']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($tarefa['status']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($tarefa['prioridade']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($tarefa['data_inicio']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($tarefa['data_prazo']); ?>
                    </td>
                    <td>
    <a href="editar.php?id=<?= $tarefa['id'] ?>" class="botao">Editar</a>

    <a href="excluir.php?id=<?= $tarefa['id'] ?>"
       class="botao"
       onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">
       Excluir
    </a>
</td>
                </tr>

            <?php endforeach; ?>

        </table>

    <?php endif; ?>

</body>
</html>
