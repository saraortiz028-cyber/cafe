<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sucursales | Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<?php include __DIR__ . '/../navbar_publico.php'; ?>

<main class="categorias-page">

    <section class="categorias-hero">
        <span class="categorias-eyebrow">SIEMPRE CERCA DE TI</span>

        <h1>Nuestras sucursales</h1>

        <p>
            Encuentra tu cafetería favorita, conoce nuestras ubicaciones
            y descubre dónde disfrutar de un buen café.
        </p>

        <span class="categorias-decoracion" aria-hidden="true">⌖</span>
    </section>

    <section class="categorias-contenido">

        <div class="categorias-encabezado">
            <div>
                <span class="categorias-etiqueta">VISÍTANOS</span>
                <h2>Encuentra tu sucursal</h2>
            </div>

            <p>Será un gusto recibirte y compartir contigo una buena taza de café.</p>
        </div>

        <div class="categorias-grid">

            <?php if ($sucursales && $sucursales->num_rows > 0): ?>

                <?php $numeroSucursal = 0; ?>

                <?php while ($sucursal = $sucursales->fetch_object()): ?>

                    <?php $numeroSucursal++; ?>

                    <article class="categoria-card sucursal-card">

                        <span class="categoria-numero">
                            <?= str_pad((string) $numeroSucursal, 2, '0', STR_PAD_LEFT) ?>
                        </span>

                        <div class="categoria-icono" aria-hidden="true">⌖</div>

                        <h3>
                            <?= htmlspecialchars(
                                $sucursal->Nombre,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </h3>

                        <span class="categoria-linea"></span>

                        <p class="sucursal-direccion">
                            <?= htmlspecialchars(
                                $sucursal->Direccion ?? 'Dirección no disponible',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    </article>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="categorias-vacio">
                    <span aria-hidden="true">☕</span>
                    <h3>Pronto estaremos más cerca</h3>
                    <p>No hay sucursales disponibles por el momento.</p>
                </div>

            <?php endif; ?>

        </div>

        <div class="categorias-accion">
            <p>¿Ya tienes ganas de disfrutar algo delicioso?</p>

            <a
                href="index.php?controlador=publico&accion=productos"
                class="categorias-boton"
            >
                Explorar productos <span aria-hidden="true">→</span>
            </a>
        </div>

    </section>

</main>

<footer class="site-footer">
    <div class="brand footer-brand">
        <div class="brand-icon">☕</div>
        <strong>Cafetería</strong>
    </div>

    <p>Te esperamos para compartir un buen café.</p>
</footer>

</body>
</html>