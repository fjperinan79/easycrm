<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="....../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="form-signin w-100 m-auto section">
    <form class="formulario" method="post" action="controllers/registro.php">
        <div class="titulo"><h1 class="h3 mb-3 fw-normal">Registro</h1></div>
        <input type="text" name="nombre" placeholder="Nombre completo" required class="form__field">
        <input type="email" name="email" placeholder="Correo electrónico" required class="form__field">
        <input type="password" name="password" placeholder="Contraseña" required class="form__field">
        <input type="password" name="repeat" placeholder="Repetir contraseña" required class="form__field">
        <div class="botones"><button class="btn" type="submit">Registrarse</button></div>
    </form>
    <?php
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 'invalid_email':
                echo "<p class='form__error'>El correo no tiene un formato válido.</p>"; break;
            case 'duplicate':
                echo "<p class='form__error'>El correo ya está registrado.</p>"; break;
            case 'nomatch':
                echo "<p class='form__error'>Las contraseñas no coinciden.</p>"; break;
            case 'save':
                echo "<p class='form__error'>No se pudo registrar el usuario.</p>"; break;
        }
    }
    ?>
</section>
</body>
</html>
