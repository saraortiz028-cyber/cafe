<?php
require_once "models/Configuracion.php";

class ConfiguracionController {
	public function index() {
		$configuraciones = Configuracion::obtenerTodos();
		require "views/configuraciones/index.php";
	}

	public function crear() {
		if ($_POST) {
			Configuracion::guardar((float) $_POST['IVA']);
			header("Location: index.php?controlador=configuracion&accion=index");
			exit;
		}
		require "views/configuraciones/crear.php";
	}

	public function editar() {
		$id = $_GET['id'] ?? null;
		if (!$id) {
			header("Location: index.php?controlador=configuracion&accion=index");
			exit;
		}

		if ($_POST) {
			Configuracion::actualizar($id, (float) $_POST['IVA']);
			header("Location: index.php?controlador=configuracion&accion=index");
			exit;
		}

		$configuracion = Configuracion::obtenerPorId($id);
		if (!$configuracion) {
			header("Location: index.php?controlador=configuracion&accion=index");
			exit;
		}
		require "views/configuraciones/editar.php";
	}

	public function eliminar() {
		$id = $_GET['id'] ?? null;
		if ($id) {
			Configuracion::eliminar($id);
		}
		header("Location: index.php?controlador=configuracion&accion=index");
		exit;
	}
}
?>
