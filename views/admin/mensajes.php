<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes de clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="admin-body">

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="admin-title">Mensajes de clientes</h1>
            <p class="mb-0 text-light opacity-75">Atención y seguimiento a clientes</p>
        </div>

        <a href="index.php?accion=logout" class="btn btn-warning">
            Cerrar sesión
        </a>
    </div>
</header>

<main class="container-fluid px-5">

    <nav class="admin-nav">
        <a href="index.php?accion=admin_dashboard" class="btn btn-outline-dark">Dashboard</a>
        <a href="index.php?accion=admin_productos" class="btn btn-outline-primary">Productos</a>
        <a href="index.php?accion=admin_inventario" class="btn btn-outline-warning">Inventario</a>
        <a href="index.php?accion=admin_pedidos" class="btn btn-outline-success">Pedidos</a>
        <a href="index.php?accion=admin_reportes" class="btn btn-outline-info">Reportes</a>
        <a href="index.php?accion=admin_mensajes" class="btn btn-secondary btn-sm">Ver mensajes</a>
    </nav>

    <?php if (empty($mensajes)): ?>

        <div class="alert alert-info text-center">
            No hay mensajes registrados.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white shadow text-center align-middle table-admin">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Correo</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
                        <th>Responder</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($mensajes as $fila): ?>
                        <tr>
                            <td><?php echo $fila['fecha']; ?></td>
                            <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                            <td><?php echo htmlspecialchars($fila['asunto']); ?></td>

                            <td style="max-width: 280px;">
                                <?php echo nl2br(htmlspecialchars($fila['mensaje'])); ?>
                            </td>

                            <td>
                                <?php if ($fila['estado'] == 'respondido'): ?>
                                    <span class="badge bg-success">Respondido</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Nuevo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="index.php?accion=admin_responder_mensaje&id=<?php echo $fila['id']; ?>"
                                   class="btn btn-warning btn-sm">
                                    <?php echo ($fila['estado'] == 'respondido') ? 'Ver respuesta' : 'Responder'; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</main>

</body>
</html>