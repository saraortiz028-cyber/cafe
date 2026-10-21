<?php
require_once "models/Proveedor.php";

class ProveedorController {
	public function index() {
		$proveedores = Proveedor::obtenerTodos();
		require "views/proveedores/index.php";
	}

	public function crear() {
        $editando = false;
        $proveedor = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = trim($_POST['Nombre'] ?? '');
            $telefono = trim($_POST['Telefono'] ?? '');
            $correo = trim($_POST['Correo'] ?? '');
            $direccion = trim($_POST['Direccion'] ?? '');

            if ($nombre === '' || $telefono === '') {

                $error = "El nombre y el teléfono son obligatorios.";

                $proveedor = (object) [
                    'Nombre' => $nombre,
                    'Telefono' => $telefono,
                    'Correo' => $correo,
                    'Direccion' => $direccion
                ];
            } else {
                Proveedor::guardar(
                    $nombre,
                    $telefono,
                    $correo,
                    $direccion
                );

                header(
                    "Location: index.php?controlador=proveedor&accion=index"
                );
                exit;
            }
        }
        require "views/proveedores/formulario.php";
    }

    public function editar() {
        $id = $_GET['id'] ?? null;

        if (!$id || !ctype_digit((string) $id)) {
            header(
                "Location: index.php?controlador=proveedor&accion=index"
            );
            exit;
        }

        $proveedor = Proveedor::obtenerPorId($id);

        if (!$proveedor) {
            header(
                "Location: index.php?controlador=proveedor&accion=index"
            );
            exit;
        }

        $editando = true;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = trim($_POST['Nombre'] ?? '');
            $telefono = trim($_POST['Telefono'] ?? '');
            $correo = trim($_POST['Correo'] ?? '');
            $direccion = trim($_POST['Direccion'] ?? '');

            if ($nombre === '' || $telefono === '') {

                $error = "El nombre y el teléfono son obligatorios.";

                $proveedor->Nombre = $nombre;
                $proveedor->Telefono = $telefono;
                $proveedor->Correo = $correo;
                $proveedor->Direccion = $direccion;

            } else {
                Proveedor::actualizar(
                    $id,
                    $nombre,
                    $telefono,
                    $correo,
                    $direccion
                );

                header(
                    "Location: index.php?controlador=proveedor&accion=index"
                );
                exit;
            }
        }

        require "views/proveedores/formulario.php";
    }

	public function eliminar() {
		$id = $_GET['id'] ?? null;
		if ($id) {
			Proveedor::eliminar($id);
		}
		header("Location: index.php?controlador=proveedor&accion=index");
		exit;
	}
}
?>
