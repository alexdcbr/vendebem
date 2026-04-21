<?php
require_once '../config/database.php';
include 'partials/header.php';

if ($_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

$id = $_GET['id'];

$categoria = $conn->query("
    SELECT * FROM categorias WHERE id = $id
")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];

    $conn->query("
        UPDATE categorias SET nome='$nome' WHERE id=$id
    ");

    header("Location: categorias.php");
    exit;
}
?>

<div class="card" style="max-width:500px; margin:auto;">

    <h1>✏️ Editar Categoria</h1>

    <form method="POST">

        <label>Nome</label><br>
        <input type="text" name="nome" 
               value="<?= $categoria['nome'] ?>" 
               required style="width:100%; padding:8px;"><br><br>

        <button class="product-button">💾 Atualizar</button>

    </form>

    <br>

    <a href="categorias.php">⬅ Voltar</a>

</div>

<?php include 'partials/footer.php'; ?>