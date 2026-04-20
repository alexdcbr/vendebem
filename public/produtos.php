<?php
require_once '../config/database.php';

$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produtos</title>
</head>
<body>

<h1>Lista de Produtos</h1>

<a href="produto_create.php">Cadastrar Produto</a>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Valor</th>
        <th>Estoque</th>
        <th>Ações</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td>R$ <?= $row['valor'] ?></td>
        <td><?= $row['estoque'] ?></td>
        <td>
            <a href="produto_edit.php?id=<?= $row['id'] ?>">Editar</a> |
            <a href="produto_delete.php?id=<?= $row['id'] ?>">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="index.php">Voltar</a>

</body>
</html>