<?php
require_once __DIR__ . '/../models/Producto.php';

class CarritoController {

    public function agregar($id) {
        session_start();

        $producto = Producto::obtenerPorId($id);

        if (!$producto) {
            header("Location: index.php");
            exit;
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $cantidadActual = 0;

        if (isset($_SESSION['carrito'][$id])) {
            $cantidadActual = $_SESSION['carrito'][$id]['cantidad'];
        }

        if ($cantidadActual >= $producto['stock_final']) {
            header("Location: index.php?stock=limite");
            exit;
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen'],
                'stock' => $producto['stock_final'],
                'cantidad' => 1
            ];
        }

        header("Location: index.php?agregado=1");
        exit;
    }

    public function verCarrito() {
        session_start();

        $carrito = $_SESSION['carrito'] ?? [];

        require __DIR__ . '/../views/carrito.php';
    }

    public function eliminar($id) {
        session_start();

        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    public function vaciar() {
        session_start();

        unset($_SESSION['carrito']);

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    public function aumentar($id) {
        session_start();

        $producto = Producto::obtenerPorId($id);

        if (isset($_SESSION['carrito'][$id]) && $producto) {
            if ($_SESSION['carrito'][$id]['cantidad'] < $producto['stock_final']) {
                $_SESSION['carrito'][$id]['cantidad']++;
            }
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    public function disminuir($id) {
        session_start();

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']--;

            if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    public function finalizar() {
        session_start();
        global $conexion;

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = "Debes iniciar sesión para finalizar la compra";
            header("Location: index.php?accion=login");
            exit;
        }

        if (empty($_SESSION['carrito'])) {
            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id'];

        foreach ($_SESSION['carrito'] as $item) {

            $sqlStock = "SELECT stock_final 
                         FROM ms_almacen 
                         WHERE producto_id = :producto_id";

            $stmtStock = $conexion->prepare($sqlStock);
            $stmtStock->bindParam(':producto_id', $item['id'], PDO::PARAM_INT);
            $stmtStock->execute();

            $almacen = $stmtStock->fetch(PDO::FETCH_ASSOC);

            if (!$almacen || $almacen['stock_final'] < $item['cantidad']) {
                header("Location: index.php?stock=limite");
                exit;
            }

            $stockAnterior = $almacen['stock_final'];
            $cantidadMovida = $item['cantidad'];
            $stockNuevo = $stockAnterior - $cantidadMovida;

            $sqlUpdate = "UPDATE ms_almacen
                          SET stock_final = :stock_nuevo,
                              actualizado_por = :usuario
                          WHERE producto_id = :producto_id";

            $stmtUpdate = $conexion->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':stock_nuevo', $stockNuevo, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':usuario', $usuarioId, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':producto_id', $item['id'], PDO::PARAM_INT);
            $stmtUpdate->execute();

            $sqlLog = "INSERT INTO logs_stock
                       (producto_id, stock_anterior, cantidad_movida, stock_nuevo, tipo_movimiento, motivo, actualizado_por)
                       VALUES
                       (:producto_id, :stock_anterior, :cantidad_movida, :stock_nuevo, 'salida', 'Compra realizada', :usuario)";

            $stmtLog = $conexion->prepare($sqlLog);
            $stmtLog->bindParam(':producto_id', $item['id'], PDO::PARAM_INT);
            $stmtLog->bindParam(':stock_anterior', $stockAnterior, PDO::PARAM_INT);
            $stmtLog->bindParam(':cantidad_movida', $cantidadMovida, PDO::PARAM_INT);
            $stmtLog->bindParam(':stock_nuevo', $stockNuevo, PDO::PARAM_INT);
            $stmtLog->bindParam(':usuario', $usuarioId, PDO::PARAM_INT);
            $stmtLog->execute();
        }

        unset($_SESSION['carrito']);

        header("Location: index.php?compra=ok");
        exit;
    }
}
?>