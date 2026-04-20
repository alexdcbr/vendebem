<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção de acesso
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php?erro=acesso_negado");
    exit;
}

$venda_id = $_GET['venda_id'] ?? 0;

// 🔒 Busca e valida venda do cliente
$venda = $conn->query("
    SELECT * FROM vendas 
    WHERE id = $venda_id 
    AND cliente_id = " . $_SESSION['cliente_id']
)->fetch_assoc();

if (!$venda) {
    header("Location: vendas.php");
    exit;
}

// 🔒 Bloqueio se finalizada
$bloqueado = ($venda['status'] == 'finalizada');

// 🔹 Buscar produtos
$produtos = $conn->query("SELECT * FROM produtos");

// 🔹 Inserir item
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$bloqueado) {

    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];

    $produto = $conn->query("SELECT * FROM produtos WHERE id=$produto_id")->fetch_assoc();

    if ($produto) {

        if ($produto['estoque'] < $quantidade) {
            $erro = "Estoque insuficiente!";
        } else {

            $valor = $produto['valor'];

            // Inserir item
            $conn->query("
                INSERT INTO itens_venda 
                (venda_id, produto_id, quantidade, valor)
                VALUES ($venda_id, $produto_id, $quantidade, $valor)
            ");

            // 🔻 Baixa estoque
            $conn->query("
                UPDATE produtos 
                SET estoque = estoque - $quantidade 
                WHERE id = $produto_id
            ");
        }
    }
}

// 🔹 Listar itens
$itens = $conn->query("
    SELECT itens_venda.*, produtos.nome 
    FROM itens_venda
    JOIN produtos ON itens_venda.produto_id = produtos.id
    WHERE venda_id = $venda_id
");

// 🔹 TOTAL DE ITENS (novo)
$totalItens = $itens->num_rows;
?>

<div class="card">

    <h1>Venda #<?= $venda_id ?> (<?= $venda['status'] ?>)</h1>

    <?php if (!empty($erro)): ?>
        <p style="color:red;"><?= $erro ?></p>
    <?php endif; ?>

    <?php if ($bloqueado): ?>
        <p style="color:red;"><b>Venda finalizada - edição bloqueada</b></p>
    <?php endif; ?>

    <hr>

    <?php if (!$bloqueado): ?>
    <h3>Adicionar Produto</h3>

    <form method="POST">

        Produto:<br>
        <select name="produto_id">
            <?php while($p = $produtos->fetch_assoc()): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['nome'] ?> (Estoque: <?= $p['estoque'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>

        Quantidade:<br>
        <input type="number" name="quantidade" min="1" required>

        <br><br>

        <button type="submit">Adicionar</button>

    </form>
    <?php endif; ?>

    <hr>

    <h3>Itens da Venda</h3>

    <table>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>

        <?php while($item = $itens->fetch_assoc()): ?>
        <tr>
            <td><?= $item['nome'] ?></td>
            <td><?= $item['quantidade'] ?></td>
            <td>R$ <?= $item['valor'] ?></td>
            <td>
                <?php if (!$bloqueado): ?>
                    <a href="venda_item_delete.php?id=<?= $item['id'] ?>&venda_id=<?= $venda_id ?>">
                        Excluir
                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

    <br>

    <!-- 🔥 BLOQUEIO DE FINALIZAÇÃO SEM ITENS -->
    <?php if (!$bloqueado): ?>

        <?php if ($totalItens > 0): ?>
            <a href="venda_confirmar.php?venda_id=<?= $venda_id ?>">
                <button>Finalizar Venda</button>
            </a>
        <?php else: ?>
            <button disabled style="background-color: gray;">
                Adicione itens para finalizar
            </button>
        <?php endif; ?>

    <?php endif; ?>

    <br><br>

    <a href="vendas.php">Voltar</a>

</div>

<?php include 'partials/footer.php'; ?>