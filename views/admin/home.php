<!DOCTYPE html> 
<html lang="es"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Cafetería - Panel Principal</title> 
    <link rel="stylesheet" href="public/css/cafeteria.css"> 
</head> 
<body> 
    <header class="site-header"> 
        <div class="admin-brand">
            <img src="public/img/logo_cafe_aroma.png"
            alt="Logo de Café Aroma"
            class="admin-logo">
        </div>
    </header> 
 
    <section class="hero"> 
        <div class="hero-copy"> 
            <div class="eyebrow"><span></span> SISTEMA DE GESTIÓN INTERNA</div> 
            <h1>Bienvenido al Sistema de la <em>Cafetería</em></h1> 
            <p class="hero-description"> 
                Administra de forma rápida y sencilla los productos, categorías, clientes, empleados, sucursales y operaciones diarias del negocio. 
            </p> 
            <div class="hero-actions"> 
                <a href="index.php?controlador=producto&accion=index" class="button button-dark">Gestionar Productos</a> 
                <a href="index.php?controlador=venta&accion=index" class="button button-dark">Ver Ventas<span>&rarr;</span></a> 
            </div> 
        </div> 
 
        <div class="hero-art"> 
            <div class="coffee-cup"> 
                <div class="cup-rim"><span></span></div> 
                <div class="cup-body"><span class="cup-mark"></span></div> 
                <div class="cup-handle"></div> 
                <div class="cup-saucer"></div> 
            </div> 
        </div> 
    </section> 

    <!-- ==================================================
         DASHBOARD DE EMPLEADOS
    ================================================== -->
    <div class="dashboard-wrapper">
        <div class="dash-header">

    <h2 class="dash-title">Dashboard</h2>

    <p class="dash-subtitle">
        Comparación semanal:
        <strong>
            <?= htmlspecialchars($estadisticas['periodo_anterior']) ?>
        </strong>
        vs.
        <strong>
            <?= htmlspecialchars($estadisticas['periodo_actual']) ?>
        </strong>
    </p>

    </div>

        <!-- Tarjetas Superiores -->
        <div class="dash-cards-grid">
            <!-- 1. Ventas de la semana -->
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-icon">💰</div>
                    <span class="dash-card-title">Ventas de la semana</span>
                </div>
                <div class="dash-card-body">
                    <p class="dash-card-value" id="ventas-semana">C$ <?= number_format((int)($estadisticas['ventas_semana'] ?? 0)) ?></p>
                    <span id="variacion-ventas" class="dash-card-trend <?= (($estadisticas['variacion_ventas']['tipo'] ?? '') === 'subida') ? 'trend-up' : 'trend-neutral' ?>">
                        <?= htmlspecialchars($estadisticas['variacion_ventas']['texto'] ?? 'Sin datos') ?>
                    </span>
                </div>
            </div>

            <!-- 2. Clientes -->
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-icon">👥</div>
                    <span class="dash-card-title">Clientes</span>
                </div>
                <div class="dash-card-body">
                    <p class="dash-card-value" id="clientes-semana"><?= number_format((int)($estadisticas['clientes_semana'] ?? 0)) ?></p>
                    <span id="variacion-clientes" class="dash-card-trend <?= (($estadisticas['variacion_clientes']['tipo'] ?? '') === 'subida') ? 'trend-up' : 'trend-neutral' ?>">
                        <?= htmlspecialchars($estadisticas['variacion_clientes']['texto'] ?? 'Sin datos') ?>
                    </span>
                </div>
            </div>

            <!-- 3. Compras -->
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-icon">📦</div>
                    <span class="dash-card-title">Compras</span>
                </div>
                <div class="dash-card-body">
                    <p class="dash-card-value" id="compras-semana"><?= number_format((int)($estadisticas['compras_semana'] ?? 0)) ?></p>
                    <span id="variacion-compras" class="dash-card-trend <?= (($estadisticas['variacion_compras']['tipo'] ?? '') === 'subida') ? 'trend-up' : 'trend-neutral' ?>">
                        <?= htmlspecialchars($estadisticas['variacion_compras']['texto'] ?? 'Sin datos') ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Productos más vendidos con barra de progreso -->
        <div class="dash-section-card">
            <h3 class="dash-section-title">Productos más vendidos</h3>
            <p class="dash-section-desc">Artículos con mayor salida</p>

            <?php if (!empty($productosMasVendidos)): ?>
                <?php 
                    $maxUnidades = max(array_column($productosMasVendidos, 'unidades_vendidas'));
                    if ($maxUnidades <= 0) $maxUnidades = 1;
                ?>
                <div class="dash-product-list">

    <?php foreach ($productosMasVendidos as $prod):

        $porcentaje = ($prod['unidades_vendidas'] / $maxUnidades) * 100;

        $imagen = trim($prod['Imagen'] ?? '');

    ?>

        <div class="dash-product-item">

            <!-- Imagen del producto -->
            <div class="dash-product-image">

                <?php if (!empty($imagen)): ?>

                    <img
                        src="public/img/productos/<?= htmlspecialchars($imagen, ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($prod['Nombre'], ENT_QUOTES, 'UTF-8') ?>"
                        loading="lazy"
                    >

                <?php else: ?>

                    <div class="dash-product-no-image">
                        ☕
                    </div>

                <?php endif; ?>

            </div>

            <!-- Información y barra de ventas -->
            <div class="dash-product-content">

                <div class="dash-product-info">

                    <span>
                        <?= htmlspecialchars($prod['Nombre']) ?>
                    </span>

                    <strong>
                        <?= (int)$prod['unidades_vendidas'] ?>
                    </strong>

                </div>

                <div class="dash-product-bar-bg">

                    <div
                        class="dash-product-bar-fill"
                        style="width: <?= $porcentaje ?>%;">
                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>
            <?php else: ?>
                <p style="font-size: 12px; color: #77766d;">No hay registros de ventas para esta semana.</p>
            <?php endif; ?>
        </div>
    </div>
 
    <!-- ==================================================
         ACCESOS RÁPIDOS A MÓDULOS
    ================================================== -->
    <section class="section-wrap menu-section"> 
        <div class="section-heading"> 
            <div> 
                <div class="eyebrow"><span></span> MÓDULOS DEL SISTEMA</div> 
                <h2>Accesos Rápidos</h2> 
            </div> 
            <p>Selecciona el módulo que deseas administrar para continuar con tus tareas.</p> 
        </div> 
 
        <div class="menu-grid"> 
            <div class="menu-card"> 
                <div class="card-copy"> 
                    <span class="card-number">01</span> 
                    <h3>Productos</h3> 
                    <p>Control de stock, precios y descripción de artículos.</p> 
                    <a href="index.php?controlador=producto&accion=index" class="button button-dark">Entrar<span>&rarr;</span></a> 
                </div> 
            </div> 
 
            <div class="menu-card"> 
                <div class="card-copy"> 
                    <span class="card-number">02</span> 
                    <h3>Categorías</h3> 
                    <p>Organiza los productos por categorías y tipos.</p> 
                    <a href="index.php?controlador=categoria&accion=index" class="button button-dark">Entrar<span>&rarr;</span></a> 
                </div> 
            </div> 
 
            <div class="menu-card"> 
                <div class="card-copy"> 
                    <span class="card-number">03</span> 
                    <h3>Clientes</h3> 
                    <p>Base de datos y registro de clientes frecuentes.</p> 
                    <a href="index.php?controlador=cliente&accion=index" class="button button-dark">Entrar<span>&rarr;</span></a> 
                </div> 
            </div> 
 
            <div class="menu-card"> 
                <div class="card-copy"> 
                    <span class="card-number">04</span> 
                    <h3>Empleados</h3> 
                    <p>Gestión de personal y datos del equipo.</p> 
                    <a href="index.php?controlador=empleado&accion=index" class="button button-dark">Entrar<span>&rarr;</span></a> 
                </div> 
            </div> 
 
            <div class="menu-card"> 
                <div class="card-copy"> 
                    <span class="card-number">05</span> 
                    <h3>Sucursales</h3> 
                    <p>Ubicaciones y sucursales de la cafetería.</p> 
                    <a href="index.php?controlador=sucursal&accion=index" class="button button-dark">Entrar<span>&rarr;</span></a> 
                </div> 
            </div> 
 
            <div class="menu-card"> 
                <div class="card-copy"> 
                    <span class="card-number">06</span> 
                    <h3>Proveedores</h3> 
                    <p>Gestión de proveedores y compras de insumos.</p> 
                    <a href="index.php?controlador=proveedor&accion=index" class="button button-dark">Entrar<span>&rarr;</span></a> 
                </div> 
            </div> 
        </div> 
    </section> 
 
    <footer class="site-footer"> 
        <div class="brand footer-brand"> 
            <div class="brand-icon">☕</div> 
            <strong>Cafetería</strong> 
        </div> 
        <p>Sistema de administración <span>&bull;</span> Panel Principal</p> 
    </footer> 
</body> 
<script src="public/js/dashboard.js"></script>
</html>