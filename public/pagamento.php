<?php
require_once '../config/database.php';
include 'partials/header.php';
?>

<div class="card">
    <h1>💳 Pagamento</h1>

    <h3>Escolha a forma de pagamento</h3>

    <form method="POST" action="pagamento_process.php">

        <input type="radio" name="pagamento" value="pix" required onclick="mostrarOpcao()"> PIX<br><br>
        <input type="radio" name="pagamento" value="cartao" onclick="mostrarOpcao()"> Cartão de Crédito<br><br>

        <!-- 🔹 PIX -->
        <div id="pixBox" style="display:none;">
            <p>Pagamento via PIX</p>
        </div>

        <!-- 🔹 CARTÃO -->
        <div id="cartaoBox" style="display:none;">
            Número do Cartão:<br>
            <input type="text" name="numero_cartao"><br><br>

            Nome no Cartão:<br>
            <input type="text" name="nome_cartao"><br><br>

            Validade:<br>
            <input type="text" name="validade" placeholder="MM/AA"><br><br>

            CVV:<br>
            <input type="text" name="cvv"><br><br>
        </div>

        <button type="submit">Continuar</button>
    </form>

    <br>

    <a href="checkout.php">⬅ Voltar</a>
</div>

<script>
function mostrarOpcao() {
    const tipo = document.querySelector('input[name="pagamento"]:checked').value;

    document.getElementById('pixBox').style.display = (tipo === 'pix') ? 'block' : 'none';
    document.getElementById('cartaoBox').style.display = (tipo === 'cartao') ? 'block' : 'none';
}
</script>

<?php include 'partials/footer.php'; ?>