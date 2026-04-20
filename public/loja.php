<?php
require_once '../config/database.php';
include 'partials/header.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$produtos = $conn->query("SELECT * FROM produtos");
?>

<div class="card">
    <h1>Loja</h1>

    <div style="display:flex; gap:20px; flex-wrap:wrap;">

        <?php while($p = $produtos->fetch_assoc()): ?>

            <div class="card product-card">

                <!-- IMAGEM -->
                <div class="product-image">
                    <?php if ($p['imagem']): ?>
                        <img src="uploads/<?= $p['imagem'] ?>">
                    <?php else: ?>
                        <span>Sem imagem</span>
                    <?php endif; ?>
                </div>

                <!-- CONTEÚDO -->
                <div style="padding:10px; text-align:center;">

                    <div class="product-title">
                        <?= $p['nome'] ?>
                    </div>

                    <div class="product-price">
                        R$ <?= number_format($p['valor'], 2, ',', '.') ?>
                    </div>

                    <!-- ESTOQUE -->
                    <div>
                        <?php if ($p['estoque'] <= 3): ?>
                            <span class="low-stock">
                                ⚠ Últimas unidades!
                            </span>
                        <?php else: ?>
                            Estoque: <?= $p['estoque'] ?>
                        <?php endif; ?>
                    </div>

                    <a href="carrinho_add.php?id=<?= $p['id'] ?>">
                        <button class="product-button">
                            🛒 Adicionar
                        </button>
                    </a>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

    <br>

    <a href="carrinho.php">🧺 Ver Carrinho</a>
</div>

<?php include 'partials/footer.php'; ?>