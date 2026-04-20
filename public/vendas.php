<?php
require_once '../config/database.php';
include 'partials/header.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT vendas.*, clientes.nome AS cliente_nome
        FROM vendas
        LEFT JOIN clientes ON vendas.cliente_id = clientes.id
        WHERE vendas.cliente_id = " . $_SESSION['cliente_id'];

$result = $conn->query($sql);
?>

<div class="card">
    <h1>Minhas Compras</h1>

    <a href="venda_create.php">
        <button>Nova Compra</button>
    </a>

    <table>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['data'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="venda_itens.php?venda_id=<?= $row['id'] ?>">
                    Ver
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include 'partials/footer.php'; ?>