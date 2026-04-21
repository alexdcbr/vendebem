<?php
require_once '../config/database.php';

$id = $_GET['id'];

$sql = "DELETE FROM fornecedores WHERE id=$id";
$conn->query($sql);

header("Location: fornecedores.php");