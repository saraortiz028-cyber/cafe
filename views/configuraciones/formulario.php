<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $editando ? 'Editar Configuración' : 'Nueva Configuración' ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<div class="section-wrap">

<h1 style="text-align: center;">
    <?= $editando ? 'Editar Configuración' : 'Nueva Configuración' ?>
</h1>

<?php if ($error !== null): ?>
    <p role="alert">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label for="NombreConfiguracion">Nuevo valor de IVA:</label>

    <input
        type="number" id="IVA" name="IVA" maxlength="999.99" step="0.01"
        value="<?= htmlspecialchars($configuracion->IVA ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

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