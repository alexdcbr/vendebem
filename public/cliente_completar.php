<?php
require_once '../config/database.php';
include 'partials/header.php';

// 🔒 Proteção de acesso
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// 🔹 Buscar dados do cliente
$cliente = $conn->query("
    SELECT * FROM clientes WHERE id = $cliente_id
")->fetch_assoc();

// 🔹 Salvar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $conn->query("
        UPDATE clientes SET
        email = '$email',
        telefone1 = '$telefone',
        endereco = '$endereco',
        cadastro_completo = 1
        WHERE id = $cliente_id
    ");

    header("Location: home.php");
    exit;
}
?>

<div class="card">
    <h1>Completar Cadastro</h1>

    <p>Preencha seus dados para continuar</p>

    <form method="POST">

        Email:<br>
        <input type="email" name="email" value="<?= $cliente['email'] ?? '' ?>"><br><br>

        Telefone:<br>
        <input type="text" name="telefone" value="<?= $cliente['telefone'] ?? '' ?>"><br><br>

        Endereço:<br>
        <input type="text" name="endereco" value="<?= $cliente['endereco'] ?? '' ?>"><br><br>

        <button type="submit">Salvar</button>

    </form>
</div>

<?php include 'partials/footer.php'; ?>