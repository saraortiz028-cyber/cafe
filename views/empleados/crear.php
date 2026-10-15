<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Empleado</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1>Nuevo Empleado</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>

        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" placeholder="Direccion">

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" placeholder="Telefono">

        <label for="correo">Correo Electronico:</label>
        <input type="email" id="correo" name="correo" placeholder="Correo Electronico">

        <label for="salario">Salario:</label>
        <input type="number" step="0.01" id="salario" name="salario" placeholder="Salario">

        <label for="id_cargo">ID Cargo:</label>
        <input type="number" id="id_cargo" name="id_cargo" placeholder="ID del Cargo">

        <label for="id_sucursal">ID Sucursal:</label>
        <input type="number" id="id_sucursal" name="id_sucursal" placeholder="ID de la Sucursal">

        <button type="submit">Guardar</button>
    </form>
</body>
</html>