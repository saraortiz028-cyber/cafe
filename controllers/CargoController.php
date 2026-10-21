<?php
require_once "models/Cargo.php";

class CargoController {
	public function index() {
		$cargos = Cargo::obtenerTodos();
		require "views/cargos/index.php";
	}
 
	public function crear() {
    $editando = false;
    $cargo = null;
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Cargo::guardar($_POST['NombreCargo']);
        header("Location: index.php?controlador=cargo&accion=index");
        exit;
    }

    require "views/cargos/formulario.php";
}

public function editar() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?controlador=cargo&accion=index");
        exit;
    }

    $cargo = Cargo::obtenerPorId($id);

    if (!$cargo) {
        header("Location: index.php?controlador=cargo&accion=index");
        exit;
    }

    $editando = true;
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        Cargo::actualizar($id, $_POST['NombreCargo']);
        header("Location: index.php?controlador=cargo&accion=index");
        exit;
    }

    require "views/cargos/formulario.php";
}

	public function eliminar() {
		$id = $_GET['id'] ?? null;
		if ($id) {
			Cargo::eliminar($id);
		}
		header("Location: index.php?controlador=cargo&accion=index");
		exit;
	}
}
?>
