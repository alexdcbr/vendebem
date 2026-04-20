<?php
require_once '../config/database.php';
include 'partials/header.php';

$cliente_id = $_SESSION['cliente_id'];

$itens = $conn->query("
    SELECT carrinho.*, produtos.nome, produtos.valor 
    FROM carrinho
    JOIN produtos ON carrinho.produto_id = produtos.id
    WHERE cliente_id = $cliente_id
");

$total = 0;
?>

<div class="card">
    <h1>🧺 Meu Carrinho</h1>

    <?php if ($itens->num_rows == 0): ?>
        <p>Seu carrinho está vazio</p>
        <a href="loja.php">Ir para Loja</a>
    <?php else: ?>

    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Subtotal</th>
            <th>Ações</th>
        </tr>

        <?php while($item = $itens->fetch_assoc()): 
            $subtotal = $item['quantidade'] * $item['valor'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $item['nome'] ?></td>

            <td>
                <a href="carrinho_update.php?id=<?= $item['id'] ?>&acao=menos">➖</a>
                <?= $item['quantidade'] ?>
                <a href="carrinho_update.php?id=<?= $item['id'] ?>&acao=mais">➕</a>
            </td>

            <td>R$ <?= number_format($item['valor'], 2, ',', '.') ?></td>

            <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>

            <td>
                <a href="carrinho_remove.php?id=<?= $item['id'] ?>">❌ Remover</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

    <h2>Total: R$ <?= number_format($total, 2, ',', '.') ?></h2>

    <br>

    <a href="checkout.php">
        <button>Finalizar Compra</button>
    </a>

    <?php endif; ?>
</div>

<?php include 'partials/footer.php'; ?>