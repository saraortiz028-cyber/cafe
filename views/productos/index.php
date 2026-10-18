<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
    <h1>Productos</h1>
    <a href="index.php?controlador=producto&accion=crear" class="button button-dark">Nuevo Producto</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Existencias</th>
            <th>Categoria</th>
            <th>Acciones</th>
        </tr>
        <?php while($p = $productos->fetch_object()): ?>
        <tr>
            <td><?= $p->IdProducto ?></td>
            <td><?= $p->Nombre ?></td>
            <td><?= $p->Descripcion ?></td>
            <td><?= $p->Precio ?></td>
            <td><?= $p->Existencias ?></td>
            <td><?= $p->NombreCategoria ?? 'Sin Categoría' ?></td>
            <td>
                <a href="index.php?controlador=producto&accion=editar&id=<?= $p->IdProducto ?>">Editar</a>
                <a href="index.php?controlador=producto&accion=eliminar&id=<?= (int) $p->IdProducto ?>"
                    onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </table>
</body>
</html>
