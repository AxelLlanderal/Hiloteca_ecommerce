<?php
/*
| CONTROLADOR ADMIN REPORTES
*/

require_once __DIR__ . '/../config/db.php';

class ReporteAdminController {

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
    | MOSTRAR REPORTES
    */
    public function index() {
        $this->validarAdmin();

        global $conexion;

        $ventasTotales = $conexion->query("
            SELECT IFNULL(SUM(total),0)
            FROM pedidos
            WHERE estado = 'pagado'
        ")->fetchColumn();

        $productosMasVendidos = $conexion->query("
            SELECT 
                nombre_producto,
                SUM(cantidad) AS total_vendido
            FROM detalle_pedido
            GROUP BY producto_id
            ORDER BY total_vendido DESC
            LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);

        $clientesFrecuentes = $conexion->query("
            SELECT 
                u.nombre,
                COUNT(p.id) AS total_pedidos,
                SUM(p.total) AS total_compras
            FROM pedidos p
            INNER JOIN usuarios u ON p.usuario_id = u.id
            GROUP BY u.id
            ORDER BY total_compras DESC
            LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/reportes.php';
    }
}
?>