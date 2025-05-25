<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="form-signin w-100 m-auto section">
<form class="formulario" method="post" action="../controllers/login.php">
    <div class="titulo"><h1 class="h3 mb-3 fw-normal">Inicio de sesión</h1></div>
    <input type="email" name="email" placeholder="Correo electrónico" required class="form__field">
    <input type="password" name="password" placeholder="Contraseña" required class="form__field">
    <div class="botones"><button class="btn btn-primary" type="submit">Entrar</button></div>
    <?php if (isset($_GET['error'])) echo "<p class='form__error'>Credenciales incorrectas</p>"; ?>
</form>
</section>
</body>
</html>
