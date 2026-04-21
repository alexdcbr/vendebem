<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Apenas admin
if (!isset($_SESSION['cliente_id']) || $_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

// 🔹 Buscar categorias
$categorias = $conn->query("SELECT * FROM categorias");

// 🔹 Salvar produto
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $estoque = $_POST['estoque'];
    $categoria_id = $_POST['categoria_id'];

    $imagem = '';

    // 🔹 Upload de imagem
    if (!empty($_FILES['imagem']['name'])) {

        $nomeArquivo = time() . "_" . $_FILES['imagem']['name'];
        $caminho = "uploads/" . $nomeArquivo;

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);

        $imagem = $nomeArquivo;
    }

    $conn->query("
        INSERT INTO produtos (nome, valor, estoque, imagem, categoria_id)
        VALUES ('$nome', '$valor', '$estoque', '$imagem', '$categoria_id')
    ");

    header("Location: produtos.php");
    exit;
}
?>

<div class="card" style="max-width:600px; margin:auto;">

    <h1>➕ Cadastrar Produto</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Nome</label><br>
        <input type="text" name="nome" required style="width:100%; padding:8px;"><br><br>

        <label>Valor</label><br>
        <input type="number" step="0.01" name="valor" required style="width:100%; padding:8px;"><br><br>

        <label>Estoque</label><br>
        <input type="number" name="estoque" required style="width:100%; padding:8px;"><br><br>

        <!-- 🔥 CATEGORIA -->
        <label>Categoria</label><br>
        <select name="categoria_id" required style="width:100%; padding:8px;">
            <option value="">Selecione</option>
            <?php while($c = $categorias->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>">
                    <?= $c['nome'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Imagem</label><br>
        <input type="file" name="imagem"><br><br>

        <button type="submit" class="product-button">
            💾 Salvar Produto
        </button>

    </form>

    <br>

    <a href="produtos.php">⬅ Voltar</a>

</div>

<?php include 'partials/footer.php'; ?>