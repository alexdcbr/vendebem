<?php
require_once '../config/database.php';

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

    $sql = "INSERT INTO fornecedores 
    (cnpj, nome, endereco, bairro, cidade, uf, cep, telefone1, telefone2, email)
    VALUES 
    ('$cnpj', '$nome', '$endereco', '$bairro', '$cidade', '$uf', '$cep', '$telefone1', '$telefone2', '$email')";

    $conn->query($sql);

    header("Location: fornecedores.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Fornecedor</title>
</head>
<body>

<h1>Cadastrar Fornecedor</h1>

<form method="POST">

    CNPJ:<br>
    <input type="text" name="cnpj"><br><br>

    Nome:<br>
    <input type="text" name="nome"><br><br>

    Endereço:<br>
    <input type="text" name="endereco"><br><br>

    Bairro:<br>
    <input type="text" name="bairro"><br><br>

    Cidade:<br>
    <input type="text" name="cidade"><br><br>

    UF:<br>
    <input type="text" name="uf"><br><br>

    CEP:<br>
    <input type="text" name="cep"><br><br>

    Telefone 1:<br>
    <input type="text" name="telefone1"><br><br>

    Telefone 2:<br>
    <input type="text" name="telefone2"><br><br>

    Email:<br>
    <input type="email" name="email"><br><br>

    <button type="submit">Salvar</button>

</form>

<br>
<a href="fornecedores.php">Voltar</a>

</body>
</html>