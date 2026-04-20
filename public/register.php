<?php
require_once '../config/database.php';

$erro = "";
$sucesso = "";

// 🔹 Processa cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // 🔒 Validação básica
    if (empty($nome) || empty($cpf) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {

        // 🔹 Verifica se CPF já existe
        $check = $conn->query("SELECT id FROM clientes WHERE cpf = '$cpf'");

        if ($check->num_rows > 0) {
            $erro = "CPF já cadastrado.";
        } else {

            // 🔐 Criptografa senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // 🔥 Inserção com cadastro incompleto
            $conn->query("
                INSERT INTO clientes (nome, cpf, senha, tipo, cadastro_completo)
                VALUES ('$nome', '$cpf', '$senhaHash', 'cliente', 0)
            ");

            $sucesso = "Cadastro realizado com sucesso! Faça login.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <div class="card" style="max-width:400px; margin:auto; margin-top:80px;">
        <h2>Cadastro</h2>

        <?php if ($erro): ?>
            <p style="color:red;"><?= $erro ?></p>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <p style="color:green;"><?= $sucesso ?></p>
        <?php endif; ?>

        <form method="POST">

            Nome:<br>
            <input type="text" name="nome" required><br><br>

            CPF:<br>
            <input type="text" name="cpf" required><br><br>

            Senha:<br>
            <input type="password" name="senha" required><br><br>

            <button type="submit">Cadastrar</button>

        </form>

        <hr>

        <p>Já tem conta?</p>
        <a href="login.php">Fazer Login</a>

    </div>

</div>

</body>
</html>