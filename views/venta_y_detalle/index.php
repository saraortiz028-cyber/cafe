<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
    <h1>Ventas</h1>
    <p><a href="index.php?controlador=venta&accion=comprar">Nueva compra</a>
       <a href="index.php?controlador=venta&accion=crear">Nueva venta manual</a>
       <a href="index.php">Inicio</a></p>
    <table>
        <tr>
            <th>ID</th><th>Fecha</th><th>Cliente (ID)</th><th>Empleado (ID)</th>
            <th>Sucursal (ID)</th><th>Total</th><th>Acciones</th>
        </tr>
        <?php while ($venta = $ventas->fetch_object()): ?>
        <tr>
            <td><?= (int) $venta->IdVenta ?></td>
            <td><?= htmlspecialchars($venta->FechaVenta, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($venta->IdCliente ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($venta->IdEmpleado ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($venta->IdSucursal ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= number_format((float) $venta->Total, 2) ?></td>
            <td>
                <a href="index.php?controlador=venta&accion=detalle&id=<?= (int) $venta->IdVenta ?>">Detalle</a>
                <a href="index.php?controlador=venta&accion=editar&id=<?= (int) $venta->IdVenta ?>">Editar</a>
                <a href="index.php?controlador=venta&accion=eliminar&id=<?= (int) $venta->IdVenta ?>"
                   onclick="return confirm('¿Eliminar esta venta y sus detalles?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
