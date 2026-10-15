<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1>Editar Producto</h1>
    
    <form method="POST">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($producto->Nombre ?? '') ?>" required>

        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" required><?= htmlspecialchars($producto->Descripcion ?? '') ?></textarea>

        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($producto->Precio ?? '') ?>" required>

        <label for="existencias" class="form-label">Existencias</label>
        <input type="number" class="form-control" id="existencias" name="existencias" value="<?= htmlspecialchars($producto->Existencias ?? '') ?>" required>

        <label for="id_categoria" class="form-label">Categoría</label>
        <select class="form-control" id="id_categoria" name="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php while($c = $categorias->fetch_object()): ?>
                <option value="<?= $c->IdCategoria ?>" <?= ($producto->IdCategoria == $c->IdCategoria) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c->Nombre) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Actualizar Producto</button>
    </form>
    
    <br>
    <a href="index.php?controlador=producto&accion=index">Volver al listado</a>
</body>
</html>