<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>

<div class="admin-content">
    <h1>Productos</h1>
    <a href="index.php?controlador=producto&accion=crear" class="button button-dark">Nuevo Producto</a>
    <a href="index.php" class="button button-dark">Inicio</a></p>

    <?php if (isset($_GET['mensaje'])): ?>

    <?php if ($_GET['mensaje'] === 'eliminado'): ?>

        <!--<div class="alerta alerta-exito">
            Producto eliminado correctamente.
        </div>-->

    <?php elseif ($_GET['mensaje'] === 'tiene_ventas'): ?>

        <div class="alerta alerta-error">
            No se puede eliminar este producto porque tiene ventas registradas.
        </div>

    <?php elseif ($_GET['mensaje'] === 'error'): ?>

        <div class="alerta alerta-error">
            No se pudo eliminar el producto. Inténtalo nuevamente.
        </div>

    <?php endif; ?>

<?php endif; ?>


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
</div>
</body>
</html>
