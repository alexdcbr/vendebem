<?php
require_once '../config/database.php';
session_start();

$venda_id = $_GET['venda_id'];

// 🔒 Validação da venda
$venda = $conn->query("
    SELECT * FROM vendas 
    WHERE id = $venda_id 
    AND cliente_id = " . $_SESSION['cliente_id']
)->fetch_assoc();

if (!$venda || $venda['status'] == 'finalizada') {
    header("Location: vendas.php");
    exit;
}

// 🔒 Verifica se tem itens
$itens = $conn->query("
    SELECT id FROM itens_venda 
    WHERE venda_id = $venda_id
");

if ($itens->num_rows == 0) {
    header("Location: venda_itens.php?venda_id=$venda_id");
    exit;
}

// 🔹 Finaliza venda
$conn->query("
    UPDATE vendas 
    SET status = 'finalizada' 
    WHERE id = $venda_id
");

header("Location: venda_itens.php?venda_id=$venda_id");