<?php
require_once "models/Empleado.php";

class EmpleadoController {

    public function index() {
        $empleados = Empleado::obtenerTodos();
        require "views/empleados/index.php";
    }

    public function crear() {
        if ($_POST) {
            Empleado::guardar(
                $_POST['nombre'], 
                $_POST['apellido'],
                $_POST['direccion'], 
                $_POST['telefono'],
                $_POST['correo'], 
                $_POST['salario'],
                $_POST['id_cargo'] ?? null,
                $_POST['id_sucursal'] ?? null
            );
            header("Location: index.php?controlador=empleado");
            exit;
        }
        require "views/empleados/crear.php";
    }

    public function editar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            header("Location: index.php?controlador=empleado");
            exit();
        }

        if ($_POST) {
            Empleado::actualizar(
                $id, 
                $_POST['nombre'], 
                $_POST['apellido'],
                $_POST['direccion'], 
                $_POST['telefono'],
                $_POST['correo'], 
                $_POST['salario'],
                $_POST['id_cargo'] ?? null,
                $_POST['id_sucursal'] ?? null
            );
            header("Location: index.php?controlador=empleado&accion=index");
            exit();
        }

        $empleado = Empleado::obtenerPorId($id);
        require "views/empleados/editar.php";
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            Empleado::eliminar($id);
        }
        header("Location: index.php?controlador=empleado&accion=index");
        exit();
    }
}
?>