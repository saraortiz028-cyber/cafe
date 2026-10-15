<?php
require_once "models/Proveedor.php";

class ProveedorController {
	public function index() {
		$proveedores = Proveedor::obtenerTodos();
		require "views/proveedores/index.php";
	}

	public function crear() {
		if ($_POST) {
			Proveedor::guardar(
				$_POST['Nombre'],
				$_POST['Telefono'],
				$_POST['Correo'] ?? '',
				$_POST['Direccion'] ?? ''
			);
			header("Location: index.php?controlador=proveedor&accion=index");
			exit;
		}
		require "views/proveedores/crear.php";
	}

	public function editar() {
		$id = $_GET['id'] ?? null;
		if (!$id) {
			header("Location: index.php?controlador=proveedor&accion=index");
			exit;
		}

		if ($_POST) {
			Proveedor::actualizar(
				$id,
				$_POST['Nombre'],
				$_POST['Telefono'],
				$_POST['Correo'] ?? '',
				$_POST['Direccion'] ?? ''
			);
			header("Location: index.php?controlador=proveedor&accion=index");
			exit;
		}

		$proveedor = Proveedor::obtenerPorId($id);
		if (!$proveedor) {
			header("Location: index.php?controlador=proveedor&accion=index");
			exit;
		}
		require "views/proveedores/editar.php";
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
