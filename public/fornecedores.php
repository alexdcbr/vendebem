<?php
require_once '../config/database.php';

$sql = "SELECT * FROM fornecedores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fornecedores</title>
</head>
<body>

<h1>Lista de Fornecedores</h1>

<a href="fornecedor_create.php">Cadastrar Fornecedor</a>

<hr>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CNPJ</th>
        <th>Cidade</th>
        <th>Telefone</th>
        <th>Ações</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nome'] ?></td>
        <td><?= $row['cnpj'] ?></td>
        <td><?= $row['cidade'] ?></td>
        <td><?= $row['telefone1'] ?></td>
        <td>
            <a href="fornecedor_edit.php?id=<?= $row['id'] ?>">Editar</a> |
            <a href="fornecedor_delete.php?id=<?= $row['id'] ?>">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="index.php">Voltar</a>

</body>
</html>