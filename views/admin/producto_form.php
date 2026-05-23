<?php
$editando = isset($producto) && $producto;
$accionForm = $editando ? 'admin_producto_actualizar' : 'admin_producto_guardar';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editando ? 'Editar producto' : 'Nuevo producto'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="admin-body">

<header class="admin-header">
    <div class="container">
        <h1><?php echo $editando ? 'Editar producto' : 'Nuevo producto'; ?></h1>
    </div>
</header>

<main class="container">

    <a href="index.php?accion=admin_productos" class="btn btn-secondary mb-3">
        ← Volver
    </a>

    <div class="card admin-card p-4">

        <form action="index.php?accion=<?php echo $accionForm; ?>" method="POST">

            <?php if ($editando): ?>
                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required
                       value="<?php echo $editando ? htmlspecialchars($producto['nombre']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required><?php echo $editando ? htmlspecialchars($producto['descripcion']) : ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" required
                       value="<?php echo $editando ? $producto['precio'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="text" name="imagen" class="form-control" required
                       value="<?php echo $editando ? htmlspecialchars($producto['imagen']) : ''; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <input type="text" name="categoria" class="form-control" required
                       value="<?php echo $editando ? htmlspecialchars($producto['categoria']) : ''; ?>">
            </div>

            <?php if (!$editando): ?>
                <div class="mb-3">
                    <label class="form-label">Stock inicial</label>
                    <input type="number" name="stock_inicial" class="form-control" min="0" required>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100">
                Guardar
            </button>

        </form>

    </div>

</main>

</body>
</html>