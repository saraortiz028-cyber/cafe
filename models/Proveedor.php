<?php
require_once "config/database.php";

class Proveedor {
	public static function obtenerTodos() {
		$db = Database::conectar();
		return $db->query("SELECT * FROM proveedores");
	}

	public static function obtenerPorId($id) {
		$db = Database::conectar();
		$stmt = $db->prepare("SELECT * FROM proveedores WHERE IdProveedor = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		return $stmt->get_result()->fetch_object();
	}

	public static function guardar($nombre, $telefono, $correo, $direccion) {
		$db = Database::conectar();
		$stmt = $db->prepare("INSERT INTO proveedores (Nombre, Telefono, Correo, Direccion) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $nombre, $telefono, $correo, $direccion);
		$stmt->execute();
	}

	public static function actualizar($id, $nombre, $telefono, $correo, $direccion) {
		$db = Database::conectar();
		$stmt = $db->prepare("UPDATE proveedores SET Nombre = ?, Telefono = ?, Correo = ?, Direccion = ? WHERE IdProveedor = ?");
		$stmt->bind_param("ssssi", $nombre, $telefono, $correo, $direccion, $id);
		$stmt->execute();
	}

	public static function eliminar($id) {
		$db = Database::conectar();
		$stmt = $db->prepare("DELETE FROM proveedores WHERE IdProveedor = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
	}
}
?>
