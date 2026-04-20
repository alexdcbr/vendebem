<?php
require_once '../config/database.php';
session_start();

$erro = "";

// 🔹 Mensagem de acesso negado
if (isset($_GET['erro']) && $_GET['erro'] == 'acesso_negado') {
    $erro = "Acesso negado. Faça login.";
}

// 🔹 Processa login
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // 🔹 Busca cliente
    $sql = "SELECT * FROM clientes WHERE cpf='$cpf'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $cliente = $result->fetch_assoc();

        // 🔹 Primeiro acesso (sem senha definida)
        if (empty($cliente['senha'])) {
            header("Location: definir_senha.php?cpf=$cpf");
            exit;
        }

        // 🔐 Verifica senha
        if (password_verify($senha, $cliente['senha'])) {

            // 🔥 SESSÃO COMPLETA
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nome'] = $cliente['nome'];
            $_SESSION['cliente_tipo'] = $cliente['tipo'];

            // 🔥 ONBOARDING (cadastro incompleto)
            if ($cliente['cadastro_completo'] == 0) {
                header("Location: cliente_completar.php");
            } else {
                header("Location: home.php");
            }
            exit;

        } else {
            $erro = "Senha inválida.";
        }

    } else {
        $erro = "Cliente não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <div class="card" style="max-width:400px; margin:auto; margin-top:80px;">
        <h2>Login</h2>

        <?php if ($erro): ?>
            <p style="color:red;"><?= $erro ?></p>
        <?php endif; ?>

        <form method="POST">

            CPF:<br>
            <input type="text" name="cpf" required><br><br>

            Senha:<br>
            <input type="password" name="senha" required><br><br>

            <button type="submit">Entrar</button>

        </form>

        <hr>

        <p>Não tem conta?</p>
        <a href="register.php">Criar Conta</a>

    </div>

</div>

</body>
</html>