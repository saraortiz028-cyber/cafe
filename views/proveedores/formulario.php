<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>
        <?= $editando ? 'Editar Proveedor' : 'Nuevo Proveedor' ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body>

    <div class="section-wrap">

        <h1 style="text-align: center;">
            <?= $editando ? 'Editar Proveedor' : 'Nuevo Proveedor' ?>
        </h1>

        <?php if ($error !== null): ?>
            <p role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <label for="Nombre">Nombre:</label>

            <input type="text" id="Nombre" name="Nombre"
                value="<?= htmlspecialchars($proveedor->Nombre ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="Telefono">Teléfono:</label>

            <input type="text" id="Telefono" name="Telefono"
                value="<?= htmlspecialchars($proveedor->Telefono ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="Correo">Correo:</label>

            <input type="email" id="Correo" name="Correo"
                value="<?= htmlspecialchars($proveedor->Correo ?? '', ENT_QUOTES, 'UTF-8') ?>"
            >

            <label for="Direccion">Dirección:</label>

            <input type="text" id="Direccion" name="Direccion"
                value="<?= htmlspecialchars($proveedor->Direccion ?? '', ENT_QUOTES, 'UTF-8') ?>"
            > 

            <button type="submit">
                <?= $editando ? 'Actualizar' : 'Guardar' ?>
            </button>

            <!-- <a href="index.php?controlador=proveedor&accion=index">
                Cancelar
            </a> -->

        </form>

    </div>

</body>

</html>