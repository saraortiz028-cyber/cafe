<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $compra ? 'Editar compra' : 'Nueva compra' ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1><?= $compra ? 'Editar compra' : 'Nueva compra' ?></h1>
       <?php if ($error !== null): ?>
              <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
       <?php endif; ?>
    <form method="POST">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha"
               value="<?= htmlspecialchars($compra->FechaCompra ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" required>
       <label for="id_proveedor">Proveedor:</label>
              <select id="id_proveedor" name="id_proveedor" required>
                     <option value="">Selecciona un proveedor</option>
                     <?php while ($proveedor = $proveedores->fetch_object()): ?>
                            <option value="<?= (int) $proveedor->IdProveedor ?>" <?= $proveedorSeleccionado === (string) $proveedor->IdProveedor ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($proveedor->Nombre, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                     <?php endwhile; ?>
              </select>
              <label for="id_sucursal">Sucursal:</label>
              <select id="id_sucursal" name="id_sucursal" required>
                     <option value="">Selecciona una sucursal</option>
                     <?php while ($sucursal = $sucursales->fetch_object()): ?>
                            <option value="<?= (int) $sucursal->IdSucursal ?>" <?= $sucursalSeleccionada === (string) $sucursal->IdSucursal ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($sucursal->Nombre, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                     <?php endwhile; ?>
              </select>
        <button type="submit"><?= $compra ? 'Actualizar' : 'Guardar y agregar detalles' ?></button>
    </form>
    <p><a href="index.php?controlador=compra&accion=index">Volver a compras</a></p>
</body>
</html>
