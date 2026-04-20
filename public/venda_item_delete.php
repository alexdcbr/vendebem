<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php?erro=acesso_negado");
    exit;
}

$item_id = $_GET['id'];
$venda_id = $_GET['venda_id'];

// 🔒 Validar se venda pertence ao cliente
$check = $conn->query("
    SELECT * FROM vendas 
    WHERE id = $venda_id 
    AND cliente_id = " . $_SESSION['cliente_id']
);

if ($check->num_rows == 0) {
    header("Location: vendas.php");
    exit;
}

// Buscar item
$item = $conn->query("
    SELECT * FROM itens_venda 
    WHERE id = $item_id
")->fetch_assoc();

if ($item) {

    $produto_id = $item['produto_id'];
    $quantidade = $item['quantidade'];

    // 🔺 DEVOLVE ESTOQUE
    $conn->query("
        UPDATE produtos 
        SET estoque = estoque + $quantidade 
        WHERE id = $produto_id
    ");

    // Remove item
    $conn->query("
        DELETE FROM itens_venda 
        WHERE id = $item_id
    ");
}

header("Location: venda_itens.php?venda_id=$venda_id");