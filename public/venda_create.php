<?php
require_once '../config/database.php';
include 'partials/header.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cliente_id = $_SESSION['cliente_id'];
    $data = date('Y-m-d H:i:s');

    $conn->query("
        INSERT INTO vendas (cliente_id, data, status)
        VALUES ($cliente_id, '$data', 'aberta')
    ");

    $venda_id = $conn->insert_id;

    header("Location: venda_itens.php?venda_id=$venda_id");
}
?>

<div class="card">
    <h1>Nova Compra</h1>

    <p>Cliente: <?= $_SESSION['cliente_nome'] ?></p>

    <form method="POST">
        <button type="submit">Criar Venda</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>