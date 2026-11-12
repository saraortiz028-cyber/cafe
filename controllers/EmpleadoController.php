<?php
require_once "models/Empleado.php";

class EmpleadoController {

    public function index() {
        $empleados = Empleado::obtenerTodos();
        require "views/empleados/index.php";
    }

    public function crear() {
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
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $salario = $_POST['salario'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $id_cargo = $_POST['id_cargo'] ?? null;
            $id_sucursal = $_POST['id_sucursal'] ?? null;

            if ($nombre === '' || $apellido === '') {
                $error = "El nombre y el apellido son obligatorios.";
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = "Ingresa un correo electrónico válido.";
            } elseif (Empleado::correoExiste($correo)) {
                $error = "Ya existe un empleado registrado con ese correo.";
            } elseif (strlen($contrasena) < 8) {
                $error = "La contraseña debe tener al menos 8 caracteres.";
            } else {
                $guardado = Empleado::guardar(
                    $nombre,
                    $apellido,
                    $direccion,
                    $telefono,
                    $correo,
                    $salario,
                    $contrasena,
                    $id_cargo,
                    $id_sucursal
                );

                if ($guardado) {
                    header(
                        "Location: index.php?controlador=empleado&accion=index"
                    );
                    exit;
                }

                $error = "No se pudo guardar el empleado.";
            }

            $empleado = (object) [
                'Nombre' => $nombre,
                'Apellido' => $apellido,
                'Direccion' => $direccion,
                'Telefono' => $telefono,
                'Correo' => $correo,
                'Salario' => $salario,
                'IdCargo' => $id_cargo,
                'IdSucursal' => $id_sucursal
            ];
        }

        require "views/empleados/formulario.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header("Location: index.php?controlador=empleado&accion=index");
            exit;
        }

        $empleado = Empleado::obtenerPorId($id);

        if (!$empleado) {
            header("Location: index.php?controlador=empleado&accion=index");
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
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $salario = $_POST['salario'] ?? '';
            $id_cargo = $_POST['id_cargo'] ?? null;
            $id_sucursal = $_POST['id_sucursal'] ?? null;

            if ($nombre === '' || $apellido === '') {
                $error = "El nombre y el apellido son obligatorios.";
            } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = "Ingresa un correo electrónico válido.";
            } elseif (Empleado::correoExiste($correo, $id)) {
                $error = "Ese correo ya pertenece a otro empleado.";
            } else {
                $actualizado = Empleado::actualizar(
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

                if ($actualizado) {
                    header(
                        "Location: index.php?controlador=empleado&accion=index"
                    );
                    exit;
                }

                $error = "No se pudo actualizar el empleado.";
            }

            $empleado->Nombre = $nombre;
            $empleado->Apellido = $apellido;
            $empleado->Direccion = $direccion;
            $empleado->Telefono = $telefono;
            $empleado->Correo = $correo;
            $empleado->Salario = $salario;
            $empleado->IdCargo = $id_cargo;
            $empleado->IdSucursal = $id_sucursal;
        }

        require "views/empleados/formulario.php";
    }

    public function eliminar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            Empleado::eliminar($id);
        }

        header("Location: index.php?controlador=empleado&accion=index");
        exit;
    }
}
?>