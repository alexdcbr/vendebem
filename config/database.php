<?php

$host = "localhost";
$db = "vendebem";
$user = "root";
$pass = ""; // no XAMPP normalmente é vazio

$conn = new mysqli($host, $user, $pass, $db);

// Verifica erro
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Define charset (importante para acentuação)
$conn->set_charset("utf8");