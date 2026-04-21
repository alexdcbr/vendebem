<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Admin
if ($_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];

    $conn->query("INSERT INTO categorias (nome) VALUES ('$nome')");

    header("Location: categorias.php");
    exit;
}
?>

<div class="card" style="max-width:500px; margin:auto;">

    <h1>➕ Nova Categoria</h1>

    <form method="POST">

        <label>Nome</label><br>
        <input type="text" name="nome" required style="width:100%; padding:8px;"><br><br>

        <button class="product-button">💾 Salvar</button>

    </form>

    <br>

    <a href="categorias.php">⬅ Voltar</a>

</div>

<?php include 'partials/footer.php'; ?>