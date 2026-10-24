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
            SIM-<?= date('YmdHis') ?>
        </p>

        <p>
            <strong>Fecha:</strong>
            <?= date('d/m/Y H:i:s') ?>
        </p>

        <p>
            <strong>Cliente:</strong>
            Público general
        </p>

        <!--<p>
            <strong>Tipo:</strong>
            Compra simulada
        </p>-->

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
                    <th colspan="3">Total estimado</th>
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

            <a
    href="index.php?controlador=publico&accion=productos"
    class="button button-dark"
>
    Hacer otra compra
</a>

            <a href="index.php" class="button button-dark">
                Volver al inicio
            </a>

        </div>

    </main>

</body>
</html>