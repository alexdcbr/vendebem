<?php
require_once '../config/database.php';
include 'partials/header.php';

$id = $_GET['id'];

// 🔹 Buscar produto atual
$produto = $conn->query("
    SELECT * FROM produtos WHERE id = $id
")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $estoque = $_POST['estoque'];

    $imagemNome = $produto['imagem']; // mantém a atual

    // 🔹 Se enviou nova imagem
    if (!empty($_FILES['imagem']['name'])) {

        // 🔸 Remove imagem antiga
        if (!empty($produto['imagem']) && file_exists("uploads/" . $produto['imagem'])) {
            unlink("uploads/" . $produto['imagem']);
        }

        // 🔸 Salva nova imagem
        $imagemNome = time() . "_" . $_FILES['imagem']['name'];
        $caminho = "uploads/" . $imagemNome;

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
    }

    // 🔹 Atualiza produto
    $conn->query("
        UPDATE produtos SET
        nome = '$nome',
        valor = '$valor',
        estoque = '$estoque',
        imagem = '$imagemNome'
        WHERE id = $id
    ");

    header("Location: produtos.php");
}
?>

<div class="card">
    <h1>Editar Produto</h1>

    <form method="POST" enctype="multipart/form-data">

        Nome:<br>
        <input type="text" name="nome" value="<?= $produto['nome'] ?>"><br><br>

        Valor:<br>
        <input type="text" name="valor" value="<?= $produto['valor'] ?>"><br><br>

        Estoque:<br>
        <input type="number" name="estoque" value="<?= $produto['estoque'] ?>"><br><br>

        <!-- 🔥 IMAGEM ATUAL -->
        <p>Imagem Atual:</p>

        <?php if ($produto['imagem']): ?>
            <img src="uploads/<?= $produto['imagem'] ?>" 
                 style="width:150px; height:150px; object-fit:cover;"><br><br>
        <?php else: ?>
            <p>Sem imagem</p>
        <?php endif; ?>

        <!-- 🔹 NOVA IMAGEM -->
        Nova Imagem:<br>
        <input type="file" name="imagem"><br><br>

        <button type="submit">Atualizar</button>

    </form>
</div>

<?php include 'partials/footer.php'; ?>