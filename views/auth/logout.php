<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sesión cerrada - Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

    <div class="section-wrap">

        <h1 style="text-align: center;">¡Has cerrado sesión!</h1>

        <p style="text-align: center;">
            Tu sesión se ha cerrado correctamente.
        </p>

        <p style="text-align: center;">
            Gracias por utilizar el sistema de Cafetería.
        </p>

        <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-top: 25px;">

            <a href="index.php?controlador=auth&accion=login"
               class="button button-dark">
                Iniciar sesión
            </a>

            <a href="index.php"
               class="button button-dark">
                Volver al inicio
            </a>

        </div>

    </div>

</body>
</html>
```
