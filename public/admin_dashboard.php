<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção
if (!isset($_SESSION['cliente_id']) || $_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

// 🔹 Filtro de período
$dias = $_GET['dias'] ?? 7;

// 🔹 KPIs
$totalPedidos = $conn->query("
    SELECT COUNT(*) as total 
    FROM vendas 
    WHERE data >= CURDATE() - INTERVAL $dias DAY
")->fetch_assoc()['total'];

$faturamento = $conn->query("
    SELECT SUM(itens_venda.quantidade * itens_venda.valor) as total
    FROM vendas
    JOIN itens_venda ON vendas.id = itens_venda.venda_id
    WHERE vendas.data >= CURDATE() - INTERVAL $dias DAY
")->fetch_assoc()['total'] ?? 0;

$ticketMedio = $totalPedidos > 0 ? $faturamento / $totalPedidos : 0;

// 🔹 GRÁFICO PEDIDOS
$grafico = $conn->query("
    SELECT DATE(data) as dia, COUNT(*) as total
    FROM vendas
    WHERE data >= CURDATE() - INTERVAL $dias DAY
    GROUP BY DATE(data)
");

$labels = [];
$pedidosData = [];

while ($row = $grafico->fetch_assoc()) {
    $labels[] = $row['dia'];
    $pedidosData[] = $row['total'];
}

// 🔹 GRÁFICO FATURAMENTO
$faturamentoGrafico = $conn->query("
    SELECT DATE(vendas.data) as dia,
           SUM(itens_venda.quantidade * itens_venda.valor) as total
    FROM vendas
    JOIN itens_venda ON vendas.id = itens_venda.venda_id
    WHERE vendas.data >= CURDATE() - INTERVAL $dias DAY
    GROUP BY DATE(vendas.data)
");

$faturamentoData = [];

while ($row = $faturamentoGrafico->fetch_assoc()) {
    $faturamentoData[] = (float)$row['total'];
}

// 🔥 TOP PRODUTOS
$topProdutos = $conn->query("
    SELECT produtos.nome, SUM(itens_venda.quantidade) as total
    FROM itens_venda
    JOIN produtos ON itens_venda.produto_id = produtos.id
    JOIN vendas ON vendas.id = itens_venda.venda_id
    WHERE vendas.data >= CURDATE() - INTERVAL $dias DAY
    GROUP BY produtos.nome
    ORDER BY total DESC
    LIMIT 5
");
?>

<div class="card">
    <h1>📊 Dashboard BI</h1>

    <!-- 🔥 FILTRO -->
    <form method="GET">
        Período:
        <select name="dias" onchange="this.form.submit()">
            <option value="7" <?= $dias==7?'selected':'' ?>>7 dias</option>
            <option value="30" <?= $dias==30?'selected':'' ?>>30 dias</option>
        </select>
    </form>

    <hr>

    <!-- KPIs -->
    <div style="display:flex; gap:20px; flex-wrap:wrap;">

        <div class="card" style="flex:1;">
            <h4>Pedidos</h4>
            <h2><?= $totalPedidos ?></h2>
        </div>

        <div class="card" style="flex:1;">
            <h4>Faturamento</h4>
            <h2>R$ <?= number_format($faturamento,2,',','.') ?></h2>
        </div>

        <div class="card" style="flex:1;">
            <h4>Ticket Médio</h4>
            <h2>R$ <?= number_format($ticketMedio,2,',','.') ?></h2>
        </div>

    </div>

    <hr>

    <!-- GRÁFICOS -->
    <h3>Pedidos</h3>
    <canvas id="graficoPedidos"></canvas>

    <h3>Faturamento</h3>
    <canvas id="graficoFaturamento"></canvas>

    <hr>

    <!-- 🔥 TOP PRODUTOS -->
    <h3>Top Produtos</h3>

    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade Vendida</th>
        </tr>

        <?php while($p = $topProdutos->fetch_assoc()): ?>
        <tr>
            <td><?= $p['nome'] ?></td>
            <td><?= $p['total'] ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// PEDIDOS
new Chart(document.getElementById('graficoPedidos'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Pedidos',
            data: <?= json_encode($pedidosData) ?>,
            tension: 0.3
        }]
    }
});

// FATURAMENTO
new Chart(document.getElementById('graficoFaturamento'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Faturamento',
            data: <?= json_encode($faturamentoData) ?>
        }]
    }
});
</script>