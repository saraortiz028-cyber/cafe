<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar artículo de venta</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
    <h1>Editar artículo de la venta #<?= (int) $venta->IdVenta ?></h1>
    <?php if (isset($error)): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label for="id_producto">Producto:</label>
        <select id="id_producto" name="id_producto" required>
            <?php foreach ($productos as $idProducto => $producto): ?>
                <option value="<?= (int) $idProducto ?>" <?= (int) $detalle->IdProducto === (int) $idProducto ? 'selected' : '' ?>>
                    <?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?> - $<?= number_format($producto['precio'], 2) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" min="1"
               value="<?= (int) $detalle->Cantidad ?>" required>
        <button type="submit">Guardar cambios</button>
    </form>
    <p><a href="index.php?controlador=venta&accion=detalle&id=<?= (int) $venta->IdVenta ?>">Volver a la venta</a></p>
</body>
</html>
