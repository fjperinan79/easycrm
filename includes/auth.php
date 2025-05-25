<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function require_admin() {
    if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
        header("Location: ../views/login.php");
        exit();
    }
}

function require_user() {
    if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "usuario") {
        header("Location: ../views/login.php");
        exit();
    }
}

function require_login() {
    if (!isset($_SESSION["usuario"])) {
        header("Location: ../views/login.php");
        exit();
    }
}
?>
