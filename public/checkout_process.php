<?php
require_once '../config/database.php';
session_start();

// 🔒 Proteção de acesso
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// 🔹 Tipo de pagamento (PIX ou cartão)
$tipo = $_GET['tipo'] ?? 'desconhecido';

// 🔹 Buscar itens do carrinho
$itens = $conn->query("
    SELECT carrinho.*, produtos.valor, produtos.estoque
    FROM carrinho
    JOIN produtos ON carrinho.produto_id = produtos.id
    WHERE cliente_id = $cliente_id
");

// 🔒 Bloqueia carrinho vazio
if ($itens->num_rows == 0) {
    header("Location: carrinho.php");
    exit;
}

// 🔹 Criar venda
$conn->query("
    INSERT INTO vendas (cliente_id, data, status, pagamento, status_pagamento)
    VALUES ($cliente_id, NOW(), 'finalizada', '$tipo', 'aprovado')
");

$venda_id = $conn->insert_id;

// 🔹 Processar itens
while ($item = $itens->fetch_assoc()) {

    $produto_id = $item['produto_id'];
    $quantidade = $item['quantidade'];
    $valor = $item['valor'];
    $estoque = $item['estoque'];

    // 🔒 Validação de estoque
    if ($estoque < $quantidade) {
        header("Location: carrinho.php");
        exit;
    }

    // 🔹 Inserir item na venda
    $conn->query("
        INSERT INTO itens_venda (venda_id, produto_id, quantidade, valor)
        VALUES ($venda_id, $produto_id, $quantidade, $valor)
    ");

    // 🔻 Baixar estoque
    $conn->query("
        UPDATE produtos 
        SET estoque = estoque - $quantidade
        WHERE id = $produto_id
    ");
}

// 🔹 Limpar carrinho
$conn->query("
    DELETE FROM carrinho 
    WHERE cliente_id = $cliente_id
");

// 🔹 Redirecionar para sucesso
header("Location: pedido_sucesso.php?venda_id=$venda_id");
exit;