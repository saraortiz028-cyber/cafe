<?php require_once __DIR__ . '/../auth.php'; ?>
<nav class="main-nav">
    <a href="index.php?controlador=venta&accion=index">Ventas</a>
    <a href="index.php?controlador=compra&accion=index">Compras</a>
    <a href="index.php?controlador=sucursal&accion=index">Sucursales</a>
    <a href="index.php?controlador=cliente&accion=index">Clientes</a>
    <a href="index.php?controlador=empleado&accion=index">Empleados</a>
    <a href="index.php?controlador=cargo&accion=index">Cargos</a>
    <a href="index.php?controlador=proveedor&accion=index">Proveedores</a>
    <a href="index.php?controlador=producto&accion=index">Productos</a>
    <a href="index.php?controlador=categoria&accion=index">Categorías</a>
    <a href="index.php?controlador=configuracion&accion=index">Configuración</a>

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
                <button type="submit" class="button button-dark nav-logout">
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