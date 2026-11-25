
<?php

$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$usuario = "postgres";
$senha = "postgre";

$mensagem = "";

try {

    $pdo = new PDO($dsn, $usuario, $senha);

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $status = $_POST["status"];
        $prioridade = $_POST["prioridade"];
        $data_inicio = $_POST["data_inicio"];
        $data_prazo = $_POST["data_prazo"];

        $sql = "INSERT INTO tasks
                (titulo, descricao, status, prioridade,
                 data_inicio, data_prazo, project_id, user_id)
                VALUES
                (:titulo, :descricao, :status, :prioridade,
                 :data_inicio, :data_prazo, 1, 1)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":titulo" => $titulo,
            ":descricao" => $descricao,
            ":status" => $status,
            ":prioridade" => $prioridade,
            ":data_inicio" => $data_inicio,
            ":data_prazo" => $data_prazo
        ]);

        $mensagem = "Tarefa cadastrada com sucesso!";
    }

} catch (PDOException $e) {

    $mensagem = "Erro: " . $e->getMessage();

}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <head>
    <meta charset="UTF-8">
    <title>Cadastrar Tarefa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px;
            color: #1e293b;
        }

        h1 {
            text-align: center;
            color: #2563eb;
        }

        form {
            background-color: white;
            max-width: 500px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
        }

        button {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .mensagem {
            text-align: center;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
    <meta charset="UTF-8">
    <title>Cadastrar Tarefa</title>
</head>

<body>

    <h1>Cadastrar Nova Tarefa</h1>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" required></textarea><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="pendente">Pendente</option>
            <option value="concluido">Concluído</option>
        </select><br><br>

        <label>Prioridade:</label><br>
        <select name="prioridade">
            <option value="baixa">Baixa</option>
            <option value="media">Média</option>
            <option value="alta">Alta</option>
        </select><br><br>

        <label>Data de início:</label><br>
        <input type="date" name="data_inicio" required><br><br>

        <label>Prazo:</label><br>
        <input type="date" name="data_prazo" required><br><br>

        <button type="submit">Cadastrar Tarefa</button>

    </form>

    <br>

    <a href="listar.php">Voltar para a lista de tarefas</a>

</body>
</html>
