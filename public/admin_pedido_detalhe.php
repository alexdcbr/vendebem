<?php
require_once '../config/database.php';
include 'partials/header.php';

$id = $_GET['id'];

// 🔹 Dados do pedido
$pedido = $conn->query("
    SELECT vendas.*, clientes.nome 
    FROM vendas
    JOIN clientes ON vendas.cliente_id = clientes.id
    WHERE vendas.id = $id
")->fetch_assoc();

// 🔹 Itens do pedido
$itens = $conn->query("
    SELECT itens_venda.*, produtos.nome 
    FROM itens_venda
    JOIN produtos ON itens_venda.produto_id = produtos.id
    WHERE venda_id = $id
");

$total = 0;
?>

<div class="card">
    <h1>📦 Pedido #<?= $id ?></h1>

    <p><b>Cliente:</b> <?= $pedido['nome'] ?></p>
    <p><b>Pagamento:</b> <?= strtoupper($pedido['pagamento']) ?></p>
    <p><b>Status:</b> <?= strtoupper($pedido['status_pagamento']) ?></p>

    <hr>

    <h3>Itens</h3>

    <table>
        <tr>
            <th>Produto</th>
            <th>Qtd</th>
            <th>Valor</th>
            <th>Subtotal</th>
        </tr>

        <?php while($item = $itens->fetch_assoc()):
            $subtotal = $item['quantidade'] * $item['valor'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $item['nome'] ?></td>
            <td><?= $item['quantidade'] ?></td>
            <td>R$ <?= number_format($item['valor'], 2, ',', '.') ?></td>
            <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Total: R$ <?= number_format($total, 2, ',', '.') ?></h2>

    <br>

    <a href="admin_pedidos.php">⬅ Voltar</a>
</div>

<?php include 'partials/footer.php'; ?>