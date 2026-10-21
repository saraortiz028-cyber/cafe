<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de venta #<?= (int) $venta->IdVenta ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body class="compra-page">
    <div class="section-wrap">

    <h1 style="text-align: center;">Detalle de venta #<?= (int) $venta->IdVenta ?></h1>
    
    <div class="recibo-info">
    <p><strong>Fecha: </strong> <?= htmlspecialchars($venta->FechaVenta, ENT_QUOTES, 'UTF-8') ?> |
    <strong>Total: </strong> <?= number_format((float) $venta->Total, 2) ?></p>
    <p><strong>Comprado por:</strong>
        <?= $cliente ? htmlspecialchars($cliente->Nombres . ' ' . $cliente->Apellidos, ENT_QUOTES, 'UTF-8') : 'Público general' ?>
    </p>
    </div>
    
    <div style="margin-top: 20px; text-align: center;">
        <a href="index.php?controlador=venta&accion=recibo&id= <?= (int) $venta->IdVenta ?>" class="button button-dark">Ver recibo</a>
    </div>

    <?php if (($_GET['error'] ?? '') === 'datos'): ?>
        <p role="alert">Selecciona un producto válido y una cantidad mayor que cero.</p>
    <?php endif; ?>
    <h2 style="text-align: center;">Agregar más productos</h2>
    <form method="POST" action="index.php?controlador=venta&accion=agregarDetalle&id=<?= (int) $venta->IdVenta ?>">
        <label for="id_producto">Producto del menú:</label>
        <select id="id_producto" name="id_producto">
            <option value="">Selecciona un producto</option>
            <?php foreach ($productos as $idProducto => $producto): ?>
                <option value="<?= (int) $idProducto ?>"><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?> - $<?= number_format((float) $producto['precio'], 2) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
        <button type="submit">Agregar detalle</button>
    </form>
    <h2 style="text-align: center;">Artículos</h2>
    <table>
        <tr><th>Descripción</th><th>Cantidad</th><th>Precio unitario</th><th>Subtotal</th><th>Acciones</th></tr>
        <?php while ($detalle = $detalles->fetch_object()): ?>
        <tr>
            <td><?= htmlspecialchars($detalle->NombreProducto, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= (int) $detalle->Cantidad ?></td>
            <td><?= number_format((float) $detalle->PrecioUnitario, 2) ?></td>
            <td><?= number_format((float) $detalle->SubTotal, 2) ?></td>
            <td>
                <a href="index.php?controlador=venta&accion=editarDetalle&id=<?= (int) $venta->IdVenta ?>&id_detalle=<?= (int) $detalle->IdDetalleVenta ?>">Editar</a>
                <a href="index.php?controlador=venta&accion=eliminarDetalle&id=<?= (int) $venta->IdVenta ?>&id_detalle=<?= (int) $detalle->IdDetalleVenta ?>"
                   onclick="return confirm('¿Eliminar este detalle?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <div style="margin-top: 20px; text-align: center;">
                     <a href="index.php?controlador=venta&accion=index" class="button button-dark">Volver a ventas</a>
              </div>
    </div>
</body>
</html>
