<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção de acesso
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// 🔹 Buscar itens do carrinho
$itens = $conn->query("
    SELECT carrinho.*, produtos.nome, produtos.valor, produtos.estoque
    FROM carrinho
    JOIN produtos ON carrinho.produto_id = produtos.id
    WHERE cliente_id = $cliente_id
");

// 🔒 Bloqueia carrinho vazio
if ($itens->num_rows == 0) {
    header("Location: carrinho.php");
    exit;
}

$total = 0;
?>

<div class="card">
    <h1>💳 Checkout</h1>

    <h3>Resumo do Pedido</h3>

    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Subtotal</th>
        </tr>

        <?php while($item = $itens->fetch_assoc()): 
        
            // 🔒 Validação de estoque
            if ($item['estoque'] < $item['quantidade']) {
                echo "<p style='color:red;'>Produto {$item['nome']} sem estoque suficiente</p>";
                echo "<a href='carrinho.php'>Voltar ao carrinho</a>";
                include 'partials/footer.php';
                exit;
            }

            $subtotal = $item['quantidade'] * $item['valor'];
            $total += $subtotal;
        ?>

        <tr>
            <td><?= $item['nome'] ?></td>
            <td><?= $item['quantidade'] ?></td>
            <td>R$ <?= number_format($item['valor'], 2, ',', '.') ?></td>
            <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
        </tr>

        <?php endwhile; ?>

    </table>

    <h2>Total: R$ <?= number_format($total, 2, ',', '.') ?></h2>

    <br>

    <!-- 🔥 REDIRECIONA PARA PAGAMENTO -->
    <a href="pagamento.php">
        <button style="background:green;">
            Ir para Pagamento
        </button>
    </a>

    <br><br>

    <a href="carrinho.php">⬅ Voltar ao Carrinho</a>
</div>

<?php include 'partials/footer.php'; ?>