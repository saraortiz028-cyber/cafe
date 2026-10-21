<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $editando ? 'Editar Cargo' : 'Nuevo Cargo' ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<div class="section-wrap">

<h1 style="text-align: center;">
    <?= $editando ? 'Editar Cargo' : 'Nuevo Cargo' ?>
</h1>

<?php if ($error !== null): ?>
    <p role="alert">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label for="NombreCargo">Nombre del cargo:</label>

    <input
        type="text" id="NombreCargo" name="NombreCargo" maxlength="30"
        value="<?= htmlspecialchars($cargo->NombreCargo ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

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