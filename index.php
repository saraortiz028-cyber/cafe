<link rel="stylesheet" href="/Cafeteria/public/css/cafeteria.css">
<?php
require_once "config/database.php";

$controlador = $_GET['controlador'] ?? null;
$accion = $_GET['accion'] ?? 'index';



if ($controlador === null) {
    require_once "models/Cliente.php";
    require_once "models/Empleado.php";
    require_once "models/Categorias.php";
    require_once "models/Productos.php";
    require_once "models/Cargo.php";
    require_once "models/Proveedor.php";
    require_once "models/Configuracion.php";
    
    $clientes = Cliente::obtenerTodos();
    $empleados = Empleado::obtenerTodos();
    $categorias = Categoria::obtenerTodos();
    $productos = Producto::obtenerTodos();
    $cargos = Cargo::obtenerTodos();
    $proveedores = Proveedor::obtenerTodos();
    $configuraciones = Configuracion::obtenerTodos();
    
    require_once "views/principal.php";
    exit;
}

if ($controlador == 'empleado') {
    require_once "controllers/EmpleadoController.php";
    $controladorInstanciado = new EmpleadoController();
    $controladorInstanciado->$accion();
} 

else if ($controlador == 'cliente') {
    require_once "controllers/ClienteController.php";
    $controladorInstanciado = new ClienteController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'proveedor') {
    require_once "controllers/ProveedorController.php";
    $controladorInstanciado = new ProveedorController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'configuracion') {
    require_once "controllers/ConfiguracionController.php";
    $controladorInstanciado = new ConfiguracionController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'categoria') {
    require_once "controllers/CategoriaController.php";
    $controladorInstanciado = new CategoriaController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'cargo') {
    require_once "controllers/CargoController.php";
    $controladorInstanciado = new CargoController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'sucursal') {
    require_once "controllers/SucursalController.php";
    $controladorInstanciado = new SucursalController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'compra') {
    require_once "controllers/Compra_y_DetalleController.php";
    $controladorInstanciado = new CompraController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'producto') {
    require_once "controllers/ProductoController.php";
    $controladorInstanciado = new ProductoController();
    $controladorInstanciado->$accion();
}

else if ($controlador == 'venta') {
    require_once "controllers/Venta_y_DetalleController.php";
    $controladorInstanciado = new VentaController();
    $controladorInstanciado->$accion();
}
?>