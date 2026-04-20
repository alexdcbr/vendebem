<?php
require_once '../config/database.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cnpj = $_POST['cnpj'];
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];
    $telefone1 = $_POST['telefone1'];
    $telefone2 = $_POST['telefone2'];
    $email = $_POST['email'];

    $sql = "UPDATE fornecedores SET 
        cnpj='$cnpj',
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

    $conn->query($sql);

    header("Location: fornecedores.php");
}

$sql = "SELECT * FROM fornecedores WHERE id=$id";
$result = $conn->query($sql);
$fornecedor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Fornecedor</title>
</head>
<body>

<h1>Editar Fornecedor</h1>

<form method="POST">

    CNPJ:<br>
    <input type="text" name="cnpj" value="<?= $fornecedor['cnpj'] ?>"><br><br>

    Nome:<br>
    <input type="text" name="nome" value="<?= $fornecedor['nome'] ?>"><br><br>

    Endereço:<br>
    <input type="text" name="endereco" value="<?= $fornecedor['endereco'] ?>"><br><br>

    Bairro:<br>
    <input type="text" name="bairro" value="<?= $fornecedor['bairro'] ?>"><br><br>

    Cidade:<br>
    <input type="text" name="cidade" value="<?= $fornecedor['cidade'] ?>"><br><br>

    UF:<br>
    <input type="text" name="uf" value="<?= $fornecedor['uf'] ?>"><br><br>

    CEP:<br>
    <input type="text" name="cep" value="<?= $fornecedor['cep'] ?>"><br><br>

    Telefone 1:<br>
    <input type="text" name="telefone1" value="<?= $fornecedor['telefone1'] ?>"><br><br>

    Telefone 2:<br>
    <input type="text" name="telefone2" value="<?= $fornecedor['telefone2'] ?>"><br><br>

    Email:<br>
    <input type="email" name="email" value="<?= $fornecedor['email'] ?>"><br><br>

    <button type="submit">Atualizar</button>

</form>

<br>
<a href="fornecedores.php">Voltar</a>

</body>
</html>