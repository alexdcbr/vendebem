<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Apenas admin
if (!isset($_SESSION['cliente_id']) || $_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

// 🔹 Buscar categorias
$categorias = $conn->query("SELECT * FROM categorias ORDER BY id DESC");
?>

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h1>📂 Categorias</h1>

        <a href="categoria_create.php">
            <button class="product-button">➕ Nova Categoria</button>
        </a>
    </div>

    <hr>

    <table style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px;">ID</th>
                <th style="padding:10px;">Nome</th>
                <th style="padding:10px;">Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php while($c = $categorias->fetch_assoc()): ?>

            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:10px;"><?= $c['id'] ?></td>
                <td style="padding:10px;"><?= $c['nome'] ?></td>

                <td style="padding:10px;">

                    <a href="categoria_edit.php?id=<?= $c['id'] ?>">
                        <button style="background:#3498db;">Editar</button>
                    </a>

                    <a href="categoria_delete.php?id=<?= $c['id'] ?>" 
                       onclick="return confirm('Deseja excluir esta categoria?')">
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