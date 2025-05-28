<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">
    <img src="../public/img/logo.png" alt="EasyCRM" class="logo">
    <button id="menu-toggle" class="menu-toggle">☰</button>
    <nav>
        <ul class="nav">
            <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin"): ?>
                <li><a href="../views/panel.php">Panel</a></li>
                <li><a href="../views/contactos.php">Clientes</a></li>
                <li><a href="../views/productos.php">Productos</a></li>
                <li><a href="../views/tickets.php">Tickets</a></li>
                <li><a href="../views/reportes.php">Reportes</a></li>
                <li><a href="../views/interacciones.php">Interacciones</a></li>
                <li><a href="../views/contacto.php">Contacto</a></li>
                <li><a href="../views/usuarios.php">Usuarios</a></li>
                <li><a href="../views/nuevo_usuario.php">Nuevo Usuario</a></li>
            <?php elseif (isset($_SESSION["rol"]) && $_SESSION["rol"] === "usuario"): ?>
                <li><a href="../views/tickets.php">Tickets</a></li>
                <li><a href="../views/interacciones.php">Interacciones</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <form action="../controllers/logout.php" method="post">
        <button type="submit" class="btn">Cerrar sesión</button>
    </form>

    <script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.querySelector('.nav').classList.toggle('show');
    });
    </script>


</header>