<?php
require_once "config/database.php";
require_once "auth.php";

Auth::iniciarSesion();

$controlador = $_GET['controlador'] ?? null;
$accion = $_GET['accion'] ?? 'index';

if ($controlador === null) {
    require_once "views/home.php";
    exit;
}

if ($controlador === 'auth') {
    require_once "controllers/AuthController.php";
    $controladorInstanciado = new AuthController();

    if (in_array($accion, ['login', 'logout'], true)) {
        $controladorInstanciado->$accion();
    } else {
        http_response_code(404);
        echo "Acción no encontrada";
    }
}

else if ($controlador == 'empleado') {
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

else {
    http_response_code(404);
    echo "Controlador no encontrado";
}
?>