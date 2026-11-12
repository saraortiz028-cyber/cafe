<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del pedido <?= htmlspecialchars($pedido->NumeroPedido, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body class="compra-page">

<div class="section-wrap">

    <h1 style="text-align: center;">
        Detalle del pedido <?= htmlspecialchars($pedido->NumeroPedido, ENT_QUOTES, 'UTF-8') ?>
    </h1>

    <!-- INFORMACIÓN DEL PEDIDO -->

    <div class="recibo-info">

        <p>
            <strong>Fecha:</strong>
            <?= htmlspecialchars($pedido->FechaPedido, ENT_QUOTES, 'UTF-8') ?>
            |
            <strong>Total:</strong>
            <?= number_format((float) $pedido->Total, 2) ?>
        </p>

        <p>
            <strong>Estado:</strong>

            <?php
            $estado = $pedido->EstadoPedido === 'Aprobado'
                ? 'Completado'
                : $pedido->EstadoPedido;
            ?>

            <?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>
        </p>

        <p>
            <strong>Sucursal:</strong>
            <?= (int) $pedido->IdSucursal ?>
        </p>

        <p>
            <strong>Empleado:</strong>
            <?= $pedido->IdEmpleado
                ? (int) $pedido->IdEmpleado
                : 'Sin asignar' ?>
        </p>

    </div>


    <!-- MENSAJES -->

    <?php if (!empty($_SESSION['mensaje_pedido'])): ?>

        <p role="status" style="text-align: center;">
            <?= htmlspecialchars($_SESSION['mensaje_pedido'], ENT_QUOTES, 'UTF-8') ?>
        </p>

        <?php unset($_SESSION['mensaje_pedido']); ?>

    <?php endif; ?>


    <?php if (!empty($_SESSION['error_pedido'])): ?>

        <p role="alert" style="text-align: center;">
            <?= htmlspecialchars($_SESSION['error_pedido'], ENT_QUOTES, 'UTF-8') ?>
        </p>

        <?php unset($_SESSION['error_pedido']); ?>

    <?php endif; ?>


    <!-- PRODUCTOS DEL PEDIDO -->

    <h2 style="text-align: center;">Productos solicitados</h2>

    <table>

        <tr>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($detalles as $detalle): ?>

        <tr>

            <td>
                <?= htmlspecialchars($detalle['NombreProducto'], ENT_QUOTES, 'UTF-8') ?>
            </td>

            <td>
                <?= (int) $detalle['Cantidad'] ?>
            </td>

            <td>
                <?= number_format((float) $detalle['PrecioUnitario'], 2) ?>
            </td>

            <td>
                <?= number_format((float) $detalle['SubTotal'], 2) ?>
            </td>

        </tr>

        <?php endforeach; ?>

        <tr>
            <th colspan="3">Total</th>
            <th>
                <?= number_format((float) $pedido->Total, 2) ?>
            </th>
        </tr>

    </table>


    <!-- ACCIONES SEGÚN EL ESTADO -->

    <?php if ($pedido->EstadoPedido === 'Pendiente'): ?>

        <h2 style="text-align: center;">Gestionar pedido</h2>

        <div style="margin-top: 20px; text-align: center;">

            <form method="POST"
                    action="index.php?controlador=pedido&accion=aprobar"
                    style="display: inline-block;">

                <input type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars(Auth::csrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                <input type="hidden"
                        name="idPedido"
                        value="<?= (int) $pedido->IdPedido ?>">

                <button type="submit"
                    class="pedido-btn-aprobar"
                    onclick="return confirm('¿Aprobar este pedido y generar su venta?')">
                    Aprobar pedido
                </button>

            </form>


            <form method="POST"
                    action="index.php?controlador=pedido&accion=rechazar"
                    style="display: inline-block;">

                <input type="hidden"
                        name="csrf_token"
                        value="<?= htmlspecialchars(Auth::csrfToken(), ENT_QUOTES, 'UTF-8') ?>">

                <input type="hidden"
                        name="idPedido"
                        value="<?= (int) $pedido->IdPedido ?>">

                <button type="submit"
                        class="pedido-btn-rechazar"
                        onclick="return confirm('¿Estás seguro de rechazar este pedido?')">
                    Rechazar pedido
                </button>

            </form>

        </div>

    <?php elseif ($pedido->EstadoPedido === 'Aprobado' && $pedido->IdVenta): ?>

        <div style="margin-top: 20px; text-align: center;">

            <a href="index.php?controlador=venta&accion=recibo&id=<?= (int) $pedido->IdVenta ?>&origen=pedido"
   class="button button-dark">
    Ver recibo de venta
</a>
        </div>

    <?php endif; ?>


    <!-- VOLVER -->

    <div style="margin-top: 20px; text-align: center;">

        <a href="index.php?controlador=pedido&accion=index"
           class="button button-dark">
            Volver a pedidos
        </a>

    </div>

</div>

</body>
</html>