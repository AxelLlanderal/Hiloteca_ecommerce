<?php
/*
| ARCHIVO PRINCIPAL DE RUTAS
*/

require_once 'controllers/ProductoController.php';
require_once 'controllers/CarritoController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CheckoutController.php';
require_once 'controllers/ProductoAdminController.php';
require_once 'controllers/PedidoAdminController.php';
require_once 'controllers/ReporteAdminController.php';
require_once 'controllers/MensajeController.php';
require_once 'controllers/InventarioAdminController.php';

$accion = $_GET['accion'] ?? 'catalogo';

switch ($accion) {

    /*
    | CATÁLOGO
    */
    case 'catalogo':
        $controller = new ProductoController();
        $controller->mostrarCatalogo();
        break;

    /*
    | AUTENTICACIÓN
    */
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

    /*
    | CARRITO
    */
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

    /*
    | CHECKOUT
    */
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

    /*
    | ADMIN PRODUCTOS
    */
    case 'admin_dashboard':
        $controller = new ProductoAdminController();
        $controller->dashboard();
        break;

    case 'admin_productos':
        $controller = new ProductoAdminController();
        $controller->index();
        break;

    case 'admin_producto_nuevo':
        $controller = new ProductoAdminController();
        $controller->crear();
        break;

    case 'admin_producto_guardar':
        $controller = new ProductoAdminController();
        $controller->guardar();
        break;

    case 'admin_producto_editar':
        $id = $_GET['id'] ?? null;
        $controller = new ProductoAdminController();
        $controller->editar($id);
        break;

    case 'admin_producto_actualizar':
        $controller = new ProductoAdminController();
        $controller->actualizar();
        break;

    case 'admin_producto_inactivar':
        $id = $_GET['id'] ?? null;
        $controller = new ProductoAdminController();
        $controller->inactivar($id);
        break;

    case 'admin_producto_activar':
        $id = $_GET['id'] ?? null;
        $controller = new ProductoAdminController();
        $controller->activar($id);
        break;

    /*
    | ADMIN PEDIDOS
    */
    case 'admin_pedidos':
        $controller = new PedidoAdminController();
        $controller->index();
        break;

    case 'admin_pedido_estado':
        $controller = new PedidoAdminController();
        $controller->cambiarEstado();
        break;

    /*
    | ADMIN REPORTES
    */
    case 'admin_reportes':
        $controller = new ReporteAdminController();
        $controller->index();
        break;

    case 'contacto':
        $controller = new MensajeController();
        $controller->contacto();
        break;

    case 'guardar_mensaje':
        $controller = new MensajeController();
        $controller->guardarMensaje();
        break;

    case 'mensaje_enviado':
        $controller = new MensajeController();
        $controller->mensajeEnviado();
        break;

    case 'admin_mensajes':
        $controller = new MensajeController();
        $controller->adminMensajes();
        break;

    case 'admin_responder_mensaje':
        $id = $_GET['id'] ?? null;
        $controller = new MensajeController();
        $controller->responderMensaje($id);
        break;

    case 'admin_guardar_respuesta':
        $controller = new MensajeController();
        $controller->guardarRespuesta();
        break;

    case 'mis_mensajes':
        $controller = new MensajeController();
        $controller->misMensajes();
        break;
    case 'admin_inventario':
        $controller = new InventarioAdminController();
        $controller->index();
        break;

    case 'admin_inventario_movimiento':
        $controller = new InventarioAdminController();
        $controller->movimientoForm();
        break;

    case 'admin_inventario_guardar_movimiento':
        $controller = new InventarioAdminController();
        $controller->guardarMovimiento();
        break;
    /*
    | RUTA POR DEFECTO
    */
    default:
        $controller = new ProductoController();
        $controller->mostrarCatalogo();
        break;
}
?>