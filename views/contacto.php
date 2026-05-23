<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombre = '';
$correo = '';
$usuarioLogeado = false;

if (isset($_SESSION['usuario'])) {

    $usuarioLogeado = true;

    $nombre = $_SESSION['usuario']['nombre'] ?? '';
    $correo = $_SESSION['usuario']['email'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Atención a clientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4" style="width: 600px;">

        <h2 class="text-center mb-3">
            Atención a clientes
        </h2>

        <p class="text-center text-muted">
            Envíanos tu duda, queja o comentario.
        </p>

        <form action="index.php?accion=guardar_mensaje" method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nombre
                </label>

                <input type="text"
                       name="nombre"
                       class="form-control"
                       required
                       value="<?php echo htmlspecialchars($nombre); ?>"

                       <?php echo $usuarioLogeado ? 'readonly' : ''; ?>>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Correo
                </label>

                <input type="email"
                       name="correo"
                       class="form-control"
                       required
                       value="<?php echo htmlspecialchars($correo); ?>"

                       <?php echo $usuarioLogeado ? 'readonly' : ''; ?>>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Asunto
                </label>

                <input type="text"
                       name="asunto"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Mensaje
                </label>

                <textarea name="mensaje"
                          class="form-control"
                          rows="5"
                          required></textarea>

            </div>

            <div class="d-flex justify-content-between">

                <a href="index.php" class="btn btn-secondary">
                    Volver
                </a>

                <button type="submit" class="btn btn-primary">
                    Enviar mensaje
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>