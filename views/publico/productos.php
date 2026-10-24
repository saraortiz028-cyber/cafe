<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo | Café Aroma</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body class="compra-page">

<?php include __DIR__ . '/../navbar_publico.php'; ?>

<main class="categorias-page catalogo-page">

    <section class="categorias-hero">
        <span class="categorias-eyebrow">HECHO PARA DISFRUTAR</span>

        <h1>Nuestro catálogo</h1>

        <p>
            Descubre los sabores de Café Aroma.
            Encuentra tu próxima bebida o antojo favorito.
        </p>

        <span class="categorias-decoracion">☕</span>
    </section>

    <section class="categorias-contenido">

        <div class="categorias-encabezado">
            <div>
                <span class="categorias-etiqueta">NUESTRA VARIEDAD</span>
                <h2>Un sabor para cada momento</h2>
            </div>

            <p>
                Explora nuestros productos y elige
                lo que más se te antoje.
            </p>
        </div>

        <form
            class="compra-form"
            method="POST"
            action="index.php?controlador=publico&accion=confirmarCompra"
        >

            <div class="compra-grid">

                <?php if ($productos && $productos->num_rows > 0): ?>

                    <?php while ($producto = $productos->fetch_object()): ?>

                        <article class="compra-card">

                            <?php if (!empty($producto->Imagen)): ?>
                                <div class="producto-imagen-contenedor">
                                    <img
                                        class="producto-imagen"
                                        src="public/img/productos/<?= rawurlencode(basename($producto->Imagen)) ?>"
                                        alt="<?= htmlspecialchars(
                                            $producto->Nombre,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        loading="lazy"
                                    >
                                </div>
                            <?php else: ?>
                                <div class="producto-imagen-vacia" aria-label="Imagen no disponible">
                                    <span>☕</span>
                                </div>
                            <?php endif; ?>

                            <div class="producto-informacion">

                                <span class="card-number">
                                    <?= htmlspecialchars(
                                        $producto->NombreCategoria ?? 'Cafetería',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                                <h2>
                                    <?= htmlspecialchars(
                                        $producto->Nombre,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </h2>

                                <p>
                                    <?= htmlspecialchars(
                                        $producto->Descripcion ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </p>

                                <strong class="producto-precio">
                                    $<?= number_format((float) $producto->Precio, 2) ?> NIO
                                </strong>

                            </div>

                            <div class="producto-cantidad">
                                <label for="producto-<?= (int) $producto->IdProducto ?>">
                                    Cantidad
                                </label>

                                <input
                                    class="cantidad-producto"
                                    type="number"
                                    id="producto-<?= (int) $producto->IdProducto ?>"
                                    name="productos[<?= (int) $producto->IdProducto ?>]"
                                    min="0"
                                    max="1000"
                                    value="0"
                                    data-precio="<?= htmlspecialchars(
                                        (string) $producto->Precio,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >
                            </div>

                        </article>

                    <?php endwhile; ?>

                <?php else: ?>

                    <p class="catalogo-vacio">
                        Actualmente no hay productos disponibles.
                    </p>

                <?php endif; ?>

            </div>

            <?php if ($productos && $productos->num_rows > 0): ?>

                <div class="compra-resumen">

                    <p class="compra-total">
                        Total estimado:
                        <strong data-compra-total>$0.00 NIO</strong>
                    </p>

                    <button type="submit">
                        Confirmar compra y generar recibo
                    </button>

                </div>

            <?php endif; ?>

        </form>

    </section>

</main>

<footer class="site-footer">
    <div class="brand footer-brand">
        <div class="brand-icon">☕</div>
        <strong>Café Aroma</strong>
    </div>

    <p>Un buen día empieza aquí.</p>
</footer>

<script src="public/js/compra.js" defer></script>