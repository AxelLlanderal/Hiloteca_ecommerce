<?php
/*
| CONTROLADOR CARRITO
*/

require_once __DIR__ . '/../models/Producto.php';

class CarritoController {

    /*
    | VALIDAR CLIENTE
    */
    private function validarCliente() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        if ($_SESSION['usuario']['rol'] != 'cliente') {
            header("Location: index.php?accion=admin_dashboard");
            exit;
        }
    }

    /*
    | AGREGAR PRODUCTO
    */
    public function agregar($id) {
        $this->validarCliente();

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

    /*
    | VER CARRITO
    */
    public function verCarrito() {
        $this->validarCliente();

        $carrito = $_SESSION['carrito'] ?? [];

        require __DIR__ . '/../views/carrito.php';
    }

    /*
    | ELIMINAR PRODUCTO
    */
    public function eliminar($id) {
        $this->validarCliente();

        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    /*
    | VACIAR CARRITO
    */
    public function vaciar() {
        $this->validarCliente();

        unset($_SESSION['carrito']);

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    /*
    | AUMENTAR CANTIDAD
    */
    public function aumentar($id) {
        $this->validarCliente();

        $producto = Producto::obtenerPorId($id);

        if (isset($_SESSION['carrito'][$id]) && $producto) {
            if ($_SESSION['carrito'][$id]['cantidad'] < $producto['stock_final']) {
                $_SESSION['carrito'][$id]['cantidad']++;
            }
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }

    /*
    | DISMINUIR CANTIDAD
    */
    public function disminuir($id) {
        $this->validarCliente();

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']--;

            if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }

        header("Location: index.php?accion=ver_carrito");
        exit;
    }
}
?>