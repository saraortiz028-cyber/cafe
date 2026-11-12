<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recibo de compra | Café Aroma</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body class="recibo-page">

    <main class="recibo">

        <header class="recibo-header">
            <p class="recibo-marca">CA</p>
            <h1>Café Aroma</h1>
            <p>Un buen día empieza aquí.</p>
        </header>

        <h2>Recibo de compra</h2>

        <p>
            <strong>Folio:</strong>
            #<?= (int) $venta->IdVenta ?>
        </p>

        <p>
            <strong>Fecha:</strong>
            <?= htmlspecialchars($venta->FechaVenta, ENT_QUOTES, 'UTF-8') ?>
        </p>

        <p>
            <strong>Cliente:</strong>
            Público general
        </p>

        <p>
            <strong>Sucursal:</strong>
            <?= htmlspecialchars($venta->NombreSucursal, ENT_QUOTES, 'UTF-8') ?>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th>Importe</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars(
                                $detalle['NombreProducto'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= (int) $detalle['Cantidad'] ?>
                        </td>

                        <td>
                            $<?= number_format(
                                (float) $detalle['PrecioUnitario'],
                                2
                            ) ?>
                        </td>

                        <td>
                            $<?= number_format(
                                (float) $detalle['SubTotal'],
                                2
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
    <tr>
        <th colspan="3">Subtotal</th>
        <th>
            $<?= number_format(
                (float) $venta->Total - (float) $venta->IVA,
                2
            ) ?>
        </th>
    </tr>

    <tr>
        <th colspan="3">
            IVA (<?= number_format((float) $venta->TasaIVA, 2) ?>%)
        </th>
        <th>
            $<?= number_format((float) $venta->IVA, 2) ?>
        </th>
    </tr>

    <tr>
        <th colspan="3">Total</th>
        <th>
            $<?= number_format((float) $venta->Total, 2) ?> NIO
        </th>
    </tr>
</tfoot>
        </table>

        <p class="recibo-gracias">
            ¡Gracias por tu compra! Esperamos verte pronto.
        </p>

        <div class="recibo-actions">

    <button type="button" onclick="window.print()">
        Imprimir recibo
    </button>

    <?php if (($_GET['origen'] ?? '') === 'pedido'): ?>

        <a href="index.php?controlador=pedido&accion=index"
           class="button button-dark">
            Volver a pedidos
        </a>

    <?php else: ?>

        <a href="index.php?controlador=publico&accion=productos"
           class="button button-dark">
            Hacer otra compra
        </a>

        <a href="index.php"
           class="button button-dark">
            Volver al inicio
        </a>

    <?php endif; ?>

</div>

    </main>

</body>
</html>