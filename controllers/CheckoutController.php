<?php
require_once __DIR__ . '/../models/Pedido.php';

class CheckoutController {

    public function mostrarCheckout() {
        session_start();

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = "Debes iniciar sesión para finalizar la compra";
            header("Location: index.php?accion=login");
            exit;
        }

        if (empty($_SESSION['carrito'])) {
            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $carrito = $_SESSION['carrito'];

        require __DIR__ . '/../views/checkout.php';
    }

    public function procesarPago() {
        session_start();

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=login");
            exit;
        }

        if (empty($_SESSION['carrito'])) {
            header("Location: index.php?accion=ver_carrito");
            exit;
        }

        $metodo_pago = $_POST['metodo_pago'] ?? '';
        $numero_tarjeta = $_POST['numero_tarjeta'] ?? '';
        $cvv = $_POST['cvv'] ?? '';

        if (empty($metodo_pago) || empty($numero_tarjeta) || empty($cvv)) {
            $_SESSION['error'] = "Todos los datos de pago son obligatorios";
            header("Location: index.php?accion=checkout");
            exit;
        }

        if (strlen($numero_tarjeta) == 16 && strlen($cvv) == 3) {

            $pedido_id = Pedido::crearPedido(
                $_SESSION['usuario']['id'],
                $_SESSION['carrito'],
                $metodo_pago
            );

            if ($pedido_id) {
                unset($_SESSION['carrito']);
                $_SESSION['pedido_id'] = $pedido_id;

                header("Location: index.php?accion=confirmacion");
                exit;
            }

            $_SESSION['error'] = "No se pudo crear el pedido. Verifica el stock.";
            header("Location: index.php?accion=checkout");
            exit;
        }

        $_SESSION['error'] = "Pago rechazado. Verifique los datos.";
        header("Location: index.php?accion=checkout");
        exit;
    }

    public function confirmacion() {
        session_start();

        $pedido_id = $_SESSION['pedido_id'] ?? null;

        require __DIR__ . '/../views/confirmacion.php';
    }
}
?>