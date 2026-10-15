<?php
require_once "models/Sucursal.php";

class SucursalController {
    public function index() {
        $sucursales = Sucursal::obtenerTodos();
        require "views/sucursales/index.php";
    }

    public function crear() {
        $sucursal = null;
        $error = null;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
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
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $sucursal = $id ? Sucursal::obtenerPorId($id) : null;
        if (!$sucursal) {
            http_response_code(404);
            echo "La sucursal solicitada no existe.";
            return;
        }
        $error = null;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
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
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            Sucursal::eliminar($id);
        }
        header("Location: index.php?controlador=sucursal&accion=index");
        exit;
    }
}
