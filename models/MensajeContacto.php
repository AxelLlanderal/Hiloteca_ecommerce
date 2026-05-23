<?php
/*
| MODELO MENSAJE CONTACTO
*/

require_once __DIR__ . '/../config/db.php';

class MensajeContacto {

    /*
    | GUARDAR MENSAJE
    */
    public static function guardar($nombre, $correo, $asunto, $mensaje) {
        global $conexion;

        $sql = "INSERT INTO mensajes_contacto 
                (nombre, correo, asunto, mensaje)
                VALUES 
                (:nombre, :correo, :asunto, :mensaje)";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':asunto', $asunto);
        $stmt->bindParam(':mensaje', $mensaje);

        return $stmt->execute();
    }

    /*
    | OBTENER MENSAJES
    */
    public static function obtenerTodos() {
        global $conexion;

        $sql = "SELECT * FROM mensajes_contacto ORDER BY fecha DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    | OBTENER MENSAJE POR ID
    */
    public static function obtenerPorId($id) {
        global $conexion;

        $sql = "SELECT * FROM mensajes_contacto WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    | GUARDAR RESPUESTA
    */
    public static function responder($id, $respuesta) {
        global $conexion;

        $sql = "UPDATE mensajes_contacto
                SET respuesta = :respuesta,
                    estado = 'respondido'
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':respuesta', $respuesta);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /*
    | OBTENER MENSAJES POR CORREO
    */
    public static function obtenerPorCorreo($correo) {
        global $conexion;

        $sql = "SELECT * 
                FROM mensajes_contacto 
                WHERE correo = :correo 
                ORDER BY fecha DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>