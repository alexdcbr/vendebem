<?php
require_once '../config/database.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// ⚠️ Verificar se categoria está em uso
$uso = $conn->query("
    SELECT COUNT(*) as total FROM produtos WHERE categoria_id = $id
")->fetch_assoc()['total'];

if ($uso > 0) {
    echo "Não é possível excluir. Categoria em uso.";
    exit;
}

$conn->query("DELETE FROM categorias WHERE id = $id");

header("Location: categorias.php");