<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Movimiento inventario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body class="admin-body">

<header class="admin-header">

    <div class="container d-flex justify-content-between align-items-center">

        <div>

            <h1 class="admin-title">
                Movimiento de inventario
            </h1>

            <p class="mb-0 text-light opacity-75">
                Registrar entrada o salida
            </p>

        </div>

        <a href="index.php?accion=admin_inventario" class="btn btn-warning">
            Volver
        </a>

    </div>

</header>

<main class="container">

    <?php if (!$producto): ?>

        <div class="alert alert-danger text-center">
            Producto no encontrado.
        </div>

    <?php else: ?>

        <div class="card admin-card p-4">

            <h4>
                <?php echo htmlspecialchars($producto['nombre']); ?>
            </h4>

            <p>
                <strong>Stock actual:</strong>

                <?php echo $producto['stock_final']; ?>
            </p>

            <p>
                <strong>Stock mínimo:</strong>

                <?php echo $producto['stock_minimo']; ?>
            </p>

            <p>
                <strong>Ubicación:</strong>

                <?php echo htmlspecialchars($producto['ubicacion']); ?>
            </p>

            <form action="index.php?accion=admin_inventario_guardar_movimiento" method="POST">

                <input type="hidden"
                       name="producto_id"
                       value="<?php echo $producto['producto_id']; ?>">

                <div class="mb-3">

                    <label class="form-label">
                        Tipo de movimiento
                    </label>

                    <select name="tipo_movimiento" class="form-select" required>

                        <option value="">
                            Seleccione
                        </option>

                        <option value="entrada">
                            Entrada
                        </option>

                        <option value="salida">
                            Salida
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Cantidad
                    </label>

                    <input type="number"
                           name="cantidad"
                           class="form-control"
                           min="1"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Motivo
                    </label>

                    <input type="text"
                           name="motivo"
                           class="form-control"
                           placeholder="Compra proveedor, ajuste, devolución..."
                           required>

                </div>

                <button type="submit" class="btn btn-success">
                    Guardar movimiento
                </button>

                <a href="index.php?accion=admin_inventario"
                   class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    <?php endif; ?>

</main>

</body>
</html>