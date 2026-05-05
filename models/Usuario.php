<?php
/*
| MODELO USUARIO
*/

require_once __DIR__ . '/../config/db.php';

class Usuario {

    /*
    | REGISTRAR USUARIO
    */
    public static function registrar($nombre, $email, $password) {
        global $conexion;

        // verificar si ya existe el email
        $existe = self::buscarPorEmail($email);
        if ($existe) {
            return false;
        }

        // encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password) 
                VALUES (:nombre, :email, :password)";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        return $stmt->execute();
    }

    /*
    | BUSCAR USUARIO POR EMAIL
    */
    public static function buscarPorEmail($email) {
        global $conexion;

        $sql = "SELECT * FROM usuarios 
                WHERE email = :email AND estado = 'activo'";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    | VALIDAR LOGIN
    */
    public static function login($email, $password) {
        $usuario = self::buscarPorEmail($email);

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }
}
?>