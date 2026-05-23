<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Administrar Productos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/estilo.css">
    </head>
    <body class="admin-body">

        <header class="admin-header">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="admin-title">Gestión de Productos</h1>
                <a href="index.php?accion=admin_dashboard" class="btn btn-warning">Dashboard</a>
            </div>
        </header>

        <main class="container">
            <nav class="admin-nav">
                <a href="index.php?accion=admin_dashboard" class="btn btn-outline-dark">Dashboard</a>
                <a href="index.php?accion=admin_productos" class="btn btn-primary">Productos</a>
                <a href="index.php?accion=admin_inventario" class="btn btn-outline-warning">Inventario</a>
                <a href="index.php?accion=admin_pedidos" class="btn btn-outline-success">Pedidos</a>
                <a href="index.php?accion=admin_reportes" class="btn btn-outline-info">Reportes</a>
                <a href="index.php?accion=admin_mensajes" class="btn btn-outline-secondary btn-sm">Ver mensajes</a>
            </nav>

            <a href="index.php?accion=admin_producto_nuevo" class="btn btn-success mb-3">
                + Nuevo producto
            </a>

            <table class="table table-bordered table-hover bg-white shadow text-center align-middle table-admin">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Stock final</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['id']; ?></td>

                            <td>
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" width="70">
                            </td>

                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>

                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>

                            <td>
                                <strong class="<?php echo ($producto['stock_final'] <= 5) ? 'text-danger' : 'text-success'; ?>">
                                    <?php echo $producto['stock_final']; ?>
                                </strong>
                            </td>

                            <td>
                                <?php if ($producto['estado'] == 'activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="index.php?accion=admin_producto_editar&id=<?php echo $producto['id']; ?>"
                                class="btn btn-primary btn-sm">
                                    Editar
                                </a>

                                <?php if ($producto['estado'] == 'activo'): ?>
                                    <a href="index.php?accion=admin_producto_inactivar&id=<?php echo $producto['id']; ?>"
                                    class="btn btn-danger btn-sm">
                                        Inactivar
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?accion=admin_producto_activar&id=<?php echo $producto['id']; ?>"
                                    class="btn btn-success btn-sm">
                                        Activar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </main>

    </body>
</html>