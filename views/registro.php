<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4" style="width: 400px;">

        <h3 class="text-center mb-4">Registro de cliente</h3>

        <!-- MENSAJES -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="index.php?accion=guardar_usuario" method="POST">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Registrarme
            </button>
        </form>

        <p class="text-center mt-3">
            ¿Ya tienes cuenta?
            <a href="index.php?accion=login">Inicia sesión</a>
        </p>

    </div>

</div>

</body>
</html>