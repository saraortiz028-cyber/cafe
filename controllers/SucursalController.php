<?php
require_once "auth.php";
require_once "models/Sucursal.php";

class SucursalController {
    private function verificarAcceso() {
    if (!Auth::estaAutenticado()) {
        header("Location: index.php?controlador=auth&accion=login");
        exit;
    }
}

    public function index() {
        $this->verificarAcceso();
        $sucursales = Sucursal::obtenerTodos();
        require "views/sucursales/index.php";
    }

    public function crear() {
        $this->verificarAcceso();
        $sucursal = null;
        $error = null;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {

        if (!Auth::validarCsrf($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Solicitud no válida. Recarga el formulario e inténtalo nuevamente.');
}

            $nombre = trim($_POST['nombre'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            if ($nombre === '' || $direccion === '') {
                $error = 'El nombre y la dirección son obligatorios.';
                $sucursal = (object) ['Nombre' => $nombre, 'Direccion' => $direccion];
            } else {
                Sucursal::guardar($nombre, $direccion);
                header("Location: index.php?controlador=sucursal&accion=index");
                exit;
            }
        }
        require "views/sucursales/formulario.php";
    }

    public function editar() {
        $this->verificarAcceso();
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $sucursal = $id ? Sucursal::obtenerPorId($id) : null;
        if (!$sucursal) {
            http_response_code(404);
            echo "La sucursal solicitada no existe.";
            return;
        }
        $error = null;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {

        if (!Auth::validarCsrf($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Solicitud no válida. Recarga el formulario e inténtalo nuevamente.');
}

            $nombre = trim($_POST['nombre'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            if ($nombre === '' || $direccion === '') {
                $error = 'El nombre y la dirección son obligatorios.';
                $sucursal->Nombre = $nombre;
                $sucursal->Direccion = $direccion;
            } else {
                Sucursal::actualizar($id, $nombre, $direccion);
                header("Location: index.php?controlador=sucursal&accion=index");
                exit;
            }
        }
        require "views/sucursales/formulario.php";
    }

    public function eliminar() { 
        $this->verificarAcceso(); 
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); 
        if ($id) {
            Sucursal::eliminar($id); 
            } 
            header("Location: index.php?controlador=sucursal&accion=index"); 
            exit; 
            } 
        }