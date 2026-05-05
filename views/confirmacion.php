<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra confirmada</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4 text-center" style="width: 450px;">

        <?php if ($pedido_id): ?>
            <h2 class="text-success">Compra realizada correctamente</h2>
            <p>Tu pago fue aprobado.</p>
            <p>Número de pedido:</p>
            <h3>#<?php echo $pedido_id; ?></h3>
        <?php else: ?>
            <h2 class="text-danger">No se encontró información del pedido</h2>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary mt-3">
            Volver al catálogo
        </a>

    </div>

</div>

</body>
</html>