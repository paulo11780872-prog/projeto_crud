
<?php
$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$usuario = "postgres";
$senha = "postgre";

try {
    $pdo = new PDO($dsn, $usuario, $senha);

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    header("Location: listar.php");
    exit;

} catch (PDOException $e) {
    echo "Erro ao excluir tarefa: " . $e->getMessage();
}
?>
