<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía Temporal de Botones - Cafetería</title>
    <style>
        /* Variables globales de color que faltaban */
        :root {
            --green: #2d4a3e;
            --orange: #c86d3e;
            --muted: #6b6b63;
        }

        body { 
            padding: 40px; 
            font-family: sans-serif; 
            background: #fffefa; 
        }
        .seccion-guia { 
            margin-bottom: 40px; 
            padding: 20px; 
            border: 1px dashed #c9c7bb; 
            border-radius: 6px; 
            background: #ffffff;
        }
        .seccion-guia h2 { 
            margin-top: 0; 
            font-size: 18px; 
            color: #333; 
        }
        .ejemplo-fila { 
            display: flex; 
            gap: 15px; 
            align-items: center; 
            flex-wrap: wrap; 
            margin-top: 10px; 
        }

        /* ESTILOS EXACTOS DE TUS BOTONES */
        .button {
            min-height: 44px;
            padding: 0 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.2s ease, background 0.2s ease;
        }
        .button:hover {
            transform: translateY(-2px);
        }
        .button-dark {
            background: var(--green);
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .button-dark:hover {
            background: #263b2b;
        }
        .button-outline {
            min-height: 40px;
            border: 1px solid #c9c7bb;
            color: var(--green);
            background: transparent;
        }
        .button-outline:hover {
            background: #ebece4;
        }
        .button-outline span {
            color: var(--orange);
            margin-left: 5px;
        }
        .button-light {
            min-height: 40px;
            background: #f8f6f0;
            color: var(--green);
            border: none;
        }
        .button-light:hover {
            background: #e8e4d9;
        }

        /* Botones de formulario */
        form button[type="submit"] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 44px;
            padding: 0 20px;
            background: var(--green);
            color: #ffffff;
            border: none;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        form button[type="submit"]:hover {
            background: #263b2b;
            transform: translateY(-1px);
        }

        /* Botones dentro de tablas */
        td a.button-dark, td a.button-outline, 
        td a[href*="eliminar"], td a[href*="editar"], td a[href*="detalle"] {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 3px;
            margin-right: 5px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        td a[href*="editar"] {
            background: transparent;
            border: 1px solid #c9c7bb;
            color: var(--green);
        }
        td a[href*="editar"]:hover {
            background: var(--green);
            color: #ffffff;
        }
        td a[href*="eliminar"] {
            background: #a83232;
            color: #ffffff;
            border: 1px solid #a83232;
        }
        td a[href*="eliminar"]:hover {
            background: #822424;
            border-color: #822424;
        }
        td a[href*="detalle"] {
            background: #1e7e34;
            color: #ffffff;
            border: 1px solid #1e7e34;
        }
        td a[href*="detalle"]:hover {
            background: #155724;
            border-color: #155724;
        }
    </style>
</head>
<body>

    <h1>Guía Visual de Botones (Temporal)</h1>
    <p>Usa esta página para verificar cómo se ve cada botón. <em>Recuerda borrar este archivo antes de entregar el proyecto.</em></p>

    <!-- 1. Botón Oscuro Principal -->
    <div class="seccion-guia">
        <h2>1. Botón Oscuro / Principal (.button + .button-dark)</h2>
        <div class="ejemplo-fila">
            <a href="#" class="button button-dark">Botón Enlace Oscuro</a>
            <button class="button button-dark" type="button">Botón Etiqueta Button</button>
        </div>
    </div>

    <!-- 2. Botón Outline / Contorno -->
    <div class="seccion-guia">
        <h2>2. Botón de Contorno (.button + .button-outline)</h2>
        <div class="ejemplo-fila">
            <a href="#" class="button button-outline">Ver más <span>→</span></a>
        </div>
    </div>

    <!-- 3. Botón Claro -->
    <div class="seccion-guia">
        <h2>3. Botón Claro (.button + .button-light)</h2>
        <div class="ejemplo-fila" style="background: var(--green); padding: 15px; border-radius: 4px;">
            <a href="#" class="button button-light">Nuestra ubicación</a>
        </div>
    </div>

    <!-- 4. Botón de Formulario (Submit) -->
    <div class="seccion-guia">
        <h2>4. Botón de Formulario Completo (form button[type="submit"])</h2>
        <form style="max-width: 300px; margin-top: 10px;" onsubmit="return false;">
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>

    <!-- 5. Botones dentro de Tablas -->
    <div class="seccion-guia">
        <h2>5. Botones de Acción en Tablas (Editar, Eliminar, Detalles)</h2>
        <table border="0" cellpadding="5">
            <tr>
                <td>
                    <a href="editar.php?id=1">Editar</a>
                    <a href="detalle.php?id=1">Detalles</a>
                    <a href="eliminar.php?id=1">Eliminar</a>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>