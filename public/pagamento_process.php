<?php
session_start();

$pagamento = $_POST['pagamento'];

if ($pagamento == 'pix') {
    header("Location: pagamento_pix.php");
    exit;
}

if ($pagamento == 'cartao') {

    // 🔒 Simulação básica
    if (empty($_POST['numero_cartao']) || empty($_POST['cvv'])) {
        header("Location: pagamento.php");
        exit;
    }

    header("Location: pagamento_cartao.php");
    exit;
}