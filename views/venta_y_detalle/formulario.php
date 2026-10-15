<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $venta ? 'Editar venta' : 'Nueva venta' ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1><?= $venta ? 'Editar venta' : 'Nueva venta' ?></h1>
       <?php if ($error !== null): ?>
              <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
       <?php endif; ?>
    <form method="POST">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha"
               value="<?= htmlspecialchars($venta->FechaVenta ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" required>
              <label for="id_cliente">Cliente (opcional):</label>
              <select id="id_cliente" name="id_cliente">
                     <option value="">Sin cliente registrado</option>
                     <?php while ($cliente = $clientes->fetch_object()): ?>
                            <option value="<?= (int) $cliente->IdCliente ?>" <?= $idClienteSeleccionado === (string) $cliente->IdCliente ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($cliente->Nombres . ' ' . $cliente->Apellidos, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                     <?php endwhile; ?>
              </select>
              <label for="id_empleado">Empleado:</label>
              <select id="id_empleado" name="id_empleado" required>
                     <option value="">Selecciona un empleado</option>
                     <?php while ($empleado = $empleados->fetch_object()): ?>
                            <option value="<?= (int) $empleado->IdEmpleado ?>" <?= $idEmpleadoSeleccionado === (string) $empleado->IdEmpleado ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($empleado->Nombre . ' ' . $empleado->Apellido, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                     <?php endwhile; ?>
              </select>
              <label for="id_sucursal">Sucursal:</label>
              <select id="id_sucursal" name="id_sucursal" required>
                     <option value="">Selecciona una sucursal</option>
                     <?php while ($sucursal = $sucursales->fetch_object()): ?>
                            <option value="<?= (int) $sucursal->IdSucursal ?>" <?= $idSucursalSeleccionada === (string) $sucursal->IdSucursal ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($sucursal->Nombre, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                     <?php endwhile; ?>
              </select>
        <button type="submit"><?= $venta ? 'Actualizar' : 'Guardar y agregar detalles' ?></button>
    </form>
       <p><a href="index.php?controlador=venta&accion=index">Volver a ventas</a></p>
</body>
</html>
