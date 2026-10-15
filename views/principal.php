
<head>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>

<?php
// index.php (en la raíz de Cafeteria)
$controlador = $_GET['controlador'] ?? 'principal';
$accion = $_GET['accion'] ?? 'index';

// Mapeo simple de controladores
switch ($controlador) {
    case 'cliente':
        require_once "controllers/ClienteController.php";
        $cont = new ClienteController();
        break;
    case 'empleado':
        require_once "controllers/EmpleadoController.php";
        $cont = new EmpleadoController();
        break;
    case 'producto':
        require_once "controllers/ProductoController.php";
        $cont = new ProductoController();
        break;
    case 'categoria':
        require_once "controllers/CategoriaController.php";
        $cont = new CategoriaController();
        break;
    case 'cargo':
        require_once "controllers/CargoController.php";
        $cont = new CargoController();
        break;
    case 'proveedor':
        require_once "controllers/ProveedorController.php";
        $cont = new ProveedorController();
        break;
    case 'sucursal':
        require_once "controllers/SucursalController.php";
        $cont = new SucursalController();
        break;
    case 'compra':
        require_once "controllers/Compra_y_DetalleController.php";
        $cont = new CompraController();
        break;
    case 'venta':
        require_once "controllers/Venta_y_DetalleController.php";
        $cont = new VentaController();
        break;
    case 'configuracion':
        require_once "controllers/ConfiguracionController.php";
        $cont = new ConfiguracionController();
        break;
    default:
        // Vista principal o panel de navegación por enlace
        require_once "controllers/ClienteController.php"; // O un controlador general que cargue principal.php
        $cont = new ClienteController();
        $accion = 'index';
        break;
}

if (method_exists($cont, $accion)) {
    $cont->$accion();
} else {
    echo "Acción no encontrada";
}
?>