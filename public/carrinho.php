<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// 🔹 Carrinho (sessão)
$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
?>

<div class="card">

    <!-- 🔥 TOPO COM LOGO -->
    <div style="display:flex; align-items:center; gap:10px;">
        <h1 style="margin:0;">🛒 Carrinho</h1>
    </div>

    <hr>

    <?php if (empty($carrinho)): ?>

        <p>Seu carrinho está vazio.</p>

        <a href="loja.php">
            <button class="product-button">Ir para Loja</button>
        </a>

    <?php else: ?>

        <table style="width:100%; border-collapse:collapse;">

            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:10px;">Produto</th>
                    <th style="padding:10px;">Preço</th>
                    <th style="padding:10px;">Qtd</th>
                    <th style="padding:10px;">Subtotal</th>
                    <th style="padding:10px;">Ações</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($carrinho as $id => $qtd): 

                $produto = $conn->query("SELECT * FROM produtos WHERE id = $id")->fetch_assoc();

                if (!$produto) continue;

                $subtotal = $produto['valor'] * $qtd;
                $total += $subtotal;
            ?>

                <tr style="border-bottom:1px solid #eee;">

                    <!-- PRODUTO -->
                    <td style="padding:10px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            
                            <?php if ($produto['imagem']): ?>
                                <img src="uploads/<?= $produto['imagem'] ?>" 
                                     style="width:50px; height:50px; object-fit:contain;">
                            <?php endif; ?>

                            <?= $produto['nome'] ?>
                        </div>
                    </td>

                    <!-- PREÇO -->
                    <td style="padding:10px;">
                        R$ <?= number_format($produto['valor'], 2, ',', '.') ?>
                    </td>

                    <!-- QTD -->
                    <td style="padding:10px;">
                        <?= $qtd ?>
                    </td>

                    <!-- SUBTOTAL -->
                    <td style="padding:10px;">
                        R$ <?= number_format($subtotal, 2, ',', '.') ?>
                    </td>

                    <!-- AÇÕES -->
                    <td style="padding:10px;">

                        <a href="carrinho_remove.php?id=<?= $id ?>">
                            <button style="background:#e74c3c;">
                                ❌ Remover
                            </button>
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

        <hr>

        <!-- 🔥 TOTAL -->
        <h2>Total: R$ <?= number_format($total, 2, ',', '.') ?></h2>

        <br>

        <!-- 🔥 AÇÕES -->
        <div style="display:flex; gap:10px;">

            <a href="loja.php">
                <button>⬅ Continuar Comprando</button>
            </a>

            <a href="checkout.php">
                <button style="background:green;">
                    💳 Finalizar Compra
                </button>
            </a>

        </div>

    <?php endif; ?>

</div>

<?php include 'partials/footer.php'; ?>