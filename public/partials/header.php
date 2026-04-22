<?php
session_start();
require_once '../config/database.php';

// 🔥 Páginas públicas
$paginas_publicas = ['login.php', 'register.php'];
$pagina_atual = basename($_SERVER['PHP_SELF']);

// 🔒 Proteção
if (!in_array($pagina_atual, $paginas_publicas)) {

    if (!isset($_SESSION['cliente_id'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SESSION['cliente_tipo'] == 'cliente') {

        $cliente = $conn->query("
            SELECT cadastro_completo 
            FROM clientes 
            WHERE id = {$_SESSION['cliente_id']}
        ")->fetch_assoc();

        if ($cliente['cadastro_completo'] == 0 && $pagina_atual != 'cliente_completar.php') {
            header("Location: cliente_completar.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>VendeBem</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php if (isset($_SESSION['cliente_id'])): ?>

<div class="header">

    <div style="display:flex; align-items:center; gap:10px;">
        <img src="images/logo.png" style="height:100px;">
    </div>

    <span>Olá, <?= $_SESSION['cliente_nome'] ?></span>

</div>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <div class="toggle-btn" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars"></i>
        </div>

        <a href="home.php"><i class="fa-solid fa-house"></i> <span>Home</span></a>
        <a href="loja.php"><i class="fa-solid fa-bag-shopping"></i> <span>Loja</span></a>
        <a href="carrinho.php"><i class="fa-solid fa-cart-shopping"></i> <span>Carrinho</span></a>
        <a href="vendas.php"><i class="fa-solid fa-box"></i> <span>Minhas Compras</span></a>

        <?php if ($_SESSION['cliente_tipo'] == 'admin'): ?>
            <hr>
            <a href="admin_dashboard.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a>
            <a href="admin_pedidos.php"><i class="fa-solid fa-clipboard-list"></i> <span>Pedidos</span></a>
            <a href="produtos.php"><i class="fa-solid fa-box-open"></i> <span>Produtos</span></a>
            <a href="categorias.php"><i class="fa-solid fa-tags"></i> <span>Categorias</span></a>
        <?php endif; ?>

        <hr>

        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> <span>Sair</span></a>

    </div>

    <div class="content">

<?php endif; ?>