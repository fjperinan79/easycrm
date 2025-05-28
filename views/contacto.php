<!DOCTYPE html>
<html lang="es">
<head>
    <title>Formulario de contacto</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php
require_once '../includes/auth.php';
require_admin(); include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Formulario de contacto</h2>
    <form method="post" action="../controllers/contacto.php" class="form">
        <input name="nombre" placeholder="Nombre" required class="form__field">
        <input name="apellidos" placeholder="Apellidos" required class="form__field">
        <input name="telefono" placeholder="Teléfono" required class="form__field">
        <input name="correo" placeholder="Correo" required class="form__field">
        <input name="asunto" placeholder="Asunto" required class="form__field">
        <textarea name="mensaje" placeholder="Mensaje" required class="form__field"></textarea>
        <button type="submit" class="btn">Enviar</button>
    </form>
</section>
<?php
require_once '../includes/auth.php';
require_admin(); if (isset($_GET['error'])): ?>
<script>alert("Por favor, completa todos los campos correctamente.");</script>
<?php
require_once '../includes/auth.php';
require_admin(); elseif (isset($_GET['success'])): ?>
<script>alert("Mensaje enviado con éxito.");</script>
<?php
require_once '../includes/auth.php';
require_admin(); endif; ?>
</body>
</html>
