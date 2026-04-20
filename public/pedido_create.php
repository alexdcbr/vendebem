<?php
require_once '../config/database.php';

// Buscar fornecedores
$fornecedores = $conn->query("SELECT * FROM fornecedores");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fornecedor_id = $_POST['fornecedor_id'];
    $data = date('Y-m-d H:i:s');

    $sql = "INSERT INTO pedidos (fornecedor_id, data)
            VALUES ($fornecedor_id, '$data')";

    $conn->query($sql);

    $pedido_id = $conn->insert_id;

    header("Location: pedido_itens.php?pedido_id=$pedido_id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Novo Pedido</title>
</head>
<body>

<h1>Novo Pedido</h1>

<form method="POST">

    Fornecedor:<br>
    <select name="fornecedor_id">
        <?php while($f = $fornecedores->fetch_assoc()): ?>
            <option value="<?= $f['id'] ?>">
                <?= $f['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <button type="submit">Criar Pedido</button>

</form>

<br>
<a href="pedidos.php">Voltar</a>

</body>
</html>