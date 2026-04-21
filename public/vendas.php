<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// 🔹 Buscar vendas do cliente
$vendas = $conn->query("
    SELECT * FROM vendas 
    WHERE cliente_id = $cliente_id
    ORDER BY id DESC
");
?>

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center;">

        <h1>📦 Minhas Compras</h1>

        <a href="loja.php">
            <button class="product-button">
                ➕ Nova Compra
            </button>
        </a>

    </div>

    <hr>

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px;">ID</th>
                <th style="padding:10px;">Data</th>
                <th style="padding:10px;">Status</th>
                <th style="padding:10px;">Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php while($v = $vendas->fetch_assoc()): ?>

            <tr style="border-bottom:1px solid #eee;">

                <td style="padding:10px;"><?= $v['id'] ?></td>

                <td style="padding:10px;">
                    <?= date('d/m/Y H:i', strtotime($v['data'])) ?>
                </td>

                <!-- 🔥 STATUS COM COR -->
                <td style="padding:10px;">
                    <?php if ($v['status'] == 'finalizada'): ?>
                        <span style="color:green; font-weight:bold;">
                            ✔ Finalizada
                        </span>
                    <?php elseif ($v['status'] == 'aberta'): ?>
                        <span style="color:orange; font-weight:bold;">
                            ⏳ Aberta
                        </span>
                    <?php else: ?>
                        <?= ucfirst($v['status']) ?>
                    <?php endif; ?>
                </td>

                <td style="padding:10px;">

                    <a href="venda_itens.php?venda_id=<?= $v['id'] ?>">
                        <button style="background:#3498db;">
                            🔍 Ver
                        </button>
                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

<?php include 'partials/footer.php'; ?>