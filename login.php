<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lars";

// Recibe los datos del formulario
$email = $_POST['email'];
$password_input = $_POST['password'];

try {
    // Conecta a la base de datos
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta preparada para obtener el usuario por email
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Verifica si se encontró algún usuario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Verifica la contraseña usando password_verify
        if (password_verify($password_input, $user['password'])) {
            // Guarda la información en la sesión
            $_SESSION['email'] = $email;
            // Redirige al dashboard
            header("Location: dashboard.php");
            exit; // Asegúrate de salir después de redirigir
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró ningún usuario con el correo electrónico: " . $email;
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cierra la conexión
$conn = null;
?>
