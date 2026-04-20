<?php
require_once '../config/database.php';

$id = $_GET['id'];

$sql = "DELETE FROM produtos WHERE id=$id";
$conn->query($sql);

header("Location: produtos.php");