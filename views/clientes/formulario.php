<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $editando ? 'Editar Cliente' : 'Nuevo Cliente' ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<div class="section-wrap">

<h1 style="text-align: center;">
    <?= $editando ? 'Editar Cliente' : 'Nuevo Cliente' ?>
</h1>

<?php if ($error !== null): ?>
    <p role="alert">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" placeholder="Nombres" maxlength="45" 
        value="<?= htmlspecialchars($cliente->Nombres ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" maxlength="45"
        value="<?= htmlspecialchars($cliente->Apellidos ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" placeholder="Telefono" maxlength="12"
        value="<?= htmlspecialchars($cliente->Telefono ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <label for="correo">Correo Electronico:</label>
        <input type="email" id="correo" name="correo" placeholder="Correo Electronico" maxlength="60"
        value="<?= htmlspecialchars($cliente->Email ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" placeholder="Direccion" maxlength="200"
        value="<?= htmlspecialchars($cliente->Direccion ?? '', ENT_QUOTES, 'UTF-8') ?>">


    <button type="submit">
        <?= $editando ? 'Actualizar' : 'Guardar' ?>
    </button>

    <!--<a href="index.php?controlador=cargo&accion=index" class="button button-dark">
        Cancelar
    </a>-->

</form>
</div>
</body>
</html>