<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Cliente</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>

    <h1>Nuevo Cliente</h1>
    <form method="POST">
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" placeholder="Nombres" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" placeholder="Telefono">

        <label for="correo">Correo Electronico:</label>
        <input type="email" id="correo" name="correo" placeholder="Correo Electronico">

        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" placeholder="Direccion">

        <button type="submit">Guardar</button>
    </form>
</body>
</html>