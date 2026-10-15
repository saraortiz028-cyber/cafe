<?php
require_once "models/Cliente.php";

class ClienteController {

    public function index() {
        $clientes = Cliente::obtenerTodos();
        require "views/clientes/index.php";
    }

    public function crear() {
        if ($_POST) {
            Cliente::guardar(
                $_POST['nombres'], 
                $_POST['apellidos'], 
                $_POST['telefono'], 
                $_POST['correo'], 
                $_POST['direccion']
            );
            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }
        require "views/clientes/crear.php";
    }

    public function editar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if ($_POST) {
            Cliente::actualizar(
                $id, 
                $_POST['nombres'], 
                $_POST['apellidos'], 
                $_POST['telefono'], 
                $_POST['correo'], 
                $_POST['direccion']
            );
            header("Location: index.php?controlador=cliente&accion=index");
            exit();
        }

        $cliente = Cliente::obtenerPorId($id);
        require "views/clientes/editar.php";
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            Cliente::eliminar($id);
        }
        header("Location: index.php?controlador=cliente&accion=index");
        exit();
    }
}
?>