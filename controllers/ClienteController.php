<?php
require_once "models/Cliente.php";

class ClienteController {

    public function index() {
        $clientes = Cliente::obtenerTodos();
        require "views/clientes/index.php";
    }

    public function crear()
    {
        $editando = false;

        $cliente = null;

        $error = null;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombres   = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $telefono  = trim($_POST['telefono'] ?? '');
            $correo    = trim($_POST['correo'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');


            if ($nombres === '' || $apellidos === '') {

                $error = "Los nombres y apellidos son obligatorios.";

                $cliente = (object) [
                    'nombres'   => $nombres,
                    'apellidos' => $apellidos,
                    'telefono'  => $telefono,
                    'correo'    => $correo,
                    'direccion' => $direccion
                ];
            } else {
                Cliente::guardar(
                    $nombres,
                    $apellidos,
                    $telefono,
                    $correo,
                    $direccion
                );
                header(
                    "Location: index.php?controlador=cliente&accion=index"
                );
                exit();
            }
        }
        require "views/clientes/formulario.php";
    }


    public function editar()
    {
        $id = $_GET['id'] ?? null;


        if (!$id) {

            header(
                "Location: index.php?controlador=cliente&accion=index"
            );
            exit();
        }


        $cliente = Cliente::obtenerPorId($id);


        if (!$cliente) {

            header(
                "Location: index.php?controlador=cliente&accion=index"
            );
            exit();
        }


        $editando = true;

        $error = null;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombres   = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $telefono  = trim($_POST['telefono'] ?? '');
            $correo    = trim($_POST['correo'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');


            if ($nombres === '' || $apellidos === '') {

                $error = "Los nombres y apellidos son obligatorios.";

                $cliente->nombres   = $nombres;
                $cliente->apellidos = $apellidos;
                $cliente->telefono  = $telefono;
                $cliente->correo    = $correo;
                $cliente->direccion = $direccion;

            } else {

                Cliente::actualizar(
                    $id,
                    $nombres,
                    $apellidos,
                    $telefono,
                    $correo,
                    $direccion
                );

                header(
                    "Location: index.php?controlador=cliente&accion=index"
                );
                exit();
            }
        }


        require "views/clientes/formulario.php";
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