<?php
require_once '../config/database.php';

$cpf = $_GET['cpf'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "UPDATE clientes SET senha='$senha' WHERE cpf='$cpf'";
    $conn->query($sql);

    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Definir Senha</title>
</head>
<body>

<h1>Definir Senha</h1>

<form method="POST">

    <input type="hidden" name="cpf" value="<?= $cpf ?>">

    Nova Senha:<br>
    <input type="password" name="senha"><br><br>

    <button type="submit">Salvar Senha</button>

</form>

</body>
</html>