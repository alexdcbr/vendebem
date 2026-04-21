<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção (somente admin)
if (!isset($_SESSION['cliente_id']) || $_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

// 🔹 Buscar produtos
$produtos = $conn->query("
    SELECT * FROM produtos ORDER BY id DESC
");
?>

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center;">

        <h1>📦 Produtos</h1>

        <a href="produto_create.php">
            <button class="product-button">
                ➕ Novo Produto
            </button>
        </a>

    </div>

    <hr>

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px; border-bottom:1px solid #ddd;">ID</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Imagem</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Nome</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Valor</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Estoque</th>
                <th style="padding:10px; border-bottom:1px solid #ddd;">Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php while($p = $produtos->fetch_assoc()): ?>

            <tr style="border-bottom:1px solid #eee;">

                <td style="padding:10px;"><?= $p['id'] ?></td>

                <!-- 🔹 IMAGEM -->
                <td style="padding:10px;">
                    <?php if ($p['imagem']): ?>
                        <img src="uploads/<?= $p['imagem'] ?>" 
                             style="width:50px; height:50px; object-fit:contain;">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

                <td style="padding:10px;"><?= $p['nome'] ?></td>

                <td style="padding:10px;">
                    R$ <?= number_format($p['valor'], 2, ',', '.') ?>
                </td>

                <td style="padding:10px;">
                    <?php if ($p['estoque'] <= 3): ?>
                        <span style="color:red; font-weight:bold;">
                            <?= $p['estoque'] ?> ⚠
                        </span>
                    <?php else: ?>
                        <?= $p['estoque'] ?>
                    <?php endif; ?>
                </td>

                <td style="padding:10px;">

                    <a href="produto_edit.php?id=<?= $p['id'] ?>">
                        <button style="background:#3498db;">Editar</button>
                    </a>

                    <a href="produto_delete.php?id=<?= $p['id'] ?>" 
                       onclick="return confirm('Deseja excluir este produto?')">
                        <button style="background:#e74c3c;">Excluir</button>
                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

    <br>

    <a href="home.php">⬅ Voltar</a>

</div>

<?php include 'partials/footer.php'; ?>