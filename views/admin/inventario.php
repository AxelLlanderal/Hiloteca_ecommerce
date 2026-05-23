<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body class="admin-body">

<header class="admin-header">

    <div class="container d-flex justify-content-between align-items-center">

        <div>
            <h1 class="admin-title">Gestión de Inventario</h1>

            <p class="mb-0 text-light opacity-75">
                Control de entradas y salidas
            </p>
        </div>

        <a href="index.php?accion=logout" class="btn btn-warning">
            Cerrar sesión
        </a>

    </div>

</header>

<main class="container-fluid px-5">

    <nav class="admin-nav">

        <a href="index.php?accion=admin_dashboard" class="btn btn-outline-dark">
            Dashboard
        </a>

        <a href="index.php?accion=admin_productos" class="btn btn-outline-primary">
            Productos
        </a>

        <a href="index.php?accion=admin_inventario" class="btn btn-warning">
            Inventario
        </a>

        <a href="index.php?accion=admin_pedidos" class="btn btn-outline-success">
            Pedidos
        </a>

        <a href="index.php?accion=admin_reportes" class="btn btn-outline-info">
            Reportes
        </a>

        <a href="index.php?accion=admin_mensajes" class="btn btn-outline-secondary">
            Mensajes
        </a>
        

    </nav>

    <?php if (isset($_GET['error'])): ?>

        <div class="alert alert-danger text-center">
            No se pudo realizar el movimiento.
        </div>

    <?php endif; ?>

    <div class="table-responsive">

        <table class="table table-bordered table-hover bg-white shadow text-center align-middle table-admin">

            <thead>

                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Stock inicial</th>
                    <th>Stock actual</th>
                    <th>Stock mínimo</th>
                    <th>Ubicación</th>
                    <th>Alerta</th>
                    <th>Actualización</th>
                    <th>Movimiento</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($inventario as $item): ?>

                    <tr>

                        <td>
                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" width="70">
                        </td>

                        <td>
                            <?php echo htmlspecialchars($item['nombre']); ?>
                        </td>

                        <td>
                            <?php echo $item['stock_inicial']; ?>
                        </td>

                        <td>

                            <strong class="<?php echo ($item['stock_final'] <= $item['stock_minimo']) ? 'text-danger' : 'text-success'; ?>">

                                <?php echo $item['stock_final']; ?>

                            </strong>

                        </td>

                        <td>
                            <?php echo $item['stock_minimo']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($item['ubicacion']); ?>
                        </td>

                        <td>

                            <?php if ($item['stock_final'] <= $item['stock_minimo']): ?>

                                <span class="badge bg-danger">
                                    Stock bajo
                                </span>

                            <?php else: ?>

                                <span class="badge bg-success">
                                    Normal
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>
                            <?php echo $item['fecha_actualizacion']; ?>
                        </td>

                        <td>

                            <a href="index.php?accion=admin_inventario_movimiento&producto_id=<?php echo $item['producto_id']; ?>"
                               class="btn btn-primary btn-sm">

                                Entrada / Salida

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</main>

</body>
</html>