<?php
require_once '../config/database.php';

$pedido_id = $_GET['pedido_id'];

// Buscar produtos
$produtos = $conn->query("SELECT * FROM produtos");

// Inserir item
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];

    $produto = $conn->query("SELECT * FROM produtos WHERE id=$produto_id")->fetch_assoc();

    if ($produto) {

        $valor = $produto['valor'];

        // Insere item
        $conn->query("
            INSERT INTO itens_pedido 
            (pedido_id, produto_id, quantidade, valor)
            VALUES ($pedido_id, $produto_id, $quantidade, $valor)
        ");

        // 🔺 AUMENTA ESTOQUE
        $novoEstoque = $produto['estoque'] + $quantidade;

        $conn->query("
            UPDATE produtos 
            SET estoque = $novoEstoque 
            WHERE id = $produto_id
        ");
    }
}

// Listar itens
$sql = "SELECT itens_pedido.*, produtos.nome 
        FROM itens_pedido
        JOIN produtos ON itens_pedido.produto_id = produtos.id
        WHERE pedido_id = $pedido_id";

$itens = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Itens do Pedido</title>
</head>
<body>

<h1>Itens do Pedido #<?= $pedido_id ?></h1>

<form method="POST">

    Produto:<br>
    <select name="produto_id">
        <?php while($p = $produtos->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>">
                <?= $p['nome'] ?> (Estoque atual: <?= $p['estoque'] ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    Quantidade:<br>
    <input type="number" name="quantidade" min="1" required>

    <br><br>

    <button type="submit">Adicionar Item</button>

</form>

<hr>

<table border="1">
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Valor</th>
    </tr>

    <?php while($item = $itens->fetch_assoc()): ?>
    <tr>
        <td><?= $item['nome'] ?></td>
        <td><?= $item['quantidade'] ?></td>
        <td><?= $item['valor'] ?></td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="pedidos.php">Voltar</a>

</body>
</html>