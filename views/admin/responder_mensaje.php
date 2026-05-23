<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder mensaje</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="admin-body">

<header class="admin-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="admin-title">Responder mensaje</h1>
            <p class="mb-0 text-light opacity-75">Atención a clientes</p>
        </div>

        <a href="index.php?accion=admin_mensajes" class="btn btn-warning">
            Volver
        </a>
    </div>
</header>

<main class="container">

    <?php if (!$mensaje): ?>

        <div class="alert alert-danger text-center">
            Mensaje no encontrado.
        </div>

    <?php else: ?>

        <div class="card admin-card p-4 mb-4">
            <h4><?php echo htmlspecialchars($mensaje['asunto']); ?></h4>

            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($mensaje['nombre']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($mensaje['correo']); ?></p>
            <p><strong>Mensaje:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?></p>
        </div>

        <div class="card admin-card p-4">
            <form action="index.php?accion=admin_guardar_respuesta" method="POST">

                <input type="hidden" name="id" value="<?php echo $mensaje['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Respuesta</label>
                    <textarea name="respuesta" class="form-control" rows="5" required><?php echo htmlspecialchars($mensaje['respuesta'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    Guardar respuesta
                </button>

                <a href="index.php?accion=admin_mensajes" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>
        </div>

    <?php endif; ?>

</main>

</body>
</html>