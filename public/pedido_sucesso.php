<?php
require_once '../config/database.php';
include 'partials/header.php';

$venda_id = $_GET['venda_id'];
?>

<div class="card" style="text-align:center;">
    <h1>✅ Pedido Confirmado!</h1>

    <p>Seu pedido foi realizado com sucesso.</p>

    <h2>Pedido #<?= $venda_id ?></h2>

    <br>

    <a href="loja.php">
        <button>Continuar Comprando</button>
    </a>

    <br><br>

    <a href="vendas.php">Ver Minhas Compras</a>
</div>

<?php include 'partials/footer.php'; ?>