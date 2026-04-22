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
    <title>Login - VendeBem</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            width: 420px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            height: 200px;
        }

        .login-card h2 {
            margin-bottom: 25px;
        }

        /* 🔥 FORM CENTRAL */
        .form-box {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }

        /* 🔥 CORREÇÃO PRINCIPAL */
        .form-box input,
        .form-box button {
            width: 100%;
            box-sizing: border-box;
        }

        /* INPUTS */
        .form-box input {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-box input:focus {
            outline: none;
            border-color: #3498db;
        }

        /* BOTÃO */
        .form-box button {
            padding: 12px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        .form-box button:hover {
            background: #2980b9;
        }

        .login-card a {
            display: block;
            margin-top: 15px;
            color: #3498db;
            text-decoration: none;
        }

        .login-card a:hover {
            text-decoration: underline;
        }

        .erro {
            color: red;
            margin-bottom: 15px;
        }
    </style>

</head>
<body>

<div class="login-card">

    <!-- 🔥 LOGO -->
    <div class="logo">
        <img src="images/logo-light.png">
    </div>

    <h2>Login</h2>

    <?php if ($erro): ?>
        <div class="erro"><?= $erro ?></div>
    <?php endif; ?>

    <!-- 🔥 FORM PERFEITAMENTE ALINHADO -->
    <form method="POST" class="form-box">

        <input type="text" name="cpf" placeholder="CPF" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit">Entrar</button>

    </form>

    <a href="register.php">Criar Conta</a>

</div>

</body>
</html>