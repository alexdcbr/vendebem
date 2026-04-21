<?php
session_start();
require_once '../config/database.php';

// 🔒 Verifica login
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php?erro=acesso_negado");
    exit;
}

// 🔥 Bloqueio de cadastro incompleto
if ($_SESSION['cliente_tipo'] == 'cliente') {

    $cliente = $conn->query("
        SELECT cadastro_completo 
        FROM clientes 
        WHERE id = {$_SESSION['cliente_id']}
    ")->fetch_assoc();

    if ($cliente['cadastro_completo'] == 0 && basename($_SERVER['PHP_SELF']) != 'cliente_completar.php') {
        header("Location: cliente_completar.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Vendas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="header">
    <h2>Sistema de Vendas</h2>

    <div class="menu">

        <!-- 👤 Usuário -->
        <span>Olá, <?= $_SESSION['cliente_nome'] ?></span>

        <!-- 🛒 Área do cliente -->
        <a href="home.php">Home</a>
        <a href="loja.php">Loja</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="vendas.php">Minhas Compras</a>

        <!-- 🔒 ADMIN -->
        <?php if ($_SESSION['cliente_tipo'] == 'admin'): ?>

            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_pedidos.php">Pedidos</a>

            <!-- 🔥 NOVO MENU -->
            <a href="produtos.php">Produtos</a>

        <?php endif; ?>

        <!-- 🚪 Logout -->
        <a href="logout.php">Sair</a>

    </div>
</div>

<div class="container">