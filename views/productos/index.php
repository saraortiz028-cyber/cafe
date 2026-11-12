<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body>

<?php include __DIR__ . '/../navbar.php'; ?>

<div class="admin-content">

    <h1>Productos</h1>

    <a href="index.php?controlador=producto&accion=crear"
       class="button button-dark">Nuevo Producto</a>

    <a href="index.php" class="button button-dark">Inicio</a>

    <?php if (isset($_GET['mensaje'])): ?>

        <?php if ($_GET['mensaje'] === 'tiene_ventas'): ?>

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
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Existencias</th>
            <th>Categoria</th>
            <th>Acciones</th>
        </tr>

        <?php while ($p = $productos->fetch_object()): ?>

            <tr>

                <td><?= (int) $p->IdProducto ?></td>

                <td>
                    <?php if (!empty($p->Imagen)): ?>

                        <img
                            src="public/img/productos/<?= rawurlencode(basename($p->Imagen)) ?>"
                            alt="<?= htmlspecialchars($p->Nombre, ENT_QUOTES, 'UTF-8') ?>"
                            style="width: 65px; height: 65px; object-fit: cover; border-radius: 8px;"
                        >

                    <?php else: ?>

                        <span>Sin imagen</span>

                    <?php endif; ?>
                </td>

                <td>
                    <?= htmlspecialchars($p->Nombre, ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars($p->Descripcion ?? '', ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <?= htmlspecialchars((string) $p->Precio, ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td><?= (int) $p->Existencias ?></td>

                <td>
                    <?= htmlspecialchars($p->NombreCategoria ?? 'Sin Categoría', ENT_QUOTES, 'UTF-8') ?>
                </td>

                <td>
                    <a href="index.php?controlador=producto&accion=editar&id=<?= (int) $p->IdProducto ?>">
                        Editar
                    </a>

                    <a href="index.php?controlador=producto&accion=eliminar&id=<?= (int) $p->IdProducto ?>"
                       onclick="return confirm('¿Eliminar este producto?')">
                        Eliminar
                    </a>
                </td>

            </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>