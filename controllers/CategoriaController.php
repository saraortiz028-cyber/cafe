<?php
require_once "models/Categorias.php";

class CategoriaController {

	public function index() {
		$categorias = Categoria::obtenerTodos();
		require "views/categorias/index.php";
	}

	public function crear() {
		if ($_POST) {
			Categoria::guardar($_POST['nombre']);
			header("Location: index.php?controlador=categoria&accion=index");
			exit;
		}
		require "views/categorias/crear.php";
	}

	public function editar() {
		$id = isset($_GET['id']) ? $_GET['id'] : null;

		if (!$id) {
			header("Location: index.php?controlador=categoria&accion=index");
			exit();
		}

		if ($_POST) {
			Categoria::actualizar($id, $_POST['nombre']);
			header("Location: index.php?controlador=categoria&accion=index");
			exit();
		}

		$categoria = Categoria::obtenerPorId($id);
		require "views/categorias/editar.php";
	}

	public function eliminar() {
		$id = isset($_GET['id']) ? $_GET['id'] : null;
		if ($id) {
			Categoria::eliminar($id);
		}
		header("Location: index.php?controlador=categoria&accion=index");
		exit();
	}
}
?>
