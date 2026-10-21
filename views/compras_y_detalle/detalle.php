<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de compra #<?= (int) $compra->IdCompra ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body class="compra-page">
    <div class="section-wrap">

        <h1 style="text-align: center;">Detalle de compra #<?= (int) $compra->IdCompra ?></h1>
        
        <div class="recibo-info">
            <p><strong>Proveedor:</strong> <?= htmlspecialchars($compra->NombreProveedor, ENT_QUOTES, 'UTF-8') ?> |
               <strong>Fecha:</strong> <?= htmlspecialchars($compra->FechaCompra, ENT_QUOTES, 'UTF-8') ?> |
               <strong>Total:</strong> <?= number_format((float) $compra->Total, 2) ?></p>
        </div>

        <?php if (($_GET['error'] ?? '') === 'datos'): ?>
            <p role="alert" style="text-align: center; color: var(--orange);">Selecciona un producto válido y verifica la cantidad y el precio.</p>
        <?php endif; ?>

        <h2 style="text-align: center;">Agregar artículo</h2>
        <form method="POST" action="index.php?controlador=compra&accion=agregarDetalle&id=<?= (int) $compra->IdCompra ?>">
            <label for="id_producto">Producto:</label>
            <select id="id_producto" name="id_producto" required>
                <option value="">Selecciona un producto</option>
                <?php foreach ($productos as $idProducto => $producto): ?>
                    <option value="<?= (int) $idProducto ?>"><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?> - $<?= number_format((float) $producto['precio'], 2) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" required>

            <label for="precio_unitario">Precio unitario:</label>
            <input type="number" id="precio_unitario" name="precio_unitario" min="0" step="0.01" required>

            <button type="submit">Agregar detalle</button>
        </form>

        <h2 style="text-align: center;">Artículos</h2>
        <table>
            <tr><th>Producto</th><th>Cantidad</th><th>Precio unitario</th><th>Subtotal</th><th>Acciones</th></tr>
            <?php while ($detalle = $detalles->fetch_object()): ?>
            <tr>
                <td><?= htmlspecialchars($detalle->NombreProducto, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) $detalle->Cantidad ?></td>
                <td><?= number_format((float) $detalle->PrecioUnitario, 2) ?></td>
                <td><?= number_format((float) $detalle->SubTotal, 2) ?></td>
                <td>
                    <a href="index.php?controlador=compra&accion=editarDetalle&id=<?= (int) $compra->IdCompra ?>&id_detalle=<?= (int) $detalle->IdDetalleCompra ?>">Editar</a>
                    <a href="index.php?controlador=compra&accion=eliminarDetalle&id=<?= (int) $compra->IdCompra ?>&id_detalle=<?= (int) $detalle->IdDetalleCompra ?>"
                       onclick="return confirm('¿Eliminar este detalle?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="index.php?controlador=compra&accion=index" class="button button-dark">Volver a compras</a>
        </div>

    </div>
</body>
</html>