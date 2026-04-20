<?php
require_once '../config/database.php';
include 'partials/header.php';
?>

<div class="card" style="text-align:center;">
    <h1>💸 Pagamento via PIX</h1>

    <p>Escaneie o QR Code abaixo:</p>

    <!-- 🔥 QR CODE SIMULADO -->
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PagamentoPIX123">

    <p>Chave PIX: pix@loja.com</p>

    <br>

    <a href="checkout_process.php?tipo=pix">
        <button style="background:green;">Já paguei</button>
    </a>

    <br><br>

    <a href="pagamento.php">Cancelar</a>
</div>

<?php include 'partials/footer.php'; ?>