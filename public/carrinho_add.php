<?php
require_once '../config/database.php';
session_start();

$produto_id = $_GET['id'];
$cliente_id = $_SESSION['cliente_id'];

// Verifica se já existe
$item = $conn->query("
    SELECT * FROM carrinho 
    WHERE cliente_id = $cliente_id 
    AND produto_id = $produto_id
")->fetch_assoc();

if ($item) {
    $conn->query("
        UPDATE carrinho 
        SET quantidade = quantidade + 1 
        WHERE id = {$item['id']}
    ");
} else {
    $conn->query("
        INSERT INTO carrinho (cliente_id, produto_id, quantidade)
        VALUES ($cliente_id, $produto_id, 1)
    ");
}

header("Location: loja.php");