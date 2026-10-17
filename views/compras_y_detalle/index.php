<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compras</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
    <h1>Compras</h1>
    <p><a href="index.php?controlador=compra&accion=crear">Nueva compra</a>
       <a href="index.php">Inicio</a></p>
    <table>
        <tr><th>ID</th><th>Fecha</th><th>Proveedor</th><th>Sucursal</th><th>Total</th><th>Acciones</th></tr>
        <?php while ($compra = $compras->fetch_object()): ?>
        <tr>
            <td><?= (int) $compra->IdCompra ?></td>
            <td><?= htmlspecialchars($compra->FechaCompra, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($compra->NombreProveedor, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($compra->NombreSucursal, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= number_format((float) $compra->Total, 2) ?></td>
            <td>
                <a href="index.php?controlador=compra&accion=detalle&id=<?= (int) $compra->IdCompra ?>">Detalle</a>
                <a href="index.php?controlador=compra&accion=editar&id=<?= (int) $compra->IdCompra ?>">Editar</a>
                <a href="index.php?controlador=compra&accion=eliminar&id=<?= (int) $compra->IdCompra ?>"
                   onclick="return confirm('¿Eliminar esta compra y sus detalles?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
