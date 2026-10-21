<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body class="order-section">

    <div class="section-wrap">

        <h1 style="text-align: center;">Nuevo Producto</h1>

        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripcion:</label>
            <input type="text" id="descripcion" name="descripcion">

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" required>

            <label for="existencias">Existencias:</label>
            <input type="number" id="existencias" name="existencias" required>

            <label for="id_categoria">Categoria:</label>
            <select id="id_categoria" name="id_categoria">
                <option value="">Seleccione una categoría</option>
                <?php while($cat = $categorias->fetch_object()): ?>
                    <option value="<?= $cat->IdCategoria ?>"><?= $cat->Nombre ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Guardar</button>
        </form>
    </div>
</body>
</html>