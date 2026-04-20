<?php
require_once '../config/database.php';
include 'partials/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $estoque = $_POST['estoque'];

    $imagemNome = "";

    // 🔹 Upload da imagem
    if (!empty($_FILES['imagem']['name'])) {

        $imagemNome = time() . "_" . $_FILES['imagem']['name'];
        $caminho = "uploads/" . $imagemNome;

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
    }

    $conn->query("
        INSERT INTO produtos (nome, valor, estoque, imagem)
        VALUES ('$nome', '$valor', '$estoque', '$imagemNome')
    ");

    header("Location: produtos.php");
}
?>

<div class="card">
    <h1>Cadastrar Produto</h1>

    <form method="POST" enctype="multipart/form-data">

        Nome:<br>
        <input type="text" name="nome"><br><br>

        Valor:<br>
        <input type="text" name="valor"><br><br>

        Estoque:<br>
        <input type="number" name="estoque"><br><br>

        Imagem:<br>
        <input type="file" name="imagem"><br><br>

        <button type="submit">Salvar</button>

    </form>
</div>

<?php include 'partials/footer.php'; ?>