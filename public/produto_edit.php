<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Apenas admin
if (!isset($_SESSION['cliente_id']) || $_SESSION['cliente_tipo'] != 'admin') {
    header("Location: home.php");
    exit;
}

$id = $_GET['id'] ?? 0;

// 🔹 Produto atual
$produto = $conn->query("
    SELECT * FROM produtos WHERE id = $id
")->fetch_assoc();

if (!$produto) {
    echo "<p>Produto não encontrado</p>";
    exit;
}

// 🔹 Categorias
$categorias = $conn->query("SELECT * FROM categorias");

// 🔹 Atualizar produto
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $estoque = $_POST['estoque'];
    $categoria_id = $_POST['categoria_id'];

    $imagem = $produto['imagem'];

    // 🔹 Upload nova imagem
    if (!empty($_FILES['imagem']['name'])) {

        $nomeArquivo = time() . "_" . $_FILES['imagem']['name'];
        $caminho = "uploads/" . $nomeArquivo;

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);

        $imagem = $nomeArquivo;
    }

    $conn->query("
        UPDATE produtos SET
        nome = '$nome',
        valor = '$valor',
        estoque = '$estoque',
        imagem = '$imagem',
        categoria_id = '$categoria_id'
        WHERE id = $id
    ");

    header("Location: produtos.php");
    exit;
}
?>

<div class="card" style="max-width:600px; margin:auto;">

    <h1>✏️ Editar Produto</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Nome</label><br>
        <input type="text" name="nome" value="<?= $produto['nome'] ?>" 
               required style="width:100%; padding:8px;"><br><br>

        <label>Valor</label><br>
        <input type="number" step="0.01" name="valor" 
               value="<?= $produto['valor'] ?>" 
               required style="width:100%; padding:8px;"><br><br>

        <label>Estoque</label><br>
        <input type="number" name="estoque" 
               value="<?= $produto['estoque'] ?>" 
               required style="width:100%; padding:8px;"><br><br>

        <!-- 🔥 CATEGORIA -->
        <label>Categoria</label><br>
        <select name="categoria_id" required style="width:100%; padding:8px;">
            <option value="">Selecione</option>
            <?php while($c = $categorias->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>"
                    <?= ($produto['categoria_id'] == $c['id']) ? 'selected' : '' ?>>
                    <?= $c['nome'] ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <!-- 🔹 IMAGEM ATUAL -->
        <label>Imagem Atual</label><br>
        <?php if ($produto['imagem']): ?>
            <img src="uploads/<?= $produto['imagem'] ?>" 
                 style="width:120px; height:120px; object-fit:contain;"><br><br>
        <?php else: ?>
            <p>Sem imagem</p>
        <?php endif; ?>

        <!-- 🔹 NOVA IMAGEM -->
        <label>Nova Imagem</label><br>
        <input type="file" name="imagem"><br><br>

        <button type="submit" class="product-button">
            💾 Atualizar Produto
        </button>

    </form>

    <br>

    <a href="produtos.php">⬅ Voltar</a>

</div>

<?php include 'partials/footer.php'; ?>