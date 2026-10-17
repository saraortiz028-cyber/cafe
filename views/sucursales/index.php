<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sucursales</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
    <h1>Sucursales</h1>
    <p>
        <a href="index.php?controlador=sucursal&accion=crear">Nueva sucursal</a>
        <a href="index.php">Inicio</a>
    </p>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Acciones</th>
        </tr>
        <?php while ($sucursal = $sucursales->fetch_object()): ?>
            <tr>
                <td><?= (int) $sucursal->IdSucursal ?></td>
                <td><?= htmlspecialchars($sucursal->Nombre, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($sucursal->Direccion, ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="index.php?controlador=sucursal&accion=editar&id=<?= (int) $sucursal->IdSucursal ?>">Editar</a>
                    <a href="index.php?controlador=sucursal&accion=eliminar&id=<?= (int) $sucursal->IdSucursal ?>" 
                     onclick="return confirm('¿Eliminar esta sucursal?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>