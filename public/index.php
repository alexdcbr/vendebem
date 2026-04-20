<?php
session_start();

if (isset($_SESSION['cliente_id'])) {
    header("Location: home.php");
} else {
    header("Location: login.php");
}
exit;