<?php
require_once '../config/database.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];
    $telefone1 = $_POST['telefone1'];
    $telefone2 = $_POST['telefone2'];
    $email = $_POST['email'];

    // 🔐 Tratamento da senha
    if (!empty($_POST['senha'])) {
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "UPDATE clientes SET 
            cpf='$cpf',
            nome='$nome',
            endereco='$endereco',
            bairro='$bairro',
            cidade='$cidade',
            uf='$uf',
            cep='$cep',
            telefone1='$telefone1',
            telefone2='$telefone2',
            email='$email',
            senha='$senha'
            WHERE id=$id";
    } else {

        // Mantém senha atual
        $sql = "UPDATE clientes SET 
            cpf='$cpf',
            nome='$nome',
            endereco='$endereco',
            bairro='$bairro',
            cidade='$cidade',
            uf='$uf',
            cep='$cep',
            telefone1='$telefone1',
            telefone2='$telefone2',
            email='$email'
            WHERE id=$id";
    }

    $conn->query($sql);

    header("Location: clientes.php");
}

$sql = "SELECT * FROM clientes WHERE id=$id";
$result = $conn->query($sql);
$cliente = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
</head>
<body>

<h1>Editar Cliente</h1>

<form method="POST">

    CPF:<br>
    <input type="text" name="cpf" value="<?= $cliente['cpf'] ?>"><br><br>

    Nome:<br>
    <input type="text" name="nome" value="<?= $cliente['nome'] ?>"><br><br>

    Endereço:<br>
    <input type="text" name="endereco" value="<?= $cliente['endereco'] ?>"><br><br>

    Bairro:<br>
    <input type="text" name="bairro" value="<?= $cliente['bairro'] ?>"><br><br>

    Cidade:<br>
    <input type="text" name="cidade" value="<?= $cliente['cidade'] ?>"><br><br>

    UF:<br>
    <input type="text" name="uf" value="<?= $cliente['uf'] ?>"><br><br>

    CEP:<br>
    <input type="text" name="cep" value="<?= $cliente['cep'] ?>"><br><br>

    Telefone 1:<br>
    <input type="text" name="telefone1" value="<?= $cliente['telefone1'] ?>"><br><br>

    Telefone 2:<br>
    <input type="text" name="telefone2" value="<?= $cliente['telefone2'] ?>"><br><br>

    Email:<br>
    <input type="email" name="email" value="<?= $cliente['email'] ?>"><br><br>

    <!-- 🔐 Campo de senha opcional -->
    Senha (deixe em branco para manter a atual):<br>
    <input type="password" name="senha"><br><br>

    <button type="submit">Atualizar</button>

</form>

<br>
<a href="clientes.php">Voltar</a>

</body>
</html>