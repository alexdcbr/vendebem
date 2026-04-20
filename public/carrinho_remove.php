<?php
require_once '../config/database.php';
session_start();

$id = $_GET['id'];

$conn->query("DELETE FROM carrinho WHERE id = $id");

header("Location: carrinho.php");