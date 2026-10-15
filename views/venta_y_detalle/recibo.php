<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recibo de venta #<?= (int) $venta->IdVenta ?> | Café Aroma</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body class="recibo-page">
    <main class="recibo">
        <header class="recibo-header">
            <p class="recibo-marca">CA</p>
            <h1>Café Aroma</h1>
            <p>Un buen día empieza aquí.</p>
        </header>

        <h2>Recibo de compra</h2>
        <p><strong>Folio:</strong> #<?= (int) $venta->IdVenta ?></p>
        <p><strong>Fecha:</strong> <?= htmlspecialchars($venta->FechaVenta, ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Cliente:</strong>
            <?= $venta->ClienteNombres
                ? htmlspecialchars($venta->ClienteNombres . ' ' . $venta->ClienteApellidos, ENT_QUOTES, 'UTF-8')
                : 'Público general' ?>
        </p>

        <table>
            <thead>
                <tr><th>Producto</th><th>Cant.</th><th>Precio</th><th>Importe</th></tr>
            </thead>
            <tbody>
                <?php while ($detalle = $detalles->fetch_object()): ?>
                    <tr>
                        <td><?= htmlspecialchars($detalle->NombreProducto, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $detalle->Cantidad ?></td>
                        <td>$<?= number_format((float) $detalle->PrecioUnitario, 2) ?></td>
                        <td>$<?= number_format((float) $detalle->SubTotal, 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="3">Total</th><th>$<?= number_format((float) $venta->Total, 2) ?> MXN</th></tr>
            </tfoot>
        </table>

        <p class="recibo-gracias">¡Gracias por tu compra! Esperamos verte pronto.</p>
        <div class="recibo-actions">
            <button type="button" onclick="window.print()">Imprimir recibo</button>
            <a href="index.php?controlador=venta&accion=comprar">Hacer otra compra</a>
            <a href="cafeteria.html">Volver al inicio</a>
        </div>
    </main>
</body>
</html>
