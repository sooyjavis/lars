<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lars";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Recibe los datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$escuela = $_POST['escuela'];
$turno = $_POST['turno'];
$password_input = $_POST['password'];

// Hash de la contraseña para almacenarla cifrada en la base de datos
$hashed_password = password_hash($password_input, PASSWORD_DEFAULT);

try {
    // Conecta a la base de datos
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta preparada para insertar o actualizar el usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, email, escuela, turno, password, password_plaintext) 
                            VALUES (:nombre, :apellidos, :email, :escuela, :turno, :password, :password_plaintext)
                            ON DUPLICATE KEY UPDATE 
                            nombre = VALUES(nombre), 
                            apellidos = VALUES(apellidos), 
                            escuela = VALUES(escuela), 
                            turno = VALUES(turno), 
                            password = VALUES(password), 
                            password_plaintext = VALUES(password_plaintext)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':escuela', $escuela);
    $stmt->bindParam(':turno', $turno);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':password_plaintext', $password_input); // Guardar contraseña en texto plano
    $stmt->execute();

    echo "Usuario registrado o actualizado correctamente.";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>
