<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos | Café Aroma</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body>

<?php include __DIR__ . '/../navbar_publico.php'; ?>

<?php
$numeroIngresado = htmlspecialchars(
    $numero ?? '',
    ENT_QUOTES,
    'UTF-8'
);
?>

<main class="categorias-page">

    <!-- HERO -->
    <section class="categorias-hero">

        <span class="categorias-eyebrow">TU PEDIDO, A UN CLIC</span>

        <h1>Consulta tu pedido</h1>

        <p>
            Queremos que disfrutes de una buena experiencia.
            Consulta el estado de tu pedido y mantente al tanto de su proceso.
        </p>

        <span class="categorias-decoracion">📄</span>

    </section>


    <section class="categorias-contenido">

        <!-- ENCABEZADO --> 
        <div class="categorias-encabezado">

            <div>
                <span class="categorias-etiqueta">SEGUIMIENTO DE PEDIDOS</span>
                <h2>¿Cómo va tu pedido?</h2>
            </div>

            <p>
                Introduce tu número de pedido para conocer su estado actual.
            </p>

        </div>


        <!-- FORMULARIO DE CONSULTA -->
        <section class="pedido-busqueda">

    <form action="index.php" method="GET">

        <input type="hidden" name="controlador" value="publico">
        <input type="hidden" name="accion" value="pedido">

        <label for="numeroPedido">
            Número de pedido
        </label>

        <input
            type="text"
            id="numeroPedido"
            name="numero"
            placeholder="Ejemplo: PED-00001"
            value="<?= $numeroIngresado ?>"
            required
        >

        <small>
            Ingresa el número que recibiste al registrar tu pedido.
        </small>

        <button type="submit" class="categorias-boton">
            Consultar pedido 
        </button>

    </form>

</section>


        <?php if ($numero !== ''): ?>

            <?php if ($pedido): ?>

                <?php
                    $estado = $pedido->EstadoPedido;

                    $claseEstado = match ($estado) {
                        'Pendiente' => 'estado-pendiente',
                        'Aprobado' => 'estado-aprobado',
                        'Rechazado' => 'estado-rechazado',
                        default => ''
                    };

                    $mensajeEstado = match ($estado) {
                        'Pendiente' => 'Tu pedido está esperando la aprobación de un empleado.',
                        'Aprobado' => '¡Tu pedido ha sido aprobado!',
                        'Rechazado' => 'Tu pedido no fue aprobado.',
                        default => 'Consulta el estado de tu pedido.'
                    };
                ?>

                <!-- RESULTADO DEL PEDIDO -->
                <section class="pedido-resultados">

                    <div class="pedido-resumen">

                        <div>

                            <span class="pedido-etiqueta">
                                NÚMERO DE PEDIDO
                            </span>

                            <h2>
                                <?= htmlspecialchars(
                                    $pedido->NumeroPedido,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </h2>

                        </div>

                        <span class="pedido-estado <?= $claseEstado ?>">
                            <?= htmlspecialchars($estado) ?>
                        </span>

                    </div>

                    <!-- INFORMACIÓN GENERAL -->
                    <div class="pedido-datos">

                        <div class="pedido-dato">

                            <span>Fecha del pedido</span>

                            <strong>
                                <?= date(
                                    'd/m/Y h:i A',
                                    strtotime($pedido->FechaPedido)
                                ) ?>
                            </strong>

                        </div>

                        <div class="pedido-dato">

                            <span>Total del pedido</span>

                            <strong>
                                C$ <?= number_format($pedido->Total, 2) ?>
                            </strong>

                        </div>

                    </div>


                    <!-- PRODUCTOS -->
                    <div class="pedido-productos">

                        <div class="pedido-productos-encabezado">

                            <span class="pedidos-etiqueta">
                                DETALLE DE LA SOLICITUD
                            </span>

                            <h3>Productos solicitados</h3>

                        </div>

                        <div class="pedido-tabla-contenedor">

                            <table class="pedido-tabla">

                                <thead>

                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
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
                                                C$ <?= number_format(
                                                    $detalle['PrecioUnitario'],
                                                    2
                                                ) ?>
                                            </td>

                                            <td>
                                                C$ <?= number_format(
                                                    $detalle['SubTotal'],
                                                    2
                                                ) ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                                <tfoot>

                                    <tr>
                                        <td colspan="3">Total</td>

                                        <td>
                                            C$ <?= number_format(
                                                $pedido->Total,
                                                2
                                            ) ?>
                                        </td>
                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    </div>

                </section>

                                            <!-- RECIBO DE VENTA -->
                    <?php if ($estado === 'Aprobado' && !empty($pedido->IdVenta)): ?>

                        <div style="margin: 20px 0; text-align: center;">

                            <a
                                href="index.php?controlador=publico&accion=recibo&id=<?= (int) $pedido->IdVenta ?>"
                                class="categorias-boton"
                            >
                                Ver recibo del pedido
                            </a>

                        </div>

                    <?php endif; ?>

            <?php else: ?>

                <!-- PEDIDO NO ENCONTRADO -->
                <section class="pedido-no-encontrado">

                    <span>☕</span>

                    <h3>No encontramos tu pedido</h3>

                    <p>
                        No existe ningún pedido registrado con el número
                        <strong><?= $numeroIngresado ?></strong>.
                    </p>

                    <p>
                        Verifica el número e inténtalo nuevamente, antes de escribir el número 
                        de tu pedido debes incluir el prefijo <strong>PED-</strong> y seguido los dígitos.
                    </p>

                </section>

            <?php endif; ?>


        <?php else: ?>

            <!-- MENSAJE INICIAL -->
            <section class="pedidos-inicial">

                <div class="pedidos-inicial-icono">
                    ☕
                </div>

                <h2>¡Estamos pendientes de tu pedido!</h2>

                <p>
                    Cuando realices un pedido, recibirás un número único.
                    Utilízalo aquí para conocer si está pendiente,
                    aprobado o rechazado.
                </p>

            </section>

        <?php endif; ?>


    </section>

</main>


<!-- FOOTER -->
<footer class="site-footer">

    <div class="brand footer-brand">

        <div class="brand-icon">☕</div>

        <strong>Cafetería</strong>

    </div>

    <p>Un buen café siempre es una buena idea.</p>

</footer>

</body>
</html>