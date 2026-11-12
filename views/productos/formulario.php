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
            <p role="alert" class="alerta alerta-error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

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


            <!-- Imagen actual del producto -->
            <?php if ($editando && !empty($producto->Imagen)): ?>

                <label>Imagen actual:</label>

                <div style="margin: 10px 0 20px;">

                    <img
                        src="public/img/productos/<?= rawurlencode(basename($producto->Imagen)) ?>"
                        alt="Imagen actual del producto"
                        style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;"
                    >

                </div>

            <?php endif; ?>


            <!-- Selector de imagen -->
<label for="imagen">
    <?= $editando ? 'Cambiar imagen (opcional):' : 'Imagen del producto:' ?>
</label>

<div class="imagen-upload">

    <input
        type="file"
        id="imagen"
        name="imagen"
        accept=".jpg,.jpeg,.png,.webp"
    >

    <small class="imagen-ayuda">
        <strong>Formatos permitidos:</strong> JPG, JPEG, PNG y WEBP.
        <br>
        <strong>Tamaño máximo:</strong> 3 MB.
    </small>

</div>


            <button type="submit">
                <?= $editando ? 'Actualizar' : 'Guardar' ?>
            </button>

        </form>

    </div>

</body>

</html>