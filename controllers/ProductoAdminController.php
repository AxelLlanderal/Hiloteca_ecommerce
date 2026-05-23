<?php
/*
| CONTROLADOR ADMIN PRODUCTOS
*/

require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../config/db.php';

class ProductoAdminController {

    /*
    | VALIDAR ADMIN
    */
    private function validarAdmin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] != 'admin') {
            header("Location: index.php?accion=login");
            exit;
        }
    }

    /*
    | DASHBOARD ADMIN
    */
    public function dashboard() {
        $this->validarAdmin();
        global $conexion;

        $productosActivos = $conexion->query("SELECT COUNT(*) FROM productos WHERE estado = 'activo'")->fetchColumn();
        $pedidosRealizados = $conexion->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();
        $ventasTotales = $conexion->query("SELECT IFNULL(SUM(total),0) FROM pedidos WHERE estado IN ('pagado', 'enviado')")->fetchColumn();
        $clientesRegistrados = $conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'cliente'")->fetchColumn();
        $stockBajo = $conexion->query("SELECT COUNT(*) FROM ms_almacen WHERE stock_final <= 5")->fetchColumn();

        require __DIR__ . '/../views/admin/index.php';
    }

    /*
    | LISTAR PRODUCTOS
    */
    public function index() {
        $this->validarAdmin();

        $productos = Producto::obtenerTodosAdmin();

        require __DIR__ . '/../views/admin/productos.php';
    }

    /*
    | FORMULARIO CREAR
    */
    public function crear() {
        $this->validarAdmin();

        $producto = null;

        require __DIR__ . '/../views/admin/producto_form.php';
    }

    /*
    | GUARDAR PRODUCTO
    */
    public function guardar() {
        $this->validarAdmin();

        $nombre = $_POST['nombre'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $imagen = $_POST['imagen'] ?? '';
        $categoria = $_POST['categoria'] ?? '';
        $stockInicial = $_POST['stock_inicial'] ?? 0;

        Producto::crear($nombre, $descripcion, $precio, $imagen, $categoria, $stockInicial);

        header("Location: index.php?accion=admin_productos");
        exit;
    }

    /*
    | FORMULARIO EDITAR
    */
    public function editar($id) {
        $this->validarAdmin();

        $producto = Producto::obtenerPorIdAdmin($id);

        require __DIR__ . '/../views/admin/producto_form.php';
    }

    /*
    | ACTUALIZAR PRODUCTO
    */
    public function actualizar() {
        $this->validarAdmin();

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $imagen = $_POST['imagen'];
        $categoria = $_POST['categoria'];

        Producto::actualizarProducto($id, $nombre, $descripcion, $precio, $imagen, $categoria);

        header("Location: index.php?accion=admin_productos");
        exit;
    }

    /*
    | INACTIVAR PRODUCTO
    */
    public function inactivar($id) {
        $this->validarAdmin();

        Producto::cambiarEstado($id, 'inactivo');

        header("Location: index.php?accion=admin_productos");
        exit;
    }

    /*
    | ACTIVAR PRODUCTO
    */
    public function activar($id) {
        $this->validarAdmin();

        Producto::cambiarEstado($id, 'activo');

        header("Location: index.php?accion=admin_productos");
        exit;
    }
}
?>