<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordenar | Café Aroma</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body class="compra-page">

<!-- Aqui estaba el cafeteria.html -->
    <p><a href="index.php">← Volver a Café Aroma</a></p>
    <h1>Arma tu pedido</h1>
    <p>Elige tus favoritos. El total se guarda en la venta y al terminar aparece tu recibo.</p>

    <?php if ($error !== null): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form class="compra-form" method="POST" action="index.php?controlador=venta&accion=comprar">
        <div class="compra-grid">
            <?php foreach ($productos as $idProducto => $producto): ?>
                <article class="compra-card">
                    <div>
                        <h2><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <p><?= htmlspecialchars($producto['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                        <strong>$<?= number_format($producto['precio'], 2) ?> MXN</strong>
                    </div>
                    <label for="producto-<?= (int) $idProducto ?>">Cantidad</label>
                    <input class="cantidad-producto" type="number"
                           id="producto-<?= (int) $idProducto ?>"
                           name="productos[<?= (int) $idProducto ?>]"
                           min="0" max="1000"
                           value="<?= htmlspecialchars((string) ($cantidades[$idProducto] ?? 0), ENT_QUOTES, 'UTF-8') ?>"
                           data-precio="<?= htmlspecialchars((string) $producto['precio'], ENT_QUOTES, 'UTF-8') ?>">
                </article>
            <?php endforeach; ?>
        </div>

        <label for="id_cliente">Cliente (opcional):</label>
        <select id="id_cliente" name="id_cliente">
            <option value="">Venta sin cliente registrado</option>
            <?php while ($cliente = $clientes->fetch_object()): ?>
                <option value="<?= (int) $cliente->IdCliente ?>"
                    <?= $idClienteSeleccionado === (string) $cliente->IdCliente ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cliente->Nombres . ' ' . $cliente->Apellidos, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="id_empleado">Empleado:</label>
        <select id="id_empleado" name="id_empleado" required>
            <option value="">Selecciona un empleado</option>
            <?php while ($empleado = $empleados->fetch_object()): ?>
                <option value="<?= (int) $empleado->IdEmpleado ?>"
                    <?= $idEmpleadoSeleccionado === (string) $empleado->IdEmpleado ? 'selected' : '' ?>>
                    <?= htmlspecialchars($empleado->Nombre . ' ' . $empleado->Apellido, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="id_sucursal">Sucursal:</label>
        <select id="id_sucursal" name="id_sucursal" required>
            <option value="">Selecciona una sucursal</option>
            <?php while ($sucursal = $sucursales->fetch_object()): ?>
                <option value="<?= (int) $sucursal->IdSucursal ?>"
                    <?= $idSucursalSeleccionada === (string) $sucursal->IdSucursal ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sucursal->Nombre, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endwhile; ?>
        </select>

        <p class="compra-total">Total estimado: <strong data-compra-total>$0.00 MXN</strong></p>
        <button type="submit">Confirmar compra y generar recibo</button>
    </form>
    <script src="public/js/compra.js" defer></script>
</body>
</html>
