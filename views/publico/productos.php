<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuestros productos - Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>

<body class="compra-page">

    <?php include __DIR__ . '/../navbar_publico.php'; ?>

    <main class="section-wrap menu-section">

        <div class="section-heading">
            <div>
                <div class="eyebrow"><span></span> NUESTRO CATÁLOGO</div>
                <h1>Descubre nuestros productos</h1>
            </div>

            <p>Conoce nuestra oferta, selecciona las cantidades y prepara tu pedido.</p>
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
                            <div>

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

                                <strong>
                                    $<?= number_format((float) $producto->Precio, 2) ?> NIO
                                </strong>

                            </div>

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
                        </article>

                    <?php endwhile; ?>

                <?php else: ?>

                    <p>Actualmente no hay productos disponibles.</p>

                <?php endif; ?>

            </div>

            <?php if ($productos && $productos->num_rows > 0): ?>

                <p class="compra-total">
                    Total estimado:
                    <strong data-compra-total>$0.00 NIO</strong>
                </p>

                <button type="submit">
                    Confirmar compra y generar recibo
                </button>

            <?php endif; ?>

        </form>

        <p style="margin-top: 25px;">
            <a href="index.php" class="button button-dark">
                Volver al inicio
            </a>
        </p>

    </main>

    <footer class="site-footer">
        <div class="brand footer-brand">
            <div class="brand-icon">☕</div>
            <strong>Cafetería</strong>
        </div>

        <p>Descubre nuestros productos.</p>
    </footer>

    <script src="public/js/compra.js" defer></script>

</body>
</html>