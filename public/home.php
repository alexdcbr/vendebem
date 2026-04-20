<?php
require_once '../config/database.php';
include 'partials/header.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}
?>

<div class="card">
    <h1>Bem-vindo, <?= $_SESSION['cliente_nome'] ?></h1>

    <h3>Menu</h3>

    <ul>
        <li><a href="loja.php">🛒 Ir para Loja</a></li>
        <li><a href="carrinho.php">🧺 Meu Carrinho</a></li>
        <li><a href="vendas.php">📦 Minhas Compras</a></li>
    </ul>
</div>

<?php include 'partials/footer.php'; ?>