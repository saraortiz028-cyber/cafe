<?php require_once __DIR__ . '/../auth.php'; ?>

<header class="admin-header">

<div class="admin-brand">
    <div class="admin-brand-icon">☕</div>
    <span>Cafetería</span>
</div>

<nav class="main-nav">

    <div class="nav-modules">
        <a href="index.php?controlador=venta&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'venta' ? 'active' : '' ?>">
            Ventas
        </a>
        <a href="index.php?controlador=compra&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'compra' ? 'active' : '' ?>">
            Compras
        </a>
        <a href="index.php?controlador=sucursal&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'sucursal' ? 'active' : '' ?>">
            Sucursales
        </a>
        <a href="index.php?controlador=cliente&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'cliente' ? 'active' : '' ?>">
            Clientes
        </a>
        <a href="index.php?controlador=empleado&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'empleado' ? 'active' : '' ?>">
            Empleados
        </a>
        <a href="index.php?controlador=cargo&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'cargo' ? 'active' : '' ?>">
            Cargos
        </a>
        <a href="index.php?controlador=proveedor&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'proveedor' ? 'active' : '' ?>">
            Proveedores
        </a>
        <a href="index.php?controlador=producto&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'producto' ? 'active' : '' ?>">
            Productos
        </a>
        <a href="index.php?controlador=categoria&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'categoria' ? 'active' : '' ?>">
            Categorías
        </a>
        <a href="index.php?controlador=configuracion&accion=index"
            class="<?= ($_GET['controlador'] ?? '') === 'configuracion' ? 'active' : '' ?>">
            Configuración
        </a>
    </div>

    <div class="nav-user">

        <?php if (Auth::estaAutenticado()): ?>

            <span class="nav-greeting">
                Hola, <?= htmlspecialchars(
                    $_SESSION['empleado']['Nombre'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </span>

            <form method="POST"
                  action="index.php?controlador=auth&accion=logout">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars(
                        Auth::csrfToken(),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

                <button type="submit"
                        class="button button-dark nav-logout">
                    Cerrar sesión
                </button>

            </form>

        <?php else: ?>

            <a href="index.php?controlador=auth&accion=login">
                Iniciar sesión
            </a>

        <?php endif; ?>

    </div>

</nav>