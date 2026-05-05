<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finalizar compra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="bg-light">

<header class="bg-dark text-white py-2 mb-4">
    <div class="container d-flex align-items-center justify-content-between">
        <img src="img/Logo_azul_Letras_blancas_complementos.png" class="logo">

        <h1 class="m-0 text-center flex-grow-1">Finalizar compra</h1>

        <img src="img/Logo_blanco_Letras_azul_obscuro_complementos.png" class="logo">
    </div>
</header>

<main class="container">

    <a href="index.php?accion=ver_carrito" class="btn btn-secondary mb-4">
        ← Regresar al carrito
    </a>

    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            Resumen de compra
        </div>

        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($carrito as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                            <td>$<?php echo number_format($item['precio'], 2); ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">
                            <strong>Total a pagar:</strong>
                        </td>
                        <td class="precio">
                            $<?php echo number_format($total, 2); ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Simulación de pago
        </div>

        <div class="card-body">

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?accion=procesar_pago" method="POST">

                <div class="mb-3">
                    <label class="form-label">Método de pago</label>
                    <select name="metodo_pago" class="form-select" required>
                        <option value="">Seleccione</option>
                        <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                        <option value="Tarjeta de débito">Tarjeta de débito</option>
                        <option value="PayPal simulado">PayPal simulado</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Número de tarjeta</label>
                    <input type="tel" 
                        name="numero_tarjeta" 
                        maxlength="16" 
                        class="form-control" 
                        placeholder="1234567812345678" 
                        autocomplete="off"
                        inputmode="numeric"
                        pattern="[0-9]{16}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">CVV</label>
                    <input type="tel" 
                    name="cvv" 
                    maxlength="3" 
                    class="form-control" 
                    placeholder="123" 
                    autocomplete="off"
                    inputmode="numeric"
                    pattern="[0-9]{3}"
                    required>
                <br></br>
                <button type="submit" class="btn btn-success w-100">
                    Pagar ahora
                </button>

            </form>
        </div>
    </div>

</main>

</body>
</html>