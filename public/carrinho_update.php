<?php
require_once '../config/database.php';
session_start();

$id = $_GET['id'];
$acao = $_GET['acao'];

// Buscar item
$item = $conn->query("SELECT * FROM carrinho WHERE id = $id")->fetch_assoc();

if ($item) {

    if ($acao == 'mais') {
        $conn->query("UPDATE carrinho SET quantidade = quantidade + 1 WHERE id = $id");
    }

    if ($acao == 'menos') {

        if ($item['quantidade'] > 1) {
            $conn->query("UPDATE carrinho SET quantidade = quantidade - 1 WHERE id = $id");
        } else {
            $conn->query("DELETE FROM carrinho WHERE id = $id");
        }
    }
}

header("Location: carrinho.php");