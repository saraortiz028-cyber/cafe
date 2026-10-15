<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $sucursal ? 'Editar sucursal' : 'Nueva sucursal' ?></title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1><?= $sucursal ? 'Editar sucursal' : 'Nueva sucursal' ?></h1>
    <?php if ($error !== null): ?>
        <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" maxlength="50"
               value="<?= htmlspecialchars($sucursal->Nombre ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" maxlength="150"
               value="<?= htmlspecialchars($sucursal->Direccion ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <button type="submit"><?= $sucursal ? 'Actualizar' : 'Guardar' ?></button>
    </form>
    <p><a href="index.php?controlador=sucursal&accion=index">Volver a sucursales</a></p>
</body>
</html>