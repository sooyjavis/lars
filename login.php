<?php
// Establece la conexión con tu base de datos
$servername = "localhost"; // Cambia localhost por tu servidor de base de datos
$username = "u569309670_lars_"; // Cambia usuario por tu nombre de usuario de la base de datos
$password = "Senk1419__"; // Cambia contraseña por tu contraseña de la base de datos
$dbname = "u569309670_lars"; // Cambia nombre_bd por el nombre de tu base de datos

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Recibe los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Consulta para verificar las credenciales
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Usuario autenticado correctamente
  echo "¡Inicio de sesión exitoso!";
} else {
  // Error de autenticación
  echo "Usuario o contraseña incorrectos.";
}

$conn->close();
?>