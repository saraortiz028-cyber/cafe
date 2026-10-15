<?php
require_once "config/database.php";

class Configuracion {
	public static function obtenerTodos() {
		$db = Database::conectar();
		return $db->query("SELECT * FROM configuracion");
	}

	public static function obtenerPorId($id) {
		$db = Database::conectar();
		$stmt = $db->prepare("SELECT * FROM configuracion WHERE IdConfiguracion = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		return $stmt->get_result()->fetch_object();
	}

	public static function guardar($iva) {
		$db = Database::conectar();
		$stmt = $db->prepare("INSERT INTO configuracion (IVA) VALUES (?)");
		$stmt->bind_param("d", $iva);
		$stmt->execute();
	}

	public static function actualizar($id, $iva) {
		$db = Database::conectar();
		$stmt = $db->prepare("UPDATE configuracion SET IVA = ? WHERE IdConfiguracion = ?");
		$stmt->bind_param("di", $iva, $id);
		$stmt->execute();
	}

	public static function eliminar($id) {
		$db = Database::conectar();
		$stmt = $db->prepare("DELETE FROM configuracion WHERE IdConfiguracion = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
	}
}
?>
