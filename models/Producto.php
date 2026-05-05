<?php
/*
| MODELO PRODUCTO
*/

require_once __DIR__ . '/../config/db.php';

class Producto {

    /*
    | OBTENER TODOS LOS PRODUCTOS ACTIVOS
    */
    public static function obtenerTodos() {
        global $conexion;

        $sql = "SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.imagen,
                    p.categoria,
                    p.estado,
                    a.stock_inicial,
                    a.stock_final,
                    (a.stock_inicial - a.stock_final) AS stock_vendido,
                    a.fecha_actualizacion
                FROM productos p
                INNER JOIN ms_almacen a ON p.id = a.producto_id
                WHERE p.estado = 'activo'";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    | OBTENER PRODUCTO POR ID
    */
    public static function obtenerPorId($id) {
        global $conexion;

        $sql = "SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.imagen,
                    p.categoria,
                    p.estado,
                    a.stock_inicial,
                    a.stock_final,
                    (a.stock_inicial - a.stock_final) AS stock_vendido,
                    a.fecha_actualizacion
                FROM productos p
                INNER JOIN ms_almacen a ON p.id = a.producto_id
                WHERE p.id = :id AND p.estado = 'activo'";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>