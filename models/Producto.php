<?php
/*
| MODELO PRODUCTO
*/

require_once __DIR__ . '/../config/db.php';

class Producto {

    /*
    | OBTENER PRODUCTOS ACTIVOS
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

    /*
    | OBTENER PRODUCTOS ADMIN
    */
    public static function obtenerTodosAdmin() {
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
                    (a.stock_inicial - a.stock_final) AS stock_vendido
                FROM productos p
                LEFT JOIN ms_almacen a ON p.id = a.producto_id
                ORDER BY p.id DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    | OBTENER PRODUCTO ADMIN
    */
    public static function obtenerPorIdAdmin($id) {
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
                    a.stock_final
                FROM productos p
                LEFT JOIN ms_almacen a ON p.id = a.producto_id
                WHERE p.id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    | CREAR PRODUCTO
    */
    public static function crear($nombre, $descripcion, $precio, $imagen, $categoria, $stockInicial) {
        global $conexion;

        try {
            $conexion->beginTransaction();

            $sql = "INSERT INTO productos 
                    (nombre, descripcion, precio, imagen, categoria, estado)
                    VALUES 
                    (:nombre, :descripcion, :precio, :imagen, :categoria, 'activo')";

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();

            $productoId = $conexion->lastInsertId();

            $sqlAlmacen = "INSERT INTO ms_almacen 
                           (producto_id, stock_inicial, stock_final, actualizado_por)
                           VALUES 
                           (:producto_id, :stock_inicial, :stock_final, NULL)";

            $stmtAlmacen = $conexion->prepare($sqlAlmacen);
            $stmtAlmacen->bindParam(':producto_id', $productoId);
            $stmtAlmacen->bindParam(':stock_inicial', $stockInicial);
            $stmtAlmacen->bindParam(':stock_final', $stockInicial);
            $stmtAlmacen->execute();

            $conexion->commit();
            return true;

        } catch (Exception $e) {
            $conexion->rollBack();
            return false;
        }
    }

    /*
    | ACTUALIZAR PRODUCTO
    */
    public static function actualizarProducto($id, $nombre, $descripcion, $precio, $imagen, $categoria) {
        global $conexion;

        $sql = "UPDATE productos 
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    imagen = :imagen,
                    categoria = :categoria
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /*
    | CAMBIAR ESTADO
    */
    public static function cambiarEstado($id, $estado) {
        global $conexion;

        $sql = "UPDATE productos 
                SET estado = :estado 
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
?>