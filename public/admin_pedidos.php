<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Apenas admin
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

    <hr>

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px;">ID</th>
                <th style="padding:10px;">Cliente</th>
                <th style="padding:10px;">Data</th>
                <th style="padding:10px;">Pagamento</th>
                <th style="padding:10px;">Status</th>
                <th style="padding:10px;">Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php while($p = $pedidos->fetch_assoc()): ?>

            <tr style="border-bottom:1px solid #eee;">

                <td style="padding:10px;">#<?= $p['id'] ?></td>

                <td style="padding:10px;">
                    <?= $p['nome'] ?>
                </td>

                <td style="padding:10px;">
                    <?= date('d/m/Y H:i', strtotime($p['data'])) ?>
                </td>

                <!-- 💳 PAGAMENTO -->
                <td style="padding:10px;">
                    <?php if ($p['pagamento'] == 'PIX'): ?>
                        <span style="color:#27ae60; font-weight:bold;">PIX</span>
                    <?php elseif ($p['pagamento'] == 'CARTAO'): ?>
                        <span style="color:#2980b9; font-weight:bold;">Cartão</span>
                    <?php else: ?>
                        <span style="color:#7f8c8d;">N/A</span>
                    <?php endif; ?>
                </td>

                <!-- 🔥 STATUS -->
                <td style="padding:10px;">
                    <?php if ($p['status'] == 'APROVADO'): ?>
                        <span style="color:green; font-weight:bold;">
                            ✔ Aprovado
                        </span>
                    <?php elseif ($p['status'] == 'PENDENTE'): ?>
                        <span style="color:orange; font-weight:bold;">
                            ⏳ Pendente
                        </span>
                    <?php else: ?>
                        <?= ucfirst(strtolower($p['status'])) ?>
                    <?php endif; ?>
                </td>

                <!-- 🔧 AÇÕES -->
                <td style="padding:10px;">

                    <a href="admin_pedido_detalhe.php?id=<?= $p['id'] ?>">
                        <button style="background:#3498db;">
                            🔍 Ver Detalhes
                        </button>
                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

<?php include 'partials/footer.php'; ?>