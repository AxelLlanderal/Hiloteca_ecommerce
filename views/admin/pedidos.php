<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="admin-body">

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="admin-title">Consulta de Pedidos</h1>

        <div>
            <a href="index.php?accion=admin_dashboard" class="btn btn-warning">
                Dashboard
            </a>

            <a href="index.php?accion=logout" class="btn btn-outline-light">
                Cerrar sesión
            </a>
        </div>
    </div>
</header>

<main class="container">

    <div class="mb-3">
        <a href="index.php?accion=admin_dashboard" class="btn btn-outline-dark">
            Dashboard
        </a>

        <a href="index.php?accion=admin_productos" class="btn btn-outline-primary">
            Productos
        </a>

        <a href="index.php?accion=admin_inventario" class="btn btn-outline-warning">
            Inventario
        </a>

        <a href="index.php?accion=admin_pedidos" class="btn btn-success">
            Pedidos
        </a>

        <a href="index.php?accion=admin_reportes" class="btn btn-outline-info">
            Reportes
        </a>

        <a href="index.php?accion=admin_mensajes" class="btn btn-outline-secondary">
            Mensajes
        </a>
    </div>

    <?php if (empty($pedidos)): ?>

        <div class="alert alert-info text-center">
            No hay pedidos registrados.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white shadow text-center align-middle table-admin">
                <thead class="table-dark">
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Método de pago</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Cambiar estado</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td>#<?php echo $pedido['id']; ?></td>

                            <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>

                            <td><?php echo htmlspecialchars($pedido['email']); ?></td>

                            <td>
                                <strong>
                                    $<?php echo number_format($pedido['total'], 2); ?>
                                </strong>
                            </td>

                            <td><?php echo htmlspecialchars($pedido['metodo_pago']); ?></td>

                            <td>
                                <?php if ($pedido['estado'] == 'pagado'): ?>
                                    <span class="badge bg-success">Pagado</span>
                                <?php elseif ($pedido['estado'] == 'pendiente'): ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php elseif ($pedido['estado'] == 'enviado'): ?>
                                    <span class="badge bg-primary">Enviado</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Cancelado</span>
                                <?php endif; ?>
                            </td>

                            <td><?php echo $pedido['fecha_creacion']; ?></td>

                            <td>
                                <form action="index.php?accion=admin_pedido_estado" method="POST" class="d-flex gap-2 justify-content-center">
                                    <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">

                                    <select name="estado" class="form-select form-select-sm" style="width: 130px;">
                                        <option value="pendiente" <?php echo ($pedido['estado'] == 'pendiente') ? 'selected' : ''; ?>>
                                            Pendiente
                                        </option>

                                        <option value="pagado" <?php echo ($pedido['estado'] == 'pagado') ? 'selected' : ''; ?>>
                                            Pagado
                                        </option>

                                        <option value="enviado" <?php echo ($pedido['estado'] == 'enviado') ? 'selected' : ''; ?>>
                                            Enviado
                                        </option>

                                        <option value="cancelado" <?php echo ($pedido['estado'] == 'cancelado') ? 'selected' : ''; ?>>
                                            Cancelado
                                        </option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Guardar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
    <?php if (isset($_GET['estado']) && $_GET['estado'] == 'ok'): ?>

    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        ✅ El estado del pedido fue actualizado correctamente.
        
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <?php endif; ?>

    <?php if (isset($_GET['estado']) && $_GET['estado'] == 'error'): ?>

        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            ❌ No se pudo actualizar el estado del pedido.
            
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    <?php endif; ?>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>