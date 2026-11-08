<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<?php include __DIR__ . '/../navbar.php'; ?>

<div class="admin-content">

    <h1>Pedidos</h1>

    <p>
        <a href="index.php" class="button button-dark">Inicio</a>
    </p>

    <table>
        <tr>
            <th>Número de pedido</th>
            <th>Fecha</th>
            <th>Cliente (ID)</th>
            <th>Empleado (ID)</th>
            <th>Sucursal (ID)</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php while ($pedido = $pedidos->fetch_object()): ?>

        <tr>
            <td>
                <?= htmlspecialchars($pedido->NumeroPedido, ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <?= htmlspecialchars($pedido->FechaPedido, ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <?= htmlspecialchars((string) ($pedido->IdCliente ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <?= htmlspecialchars((string) ($pedido->IdEmpleado ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <?= htmlspecialchars((string) ($pedido->IdSucursal ?? ''), ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <?= number_format((float) $pedido->Total, 2) ?>
            </td>

            <td>
                <?php
                $estado = $pedido->EstadoPedido === 'Aprobado'
                    ? 'Completado'
                    : $pedido->EstadoPedido;
                ?>

                <?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <a href="index.php?controlador=pedido&accion=detalle&id=<?= (int) $pedido->IdPedido ?>">
                    Detalle
                </a>
            </td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>