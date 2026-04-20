<?php
require_once '../config/database.php';
include 'partials/header.php';
?>

<div class="card" style="text-align:center;">
    <h1>💳 Processando Cartão...</h1>

    <p>Simulando pagamento...</p>

    <br>

    <a href="checkout_process.php?tipo=cartao">
        <button style="background:green;">Confirmar Pagamento</button>
    </a>

    <br><br>

    <a href="pagamento.php">Cancelar</a>
</div>

<?php include 'partials/footer.php'; ?>