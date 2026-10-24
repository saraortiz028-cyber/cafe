<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>

<div class="admin-content">
    <h1>Empleados</h1>
    <a href="index.php?controlador=empleado&accion=crear" class="button button-dark">Nuevo Empleado</a>
    <a href="index.php" class="button button-dark">Inicio</a></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Salario</th>
            <th>Fecha Contratacion</th>
            <th>ID Cargo</th>
            <th>ID Sucursal</th>
            <th>Acciones</th>
        </tr>
        <?php while($e = $empleados->fetch_object()): ?>
        <tr>
            <td><?= $e->IdEmpleado ?></td>
            <td><?= $e->Nombre ?></td>
            <td><?= $e->Apellido ?></td>
            <td><?= $e->Direccion ?></td>
            <td><?= $e->Telefono ?></td>
            <td><?= $e->Correo ?></td>
            <td><?= $e->Salario ?></td>
            <td><?= $e->FechaContratacion ?></td>
            <td><?= $e->IdCargo ?></td>
            <td><?= $e->IdSucursal ?></td>
            <td>
                <a href="index.php?controlador=empleado&accion=editar&id=<?= $e->IdEmpleado ?>">Editar</a>
                <a href="index.php?controlador=empleado&accion=eliminar&id=<?= (int) $e->IdEmpleado ?>"
                   onclick="return confirm('¿Eliminar este empleado?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>