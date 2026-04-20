<?php
require_once '../config/database.php';

$sql = "SELECT pedidos.*, fornecedores.nome AS fornecedor_nome
        FROM pedidos
        LEFT JOIN fornecedores ON pedidos.fornecedor_id = fornecedores.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pedidos</title>
</head>
<body>

<h1>Lista de Pedidos</h1>

<a href="pedido_create.php">Novo Pedido</a>

<hr>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Fornecedor</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['fornecedor_nome'] ?></td>
        <td><?= $row['data'] ?></td>
        <td>
            <a href="pedido_itens.php?pedido_id=<?= $row['id'] ?>">Itens</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="index.php">Voltar</a>

</body>
</html>