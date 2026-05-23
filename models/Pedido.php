<?php
/*
| MODELO PEDIDO
*/

require_once __DIR__ . '/../config/db.php';

class Pedido {

    /*
    | CREAR PEDIDO
    */
    public static function crearPedido($usuario_id, $carrito, $metodo_pago) {
        global $conexion;

        try {
            $conexion->beginTransaction();

            $total = 0;

            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            $sql = "INSERT INTO pedidos (usuario_id, total, estado, metodo_pago)
                    VALUES (:usuario_id, :total, 'pagado', :metodo_pago)";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $usuario_id,
                ':total' => $total,
                ':metodo_pago' => $metodo_pago
            ]);

            $pedido_id = $conexion->lastInsertId();

            foreach ($carrito as $item) {

                $sqlStockActual = "SELECT stock_final 
                                   FROM ms_almacen 
                                   WHERE producto_id = :producto_id";

                $stmtStockActual = $conexion->prepare($sqlStockActual);
                $stmtStockActual->execute([
                    ':producto_id' => $item['id']
                ]);

                $almacen = $stmtStockActual->fetch(PDO::FETCH_ASSOC);

                if (!$almacen || $almacen['stock_final'] < $item['cantidad']) {
                    throw new Exception("Stock insuficiente");
                }

                $stockAnterior = (int)$almacen['stock_final'];
                $cantidadMovida = (int)$item['cantidad'];
                $stockNuevo = $stockAnterior - $cantidadMovida;
                $subtotal = $item['precio'] * $item['cantidad'];

                $sqlDetalle = "INSERT INTO detalle_pedido 
                    (pedido_id, producto_id, nombre_producto, precio, cantidad, subtotal)
                    VALUES 
                    (:pedido_id, :producto_id, :nombre_producto, :precio, :cantidad, :subtotal)";

                $stmtDetalle = $conexion->prepare($sqlDetalle);
                $stmtDetalle->execute([
                    ':pedido_id' => $pedido_id,
                    ':producto_id' => $item['id'],
                    ':nombre_producto' => $item['nombre'],
                    ':precio' => $item['precio'],
                    ':cantidad' => $item['cantidad'],
                    ':subtotal' => $subtotal
                ]);

                $sqlUpdate = "UPDATE ms_almacen
                              SET stock_final = :stock_nuevo,
                                  actualizado_por = :usuario_id
                              WHERE producto_id = :producto_id";

                $stmtUpdate = $conexion->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':stock_nuevo' => $stockNuevo,
                    ':usuario_id' => $usuario_id,
                    ':producto_id' => $item['id']
                ]);

                $sqlLog = "INSERT INTO logs_stock
                    (producto_id, stock_anterior, cantidad_movida, stock_nuevo, tipo_movimiento, motivo, actualizado_por)
                    VALUES
                    (:producto_id, :stock_anterior, :cantidad_movida, :stock_nuevo, 'salida', 'Pedido pagado', :usuario_id)";

                $stmtLog = $conexion->prepare($sqlLog);
                $stmtLog->execute([
                    ':producto_id' => $item['id'],
                    ':stock_anterior' => $stockAnterior,
                    ':cantidad_movida' => $cantidadMovida,
                    ':stock_nuevo' => $stockNuevo,
                    ':usuario_id' => $usuario_id
                ]);
            }

            $conexion->commit();
            return $pedido_id;

        } catch (Exception $e) {
            $conexion->rollBack();
            return false;
        }
    }

    /*
    | OBTENER PEDIDOS ADMIN
    */
    public static function obtenerTodosAdmin() {
        global $conexion;

        $sql = "SELECT 
                    p.id,
                    p.total,
                    p.estado,
                    p.metodo_pago,
                    p.fecha_creacion,
                    u.nombre AS cliente,
                    u.email AS email
                FROM pedidos p
                INNER JOIN usuarios u ON p.usuario_id = u.id
                ORDER BY p.fecha_creacion DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    | ACTUALIZAR ESTADO
    */
    public static function actualizarEstado($id, $estado) {
        global $conexion;

        $sql = "UPDATE pedidos 
                SET estado = :estado 
                WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>