<?php
require_once '../config/database.php';
include 'partials/header.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// 🔹 Filtro
$categoria_id = $_GET['categoria'] ?? null;

// 🔹 Categorias
$categorias = $conn->query("SELECT * FROM categorias");

// 🔹 Produtos
if ($categoria_id) {
    $produtos = $conn->query("
        SELECT * FROM produtos 
        WHERE categoria_id = $categoria_id
    ");
} else {
    $produtos = $conn->query("SELECT * FROM produtos");
}
?>

<div class="card">

    <h1>🛒 Loja</h1>

    <!-- 🔥 FILTRO -->
    <div style="margin-bottom:20px;">
        <b>Categorias:</b>

        <a href="loja.php">Todas</a>

        <?php while($c = $categorias->fetch_assoc()): ?>
            | <a href="loja.php?categoria=<?= $c['id'] ?>">
                <?= $c['nome'] ?>
              </a>
        <?php endwhile; ?>
    </div>

    <!-- 🔥 PRODUTOS -->
    <div style="display:flex; gap:20px; flex-wrap:wrap;">

        <?php while($p = $produtos->fetch_assoc()): ?>

            <a href="produto.php?id=<?= $p['id'] ?>" style="text-decoration:none; color:inherit;">

                <div class="card" style="width:220px; text-align:center;">

                    <div style="height:150px; display:flex; align-items:center; justify-content:center;">
                        <?php if ($p['imagem']): ?>
                            <img src="uploads/<?= $p['imagem'] ?>" style="max-width:100%; max-height:100%;">
                        <?php endif; ?>
                    </div>

                    <b><?= $p['nome'] ?></b>

                    <p>R$ <?= number_format($p['valor'], 2, ',', '.') ?></p>

                </div>

            </a>

        <?php endwhile; ?>

    </div>

</div>

<?php include 'partials/footer.php'; ?>