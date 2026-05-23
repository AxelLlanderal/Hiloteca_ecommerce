<?php
/*
| CONTROLADOR ADMIN PEDIDOS
*/

require_once __DIR__ . '/../models/Pedido.php';

class PedidoAdminController {

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
    | LISTAR PEDIDOS
    */
    public function index() {
        $this->validarAdmin();

        $pedidos = Pedido::obtenerTodosAdmin();

        require __DIR__ . '/../views/admin/pedidos.php';
    }

    /*
    | CAMBIAR ESTADO
    */
    public function cambiarEstado() {
        $this->validarAdmin();

        $id = $_POST['id'] ?? null;
        $estado = $_POST['estado'] ?? 'pendiente';

        $actualizado = Pedido::actualizarEstado($id, $estado);

        if ($actualizado) {

            header("Location: index.php?accion=admin_pedidos&estado=ok");

        } else {

            header("Location: index.php?accion=admin_pedidos&estado=error");

        }

        exit;
    }
}
?>