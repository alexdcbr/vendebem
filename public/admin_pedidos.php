<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção de acesso
if (!isset($_SESSION['cliente_id']) || $_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

// 🔹 Buscar pedidos
$pedidos = $conn->query("
    SELECT vendas.*, clientes.nome 
    FROM vendas
    JOIN clientes ON vendas.cliente_id = clientes.id
    ORDER BY vendas.id DESC
");
?>

<div class="card">
    <h1>📦 Painel de Pedidos</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Pagamento</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php while($p = $pedidos->fetch_assoc()): ?>
        <tr>
            <td>#<?= $p['id'] ?></td>
            <td><?= $p['nome'] ?></td>
            <td><?= $p['data'] ?></td>

            <td>
                <?= $p['pagamento'] 
                    ? strtoupper($p['pagamento']) 
                    : 'N/A' ?>
            </td>

            <td>
                <?= $p['status_pagamento'] 
                    ? strtoupper($p['status_pagamento']) 
                    : 'PENDENTE' ?>
            </td>

            <td>
                <a href="admin_pedido_detalhe.php?id=<?= $p['id'] ?>">
                    Ver Detalhes
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

<?php include 'partials/footer.php'; ?>