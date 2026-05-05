<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header class="bg-dark text-white py-2 mb-4">
    <div class="container d-flex align-items-center justify-content-between">
        <img src="img/Logo_azul_Letras_blancas_complementos.png" class="logo" alt="Hiloteca">

        <h1 class="m-0 text-center flex-grow-1">Carrito de Compras</h1>

        <img src="img/Logo_blanco_Letras_azul_obscuro_complementos.png" class="logo" alt="Hiloteca">
    </div>
</header>

<main class="container">

    <a href="index.php" class="btn btn-secondary mb-4">
        ← Volver a Hiloteca
    </a>

    <?php if (empty($carrito)): ?>

        <div class="alert alert-info text-center">
            El carrito está vacío.
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center bg-white shadow">
                <thead class="table-dark">
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $total = 0;
                    foreach ($carrito as $item):
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                    ?>

                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>"
                                 class="img-carrito"
                                 alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                        </td>

                        <td><?php echo htmlspecialchars($item['nombre']); ?></td>

                        <td>$<?php echo number_format($item['precio'], 2); ?></td>

                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">

                                <a href="index.php?accion=disminuir_carrito&id=<?php echo $item['id']; ?>"
                                class="btn btn-outline-secondary btn-sm">
                                    -
                                </a>

                                <span class="fw-bold">
                                    <?php echo $item['cantidad']; ?>
                                </span>

                                <a href="index.php?accion=aumentar_carrito&id=<?php echo $item['id']; ?>"
                                class="btn btn-outline-primary btn-sm">
                                    +
                                </a>

                            </div>
                        </td>

                        <td>
                            <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                        </td>

                        <td>
                            <a href="index.php?accion=eliminar_carrito&id=<?php echo $item['id']; ?>"
                               class="btn btn-danger btn-sm">
                                Eliminar
                            </a>
                        </td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">
                            <strong>Total:</strong>
                        </td>
                        <td colspan="2" class="precio">
                            $<?php echo number_format($total, 2); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
            
        <div class="d-flex justify-content-between mt-4">

            <a href="index.php" class="btn btn-secondary">
                ← Seguir comprando
            </a>

            <div>
                <a href="index.php?accion=vaciar_carrito" class="btn btn-warning me-2">
                    Vaciar carrito
                </a>

                <a href="index.php?accion=checkout" class="btn btn-success">
                    Finalizar compra
                </a>
            </div>

        </div>

    <?php endif; ?>

</main>

<footer class="bg-dark text-white text-center py-3 mt-5">
    Hiloteca - Apuntes digitales educativos
</footer>

</body>
</html>