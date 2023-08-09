<?php 

// importar la conexion
require 'includes/app.php';
$db = conectarDB();

// crea un email y un password

$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);
// query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}'); ";

// insertar en la base de datos

mysqli_query($db, $query);
