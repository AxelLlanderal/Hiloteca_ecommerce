<?php
require_once __DIR__ . '/../config/db.php';

class InventarioAdminController {

    private function validarAdmin() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
            header("Location: index.php?accion=login");
            exit;
        }
    }

    public function index() {

        $this->validarAdmin();

        global $conexion;

        $sql = "SELECT 
                    a.id,
                    a.producto_id,
                    p.nombre,
                    p.imagen,
                    a.stock_inicial,
                    a.stock_final,
                    a.stock_minimo,
                    a.ubicacion,
                    a.fecha_actualizacion
                FROM ms_almacen a
                INNER JOIN productos p 
                    ON a.producto_id = p.id
                ORDER BY p.nombre ASC";

        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $inventario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/inventario.php';
    }

    public function movimientoForm() {

        $this->validarAdmin();

        global $conexion;

        $producto_id = $_GET['producto_id'] ?? null;

        $sql = "SELECT 
                    a.producto_id,
                    p.nombre,
                    a.stock_final,
                    a.stock_minimo,
                    a.ubicacion
                FROM ms_almacen a
                INNER JOIN productos p 
                    ON a.producto_id = p.id
                WHERE a.producto_id = :producto_id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->execute();

        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/inventario_form.php';
    }

    public function guardarMovimiento() {

        $this->validarAdmin();

        global $conexion;

        $producto_id = $_POST['producto_id'] ?? null;
        $tipo = $_POST['tipo_movimiento'] ?? '';
        $cantidad = intval($_POST['cantidad'] ?? 0);
        $motivo = trim($_POST['motivo'] ?? '');

        $usuarioId = $_SESSION['usuario']['id'];

        if (
            !$producto_id ||
            $cantidad <= 0 ||
            !in_array($tipo, ['entrada', 'salida'])
        ) {
            header("Location: index.php?accion=admin_inventario");
            exit;
        }

        try {

            $conexion->beginTransaction();

            $sqlActual = "SELECT stock_final
                          FROM ms_almacen
                          WHERE producto_id = :producto_id";

            $stmtActual = $conexion->prepare($sqlActual);
            $stmtActual->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmtActual->execute();

            $almacen = $stmtActual->fetch(PDO::FETCH_ASSOC);

            if (!$almacen) {
                throw new Exception("Producto no encontrado");
            }

            $stockAnterior = intval($almacen['stock_final']);

            if ($tipo == 'entrada') {

                $stockNuevo = $stockAnterior + $cantidad;

            } else {

                if ($cantidad > $stockAnterior) {
                    throw new Exception("Stock insuficiente");
                }

                $stockNuevo = $stockAnterior - $cantidad;
            }

            $sqlUpdate = "UPDATE ms_almacen
                          SET stock_final = :stock_nuevo,
                              fecha_actualizacion = NOW(),
                              actualizado_por = :usuario
                          WHERE producto_id = :producto_id";

            $stmtUpdate = $conexion->prepare($sqlUpdate);

            $stmtUpdate->bindParam(':stock_nuevo', $stockNuevo, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':usuario', $usuarioId, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);

            $stmtUpdate->execute();

            $sqlLog = "INSERT INTO logs_stock
                        (
                            producto_id,
                            stock_anterior,
                            cantidad_movida,
                            stock_nuevo,
                            tipo_movimiento,
                            motivo,
                            actualizado_por
                        )
                        VALUES
                        (
                            :producto_id,
                            :stock_anterior,
                            :cantidad,
                            :stock_nuevo,
                            :tipo,
                            :motivo,
                            :usuario
                        )";

            $stmtLog = $conexion->prepare($sqlLog);

            $stmtLog->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmtLog->bindParam(':stock_anterior', $stockAnterior, PDO::PARAM_INT);
            $stmtLog->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtLog->bindParam(':stock_nuevo', $stockNuevo, PDO::PARAM_INT);
            $stmtLog->bindParam(':tipo', $tipo);
            $stmtLog->bindParam(':motivo', $motivo);
            $stmtLog->bindParam(':usuario', $usuarioId, PDO::PARAM_INT);

            $stmtLog->execute();

            $conexion->commit();

            header("Location: index.php?accion=admin_inventario");
            exit;

        } catch (Exception $e) {

            $conexion->rollBack();

            header("Location: index.php?accion=admin_inventario&error=1");
            exit;
        }
    }
}
?>