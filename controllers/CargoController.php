<?php
require_once "models/Cargo.php";

class CargoController {
	public function index() {
		$cargos = Cargo::obtenerTodos();
		require "views/cargos/index.php";
	}

	public function crear() {
		if ($_POST) {
			Cargo::guardar($_POST['NombreCargo']);
			header("Location: index.php?controlador=cargo&accion=index");
			exit;
		}
		require "views/cargos/crear.php";
	}

	public function editar() {
		$id = $_GET['id'] ?? null;

		if (!$id) {
			header("Location: index.php?controlador=cargo&accion=index");
			exit;
		}

		if ($_POST) {
			Cargo::actualizar($id, $_POST['NombreCargo']);
			header("Location: index.php?controlador=cargo&accion=index");
			exit;
		}

		$cargo = Cargo::obtenerPorId($id);
		require "views/cargos/editar.php";
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
