<?php
require_once 'controllers/ProductoController.php';
require_once 'controllers/CarritoController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CheckoutController.php';

$accion = $_GET['accion'] ?? 'catalogo';

switch ($accion) {

    case 'catalogo':
        $controller = new ProductoController();
        $controller->mostrarCatalogo();
        break;

    case 'login':
        $controller = new AuthController();
        $controller->mostrarLogin();
        break;

    case 'registro':
        $controller = new AuthController();
        $controller->mostrarRegistro();
        break;

    case 'guardar_usuario':
        $controller = new AuthController();
        $controller->registrar();
        break;

    case 'validar_login':
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'agregar_carrito':
        $id = $_GET['id'] ?? null;
        $controller = new CarritoController();
        $controller->agregar($id);
        break;

    case 'ver_carrito':
        $controller = new CarritoController();
        $controller->verCarrito();
        break;

    case 'eliminar_carrito':
        $id = $_GET['id'] ?? null;
        $controller = new CarritoController();
        $controller->eliminar($id);
        break;

    case 'vaciar_carrito':
        $controller = new CarritoController();
        $controller->vaciar();
        break;

    case 'aumentar_carrito':
        $id = $_GET['id'] ?? null;
        $controller = new CarritoController();
        $controller->aumentar($id);
        break;

    case 'disminuir_carrito':
        $id = $_GET['id'] ?? null;
        $controller = new CarritoController();
        $controller->disminuir($id);
        break;

    case 'checkout':
        $controller = new CheckoutController();
        $controller->mostrarCheckout();
        break;

    case 'procesar_pago':
        $controller = new CheckoutController();
        $controller->procesarPago();
        break;

    case 'confirmacion':
        $controller = new CheckoutController();
        $controller->confirmacion();
        break;

    default:
        $controller = new ProductoController();
        $controller->mostrarCatalogo();
        break;
}
?>