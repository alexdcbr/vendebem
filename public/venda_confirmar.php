<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção de acesso
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php?erro=acesso_negado");
    exit;
}

$venda_id = $_GET['venda_id'] ?? 0;

// 🔒 Validar venda do cliente
$venda = $conn->query("
    SELECT * FROM vendas 
    WHERE id = $venda_id 
    AND cliente_id = " . $_SESSION['cliente_id']
)->fetch_assoc();

if (!$venda) {
    header("Location: vendas.php");
    exit;
}

// 🔒 Se já finalizada, não precisa confirmar
if ($venda['status'] == 'finalizada') {
    header("Location: venda_itens.php?venda_id=$venda_id");
    exit;
}

// 🔹 Buscar itens
$itens = $conn->query("
    SELECT itens_venda.*, produtos.nome 
    FROM itens_venda
    JOIN produtos ON itens_venda.produto_id = produtos.id
    WHERE venda_id = $venda_id
");

// 🔹 Calcular total
$total = 0;
?>

<div class="card">

    <h1>Confirmar Venda #<?= $venda_id ?></h1>

    <p>Cliente: <?= $_SESSION['cliente_nome'] ?></p>

    <hr>

    <h3>Resumo da Venda</h3>

    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Subtotal</th>
        </tr>

        <?php while($item = $itens->fetch_assoc()): 
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

    <a href="venda_finalizar.php?venda_id=<?= $venda_id ?>">
        <button>Confirmar Finalização</button>
    </a>

    <br><br>

    <a href="venda_itens.php?venda_id=<?= $venda_id ?>">
        Cancelar
    </a>

</div>

<?php include 'partials/footer.php'; ?>