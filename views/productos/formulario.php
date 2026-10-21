<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>
        <?= $editando ? 'Editar Producto' : 'Nuevo Producto' ?>
    </title>

    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body>

    <div class="section-wrap">

        <h1 style="text-align: center;">
            <?= $editando ? 'Editar Producto' : 'Nuevo Producto' ?>
        </h1>

        <?php if ($error !== null): ?>
            <p role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <label for="nombre">Nombre:</label>

            <input type="text" id="nombre" name="nombre"
                value="<?= htmlspecialchars($producto->Nombre ?? $producto->nombre ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="descripcion">Descripción:</label>

            <input type="text" id="descripcion" name="descripcion"
                value="<?= htmlspecialchars($producto->Descripcion ?? $producto->descripcion ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="precio">Precio:</label>

            <input type="number" step="0.01" id="precio" name="precio"
                value="<?= htmlspecialchars((string) ($producto->Precio ?? $producto->precio ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="existencias">Existencias:</label>

            <input type="number" id="existencias" name="existencias"
                value="<?= htmlspecialchars((string) ($producto->Existencias ?? $producto->existencias ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                required
            >

            <label for="id_categoria">Categoría:</label>

            <select id="id_categoria" name="id_categoria" required>
                <option value="">Selecciona una categoría</option>
                <?php while ($c = $categorias->fetch_object()): ?>
                    <option
                        value="<?= (int) $c->IdCategoria ?>"
                        <?= (
                            ($producto->IdCategoria ?? $producto->id_categoria ?? '') == $c->IdCategoria
                        ) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($c->Nombre, ENT_QUOTES, 'UTF-8') ?>
                    </option>

                <?php endwhile; ?>

            </select>

            <button type="submit">
                <?= $editando ? 'Actualizar' : 'Guardar' ?>
            </button>

            <!-- <a href="index.php?controlador=producto&accion=index">
                Cancelar
            </a> -->

        </form>

    </div>

</body>

</html>