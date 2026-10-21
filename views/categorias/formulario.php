<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $editando ? 'Editar Categoria' : 'Nueva Categoria' ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<div class="section-wrap">

<h1 style="text-align: center;">
    <?= $editando ? 'Editar Categoria' : 'Nueva Categoria' ?>
</h1>

<?php if ($error !== null): ?>
    <p role="alert">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label for="Nombre">Nombre de la categoría:</label>
    <input type="text" id="Nombre" name="Nombre" maxlength="50"
        value="<?= htmlspecialchars($categoria->Nombre ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="Descripcion">Descripción:</label>
    <input type="text" id="Descripcion" name="Descripcion" maxlength="150"
        value="<?= htmlspecialchars($categoria->Descripcion ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

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