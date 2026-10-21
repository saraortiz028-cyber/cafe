<?php
require_once "models/Empleado.php";

class EmpleadoController {

    public function index() {
        $empleados = Empleado::obtenerTodos();
        require "views/empleados/index.php";
    }

    public function crear()
    {
        $editando = false;
        $empleado = null;
        $error = null;

        $db = Database::conectar();

        $cargos = $db->query(
            "SELECT IdCargo, NombreCargo
             FROM cargos
             ORDER BY NombreCargo"
        );
        $sucursales = $db->query(
            "SELECT IdSucursal, Nombre
             FROM sucursales
             ORDER BY Nombre"
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre    = trim($_POST['nombre'] ?? '');
            $apellido  = trim($_POST['apellido'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono  = trim($_POST['telefono'] ?? '');
            $correo    = trim($_POST['correo'] ?? '');
            $salario   = $_POST['salario'] ?? '';
            $id_cargo  = $_POST['id_cargo'] ?? null;
            $id_sucursal = $_POST['id_sucursal'] ?? null;


            if ($nombre === '' || $apellido === '') {

                $error = "El nombre y el apellido son obligatorios.";

                $empleado = (object) [
                    'nombre'      => $nombre,
                    'apellido'    => $apellido,
                    'direccion'   => $direccion,
                    'telefono'    => $telefono,
                    'correo'      => $correo,
                    'salario'     => $salario,
                    'id_cargo'    => $id_cargo,
                    'id_sucursal' => $id_sucursal
                ];
            } else {
                Empleado::guardar(
                    $nombre,
                    $apellido,
                    $direccion,
                    $telefono,
                    $correo,
                    $salario,
                    $id_cargo,
                    $id_sucursal
                );

                header(
                    "Location: index.php?controlador=empleado&accion=index"
                );
                exit;
            }
        }
        require "views/empleados/formulario.php";
    }


    public function editar()
    {
        $id = $_GET['id'] ?? null;


        if (!$id) {

            header(
                "Location: index.php?controlador=empleado&accion=index"
            );
            exit;
        }

        $empleado = Empleado::obtenerPorId($id);


        if (!$empleado) {

            header(
                "Location: index.php?controlador=empleado&accion=index"
            );
            exit;
        }


        $editando = true;
        $error = null;

        $db = Database::conectar();

        $cargos = $db->query(
            "SELECT IdCargo, NombreCargo
             FROM cargos
             ORDER BY NombreCargo"
        );

        $sucursales = $db->query(
            "SELECT IdSucursal, Nombre
             FROM sucursales
             ORDER BY Nombre"
        );

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre    = trim($_POST['nombre'] ?? '');
            $apellido  = trim($_POST['apellido'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono  = trim($_POST['telefono'] ?? '');
            $correo    = trim($_POST['correo'] ?? '');
            $salario   = $_POST['salario'] ?? '';
            $id_cargo  = $_POST['id_cargo'] ?? null;
            $id_sucursal = $_POST['id_sucursal'] ?? null;


            if ($nombre === '' || $apellido === '') {

                $error = "El nombre y el apellido son obligatorios.";

                $empleado->nombre      = $nombre;
                $empleado->apellido    = $apellido;
                $empleado->direccion   = $direccion;
                $empleado->telefono    = $telefono;
                $empleado->correo      = $correo;
                $empleado->salario     = $salario;
                $empleado->id_cargo    = $id_cargo;
                $empleado->id_sucursal = $id_sucursal;

            } else {

                Empleado::actualizar(
                    $id,
                    $nombre,
                    $apellido,
                    $direccion,
                    $telefono,
                    $correo,
                    $salario,
                    $id_cargo,
                    $id_sucursal
                );

                header(
                    "Location: index.php?controlador=empleado&accion=index"
                );
                exit;
            }
        }


        require "views/empleados/formulario.php";
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