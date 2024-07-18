<?php
$conn = new mysqli("localhost", "root", "", "lars");

if ($conn->connect_error) {
    echo 'Error de conexion ' . $conn->connect_error;
    exit;
}
?>
