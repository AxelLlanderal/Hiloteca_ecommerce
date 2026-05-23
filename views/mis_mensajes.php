<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis mensajes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="bg-light">

<header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h1>Mis mensajes</h1>

        <a href="index.php?accion=contacto" class="btn btn-success">Nuevo Mensaje</a>

        <a href="index.php" class="btn btn-warning">
            Volver al catálogo
        </a>
    </div>
</header>

<main class="container">

    <?php if (empty($mensajes)): ?>

        <div class="alert alert-info text-center">
            No tienes mensajes registrados.
        </div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($mensajes as $mensaje): ?>

                <div class="col-md-6">
                    <div class="card shadow h-100">

                        <div class="card-header d-flex justify-content-between">
                            <strong><?php echo htmlspecialchars($mensaje['asunto']); ?></strong>

                            <?php if ($mensaje['estado'] == 'respondido'): ?>
                                <span class="badge bg-success">Respondido</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Nuevo</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body">
                            <p class="text-muted mb-1">
                                Fecha: <?php echo $mensaje['fecha']; ?>
                            </p>

                            <p>
                                <strong>Tu mensaje:</strong><br>
                                <?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?>
                            </p>

                            <hr>

                            <?php if (!empty($mensaje['respuesta'])): ?>
                                <p>
                                    <strong>Respuesta del administrador:</strong><br>
                                    <?php echo nl2br(htmlspecialchars($mensaje['respuesta'])); ?>
                                </p>
                            <?php else: ?>
                                <p class="text-muted">
                                    Aún no hay respuesta del administrador.
                                </p>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</main>

</body>
</html>