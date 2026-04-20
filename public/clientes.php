<?php
require_once '../config/database.php';

$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
</head>
<body>

<h1>Lista de Clientes</h1>

<a href="cliente_create.php">Cadastrar Cliente</a>

<hr>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Cidade</th>
        <th>Telefone</th>
        <th>Ações</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td><?= $row['cpf'] ?></td>
        <td><?= $row['cidade'] ?></td>
        <td><?= $row['telefone1'] ?></td>
        <td>
            <a href="cliente_edit.php?id=<?= $row['id'] ?>">Editar</a> |
            <a href="cliente_delete.php?id=<?= $row['id'] ?>">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="index.php">Voltar</a>

</body>
</html>