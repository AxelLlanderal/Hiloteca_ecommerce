<?php
/*
| INICIAR SESIÓN Y CONTAR PRODUCTOS EN CARRITO
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$totalCarrito = 0;

if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $totalCarrito += $item['cantidad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>

    <!-- BOOTSTRAP Y ESTILOS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<!-- HEADER -->
<header class="bg-dark text-white py-2 mb-4">
    <div class="container d-flex align-items-center justify-content-between">
        <img src="img/Logo_azul_Letras_blancas_complementos.png" class="logo" alt="Hiloteca">

        <h1 class="titulo-hiloteca flex-grow-1 text-center">Hiloteca</h1>

        <div class="d-flex align-items-center gap-3">

            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="usuario-texto">
                    Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>
                </span>

                <a href="index.php?accion=logout" class="btn btn-outline-warning btn-sm">
                    Cerrar sesión
                </a>
            <?php else: ?>
                <a href="index.php?accion=login" class="btn btn-outline-light btn-sm">
                    Iniciar sesión
                </a>

                <a href="index.php?accion=registro" class="btn btn-outline-success btn-sm">
                    Registrarse
                </a>
            <?php endif; ?>

            <!-- BOTÓN CARRITO -->
            <a href="index.php?accion=ver_carrito" class="btn btn-outline-light position-relative">
                🛒 Ver carrito

                <?php if ($totalCarrito > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $totalCarrito; ?>
                    </span>
                <?php endif; ?>
            </a>

            <img src="img/Logo_blanco_Letras_azul_obscuro_complementos.png" class="logo" alt="Hiloteca">
        </div>
    </div>
</header>

<main class="container">

    <!-- MENSAJES -->
    <?php if (isset($_GET['agregado'])): ?>
        <div class="alert alert-success text-center">
            Producto agregado al carrito 🛒
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['stock']) && $_GET['stock'] == 'limite'): ?>
        <div class="alert alert-warning text-center">
            Stock máximo alcanzado.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['compra']) && $_GET['compra'] == 'ok'): ?>
        <div class="alert alert-success text-center">
            Compra realizada con éxito 🎉
        </div>
    <?php endif; ?>

    <!-- LISTA DE PRODUCTOS -->
    <div class="row g-4">

        <?php foreach ($productos as $producto): ?>

            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow">

                    <!-- IMAGEN -->
                    <img src="<?php echo htmlspecialchars($producto['imagen']); ?>"
                         class="card-img-top producto-img"
                         alt="<?php echo htmlspecialchars($producto['nombre']); ?>">

                    <div class="card-body d-flex flex-column text-center">

                        <!-- NOMBRE -->
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($producto['nombre']); ?>
                        </h5>

                        <!-- DESCRIPCIÓN -->
                        <p class="card-text">
                            <?php echo htmlspecialchars($producto['descripcion']); ?>
                        </p>

                        <!-- STOCK -->
                        <p class="text-muted small">
                            Stock:
                            <strong class="<?php echo (($producto['stock_final'] ?? 0) <= 5) ? 'text-danger' : 'text-success'; ?>">
                                <?php echo $producto['stock_final'] ?? 0; ?>
                            </strong>
                        </p>

                        <div class="mt-auto">

                            <!-- PRECIO -->
                            <p class="precio">
                                $<?php echo number_format($producto['precio'], 2); ?>
                            </p>

                            <!-- BOTÓN CARRITO -->
                            <?php if (($producto['stock_final'] ?? 0) > 0): ?>

                                <a href="index.php?accion=agregar_carrito&id=<?php echo $producto['id']; ?>"
                                   class="btn btn-primary w-100">
                                    Agregar al carrito
                                </a>

                            <?php else: ?>

                                <button class="btn btn-secondary w-100 fw-bold" disabled>
                                    ❌ Agotado
                                </button>

                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</main>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    Hiloteca - Apuntes digitales educativos
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>