<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? 0;
$cliente_id = $_SESSION['cliente_id'];

// 🔹 Produto + categoria
$produto = $conn->query("
    SELECT produtos.*, categorias.nome AS categoria_nome 
    FROM produtos
    LEFT JOIN categorias ON produtos.categoria_id = categorias.id
    WHERE produtos.id = $id
")->fetch_assoc();

if (!$produto) {
    echo "<p>Produto não encontrado</p>";
    exit;
}

// 🔹 Verifica se já avaliou
$avaliacaoExistente = $conn->query("
    SELECT * FROM avaliacoes 
    WHERE produto_id = $id AND cliente_id = $cliente_id
")->fetch_assoc();

// 🔹 Salvar avaliação
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nota = $_POST['nota'];
    $comentario = $_POST['comentario'];

    if ($avaliacaoExistente) {
        // 🔥 Atualiza
        $conn->query("
            UPDATE avaliacoes SET
            nota = $nota,
            comentario = '$comentario',
            data = NOW()
            WHERE produto_id = $id AND cliente_id = $cliente_id
        ");
    } else {
        // 🔥 Insere
        $conn->query("
            INSERT INTO avaliacoes (produto_id, cliente_id, nota, comentario)
            VALUES ($id, $cliente_id, $nota, '$comentario')
        ");
    }

    header("Location: produto.php?id=$id");
    exit;
}

// 🔹 Avaliações
$avaliacoes = $conn->query("
    SELECT avaliacoes.*, clientes.nome 
    FROM avaliacoes
    JOIN clientes ON avaliacoes.cliente_id = clientes.id
    WHERE produto_id = $id
");

// 🔹 Média
$media = $conn->query("
    SELECT AVG(nota) as media 
    FROM avaliacoes 
    WHERE produto_id = $id
")->fetch_assoc()['media'] ?? 0;

// 🔥 Produtos relacionados (mesma categoria)
$relacionados = $conn->query("
    SELECT * FROM produtos 
    WHERE categoria_id = {$produto['categoria_id']} 
    AND id != $id
    LIMIT 4
");
?>

<div class="card">

    <!-- 🔥 PRODUTO -->
    <div style="display:flex; gap:30px; flex-wrap:wrap;">

        <!-- IMAGEM -->
        <div style="flex:1; min-width:300px; text-align:center;">
            <div style="
                height:300px;
                display:flex;
                align-items:center;
                justify-content:center;
                background:#f8f8f8;
                border-radius:10px;
            ">
                <?php if ($produto['imagem']): ?>
                    <img src="uploads/<?= $produto['imagem'] ?>" 
                         style="max-width:100%; max-height:100%; object-fit:contain;">
                <?php else: ?>
                    <span>Sem imagem</span>
                <?php endif; ?>
            </div>
        </div>

        <!-- DETALHES -->
        <div style="flex:1; min-width:300px;">

            <h1><?= $produto['nome'] ?></h1>

            <p><b>Categoria:</b> <?= $produto['categoria_nome'] ?? 'Sem categoria' ?></p>

            <h2 style="color:#27ae60;">
                R$ <?= number_format($produto['valor'], 2, ',', '.') ?>
            </h2>

            <!-- ⭐ MÉDIA -->
            <div style="font-size:20px; color:gold;">
                <?= str_repeat("★", round($media)) ?>
                <?= str_repeat("☆", 5 - round($media)) ?>
                (<?= number_format($media,1) ?>)
            </div>

            <p><b>Estoque:</b> <?= $produto['estoque'] ?></p>

            <br>

            <a href="carrinho_add.php?id=<?= $produto['id'] ?>">
                <button style="background:green; padding:12px;">
                    🛒 Adicionar ao Carrinho
                </button>
            </a>

        </div>

    </div>

    <hr>

    <!-- 🔥 FORM AVALIAÇÃO -->
    <h3>
        <?= $avaliacaoExistente ? 'Editar sua avaliação' : 'Avaliar Produto' ?>
    </h3>

    <form method="POST">

        Nota:<br>
        <select name="nota" required>
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <option value="<?= $i ?>" 
                    <?= ($avaliacaoExistente && $avaliacaoExistente['nota'] == $i) ? 'selected' : '' ?>>
                    <?= str_repeat("⭐", $i) ?>
                </option>
            <?php endfor; ?>
        </select>

        <br><br>

        Comentário:<br>
        <textarea name="comentario"><?= $avaliacaoExistente['comentario'] ?? '' ?></textarea>

        <br><br>

        <button type="submit">Salvar Avaliação</button>

    </form>

    <hr>

    <!-- 🔥 LISTA DE AVALIAÇÕES -->
    <h3>Avaliações</h3>

    <?php while($a = $avaliacoes->fetch_assoc()): ?>
        <div style="border-bottom:1px solid #ddd; padding:10px 0;">
            <b><?= $a['nome'] ?></b><br>

            <span style="color:gold;">
                <?= str_repeat("★", $a['nota']) ?>
                <?= str_repeat("☆", 5 - $a['nota']) ?>
            </span>

            <p><?= $a['comentario'] ?></p>
        </div>
    <?php endwhile; ?>

    <hr>

    <!-- 🔥 RELACIONADOS -->
    <h3>Produtos Relacionados</h3>

    <div style="display:flex; gap:20px; flex-wrap:wrap;">

        <?php while($r = $relacionados->fetch_assoc()): ?>

            <a href="produto.php?id=<?= $r['id'] ?>" style="text-decoration:none; color:inherit;">
                
                <div class="card" style="width:200px; text-align:center;">

                    <div style="height:150px; display:flex; align-items:center; justify-content:center;">
                        <?php if ($r['imagem']): ?>
                            <img src="uploads/<?= $r['imagem'] ?>" style="max-width:100%; max-height:100%;">
                        <?php endif; ?>
                    </div>

                    <b><?= $r['nome'] ?></b>

                    <p>R$ <?= number_format($r['valor'], 2, ',', '.') ?></p>

                </div>

            </a>

        <?php endwhile; ?>

    </div>

</div>

<?php include 'partials/footer.php'; ?>