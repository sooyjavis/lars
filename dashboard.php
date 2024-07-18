<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['email'])) {
    // Si no está autenticado, redirigir al inicio de sesión
    header("Location: index.php");
    exit();
}

// Aquí va el contenido del dashboard
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>
  <h1>Bienvenido al Dashboard</h1>
  <p>Contenido del dashboard...</p>

  <a href="logout.php">Cerrar sesión</a>
</body>
</html>
