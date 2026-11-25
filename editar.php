
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$usuario = "postgres";
$senha = "postgre";

try {
    $pdo = new PDO($dsn, $usuario, $senha);

    if (!isset($_GET['id'])) {
        die("Tarefa não encontrada.");
    }

    $id = (int) $_GET['id'];

    // Buscar a tarefa
    $sql = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$tarefa) {
        die("Tarefa não encontrada.");
    }

    // Salvar alterações
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = "UPDATE tasks SET
                    titulo = :titulo,
                    descricao = :descricao,
                    status = :status,
                    prioridade = :prioridade,
                    data_inicio = :data_inicio,
                    data_prazo = :data_prazo,
                    updated_at = NOW()
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'titulo' => $_POST['titulo'],
            'descricao' => $_POST['descricao'],
            'status' => $_POST['status'],
            'prioridade' => $_POST['prioridade'],
            'data_inicio' => $_POST['data_inicio'] ?: null,
            'data_prazo' => $_POST['data_prazo'] ?: null,
            'id' => $id
        ]);

        header("Location: listar.php");
        exit;
    }

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            padding: 30px;
        }

        .container {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Editar Tarefa</h2>

    <form method="POST">

        <label>Título:</label>
        <input type="text" name="titulo"
               value="<?= htmlspecialchars($tarefa['titulo']) ?>"
               required>

        <label>Descrição:</label>
        <textarea name="descricao"><?= htmlspecialchars($tarefa['descricao'] ?? '') ?></textarea>

        <label>Status:</label>
        <select name="status">
            <option value="pendente"
                <?= $tarefa['status'] == 'pendente' ? 'selected' : '' ?>>
                Pendente
            </option>

            <option value="concluido"
                <?= $tarefa['status'] == 'concluido' ? 'selected' : '' ?>>
                Concluído
            </option>
        </select>

        <label>Prioridade:</label>
        <select name="prioridade">
            <option value="baixa"
                <?= $tarefa['prioridade'] == 'baixa' ? 'selected' : '' ?>>
                Baixa
            </option>

            <option value="media"
                <?= $tarefa['prioridade'] == 'media' ? 'selected' : '' ?>>
                Média
            </option>

            <option value="alta"
                <?= $tarefa['prioridade'] == 'alta' ? 'selected' : '' ?>>
                Alta
            </option>
        </select>

        <label>Data de início:</label>
        <input type="date" name="data_inicio"
               value="<?= $tarefa['data_inicio'] ?>">

        <label>Prazo:</label>
        <input type="date" name="data_prazo"
               value="<?= $tarefa['data_prazo'] ?>">

        <button type="submit">Salvar alterações</button>

    </form>

    <br>
    <a href="listar.php">← Voltar para tarefas</a>

</div>

</body>
</html>
