<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de compra #<?= (int) $compra->IdCompra ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1>Detalle de compra #<?= (int) $compra->IdCompra ?></h1>
    <p>Proveedor: <?= htmlspecialchars($compra->NombreProveedor, ENT_QUOTES, 'UTF-8') ?> |
       Fecha: <?= htmlspecialchars($compra->FechaCompra, ENT_QUOTES, 'UTF-8') ?> |
       Total: <?= number_format((float) $compra->Total, 2) ?></p>
    <?php if (($_GET['error'] ?? '') === 'datos'): ?>
        <p role="alert">Selecciona un producto válido y verifica la cantidad y el precio.</p>
    <?php endif; ?>
    <h2>Agregar artículo</h2>
    <form method="POST" action="index.php?controlador=compra&accion=agregarDetalle&id=<?= (int) $compra->IdCompra ?>">
        <label for="id_producto">Producto:</label>
        <select id="id_producto" name="id_producto" required>
            <option value="">Selecciona un producto</option>
            <?php foreach ($productos as $idProducto => $producto): ?>
                <option value="<?= (int) $idProducto ?>"><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
        <label for="precio_unitario">Precio unitario:</label>
        <input type="number" id="precio_unitario" name="precio_unitario" min="0" step="0.01" required>
        <button type="submit">Agregar detalle</button>
    </form>
    <h2>Artículos</h2>
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
    <p><a href="index.php?controlador=compra&accion=index">Volver a compras</a></p>
</body>
</html>
