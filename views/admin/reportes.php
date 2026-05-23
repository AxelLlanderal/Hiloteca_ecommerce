<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="admin-body">

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="admin-title">Reportes de Ventas</h1>

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

    <div class="mb-4">
        <a href="index.php?accion=admin_dashboard" class="btn btn-outline-dark">Dashboard</a>
        <a href="index.php?accion=admin_productos" class="btn btn-outline-primary">Productos</a>
        <a href="index.php?accion=admin_inventario" class="btn btn-outline-warning">Inventario</a>
        <a href="index.php?accion=admin_pedidos" class="btn btn-outline-success">Pedidos</a>
        <a href="index.php?accion=admin_reportes" class="btn btn-info">Reportes</a>
        <a href="index.php?accion=admin_mensajes" class="btn btn-outline-secondary btn-sm">Ver mensajes</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <h5>Ventas totales pagadas</h5>
            <h2 class="text-success">
                $<?php echo number_format($ventasTotales, 2); ?>
            </h2>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    Productos más vendidos
                </div>

                <div class="card-body">
                    <?php if (empty($productosMasVendidos)): ?>
                        <p class="text-muted text-center">No hay productos vendidos.</p>
                    <?php else: ?>
                        <table class="table table-bordered text-center align-middle table-admin">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Unidades vendidas</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($productosMasVendidos as $producto): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                                        <td>
                                            <strong><?php echo $producto['total_vendido']; ?></strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    Clientes frecuentes
                </div>

                <div class="card-body">
                    <?php if (empty($clientesFrecuentes)): ?>
                        <p class="text-muted text-center">No hay clientes con compras.</p>
                    <?php else: ?>
                        <table class="table table-bordered text-center align-middle table-admin">
                            <thead class="table-dark">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Pedidos</th>
                                    <th>Total comprado</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($clientesFrecuentes as $cliente): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                        <td><?php echo $cliente['total_pedidos']; ?></td>
                                        <td>
                                            <strong>
                                                $<?php echo number_format($cliente['total_compras'], 2); ?>
                                            </strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</main>

</body>
</html>