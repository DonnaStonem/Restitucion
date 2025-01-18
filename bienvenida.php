<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

echo "Bienvenido, " . $_SESSION['username'] . "!";
?>
