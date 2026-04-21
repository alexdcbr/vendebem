<?php
require_once '../config/database.php';
session_start();

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $user = $conn->query("
        SELECT * FROM clientes WHERE cpf = '$cpf'
    ")->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {

        $_SESSION['cliente_id'] = $user['id'];
        $_SESSION['cliente_nome'] = $user['nome'];
        $_SESSION['cliente_tipo'] = $user['tipo'];

        header("Location: home.php");
        exit;

    } else {
        $erro = "CPF ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-card input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .login-card button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .login-card button:hover {
            background: #2980b9;
        }

        .login-card a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .erro {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>

</head>
<body>

<div class="login-card">

    <h2><i class="fa-solid fa-right-to-bracket"></i> Login</h2>

    <?php if ($erro): ?>
        <div class="erro"><?= $erro ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="cpf" placeholder="CPF" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit">Entrar</button>

    </form>

    <a href="register.php">Criar Conta</a>

</div>

</body>
</html>