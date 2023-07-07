<?php 

// importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

// crea un email y un password

$email = "correo@correo.com";
$password = "123456";

// query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$password}'); ";

// insertar en la base de datos

mysqli_query($db, $query);
