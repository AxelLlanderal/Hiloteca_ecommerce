<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="admin-body">

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="admin-title">Panel Administrativo Hiloteca</h1>
            <p class="mb-0 text-light opacity-75">Resumen general del negocio</p>
        </div>

        <a href="index.php?accion=logout" class="btn btn-warning">
            Cerrar sesión
        </a>
    </div>
</header>

<main class="container-fluid px-5">

    <nav class="admin-nav">
        <a href="index.php?accion=admin_dashboard" class="btn btn-dark">Dashboard</a>
        <a href="index.php?accion=admin_productos" class="btn btn-outline-primary">Productos</a>
        <a href="index.php?accion=admin_inventario" class="btn btn-outline-warning">Inventario</a>
        <a href="index.php?accion=admin_pedidos" class="btn btn-outline-success">Pedidos</a>
        <a href="index.php?accion=admin_reportes" class="btn btn-outline-info">Reportes</a>
        <a href="index.php?accion=admin_mensajes" class="btn btn-outline-secondary btn-sm">Ver mensajes</a>
        

    </nav>

    <div class="row g-4">

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card admin-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Productos activos</p>
                        <h2 class="fw-bold"><?php echo $productosActivos; ?></h2>
                    </div>
                    <div class="stat-icon bg-primary text-white"><i class="bi bi-box-seam"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card admin-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pedidos realizados</p>
                        <h2 class="fw-bold"><?php echo $pedidosRealizados; ?></h2>
                    </div>
                    <div class="stat-icon bg-success text-white"><i class="bi bi-receipt"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card admin-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Ventas totales</p>
                        <h2 class="fw-bold text-success">$<?php echo number_format($ventasTotales, 2); ?></h2>
                    </div>
                    <div class="stat-icon bg-warning text-dark"><i class="bi bi-cash-coin"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card admin-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Clientes registrados</p>
                        <h2 class="fw-bold"><?php echo $clientesRegistrados; ?></h2>
                    </div>
                    <div class="stat-icon bg-info text-white"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card admin-card p-3 border border-danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Stock bajo</p>
                        <h2 class="fw-bold text-danger"><?php echo $stockBajo; ?></h2>
                    </div>
                    <div class="stat-icon bg-danger text-white"><i class="bi bi-exclamation-triangle-fill"></i></div>
                </div>
            </div>
        </div>

    </div>

</main>

</body>
</html>