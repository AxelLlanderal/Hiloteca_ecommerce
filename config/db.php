<?php
/*
| CONFIGURACIÓN DE CONEXIÓN A BASE DE DATOS
*/

// Dirección del servidor de base de datos (localhost en este caso)
$host = "127.0.0.1";

// Puerto en el que corre MySQL (XAMPP usa 3307 en algunos casos)
$port = "3307";

// Nombre de la base de datos que se va a utilizar
$dbname = "Hiloteca";

// Usuario de la base de datos (por defecto en XAMPP es "root")
$user = "root";

// Contraseña del usuario (vacía por defecto en XAMPP)
$password = "";

try {
    /*
    | CREACIÓN DE LA CONEXIÓN PDO
    */
    $conexion = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    /*
    | CONFIGURACIÓN DE MANEJO DE ERRORES
    */
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    /*
    | MANEJO DE ERRORES DE CONEXIÓN
    */
    die("Error de conexión: " . $e->getMessage());
}
?>