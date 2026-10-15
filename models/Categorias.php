<?php
require_once "config/database.php";

class Categoria {
	public static function obtenerTodos() {
		$db = Database::conectar();
		return $db->query("SELECT * FROM categorias");
	}

	public static function obtenerPorId($id) {
		$db = Database::conectar();
		$stmt = $db->prepare("SELECT * FROM categorias WHERE IdCategoria = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		return $stmt->get_result()->fetch_object();
	}

	public static function guardar($nombre) {
		$db = Database::conectar();
		$stmt = $db->prepare("INSERT INTO categorias(Nombre) VALUES (?)");
		$stmt->bind_param("s", $nombre);
		$stmt->execute();
	}

	public static function actualizar($id, $nombre) {
		$db = Database::conectar();
		$stmt = $db->prepare("UPDATE categorias SET Nombre=? WHERE IdCategoria=?");
		$stmt->bind_param("si", $nombre, $id);
		$stmt->execute();
	}

	public static function eliminar($id) {
		$db = Database::conectar();
		$stmt = $db->prepare("DELETE FROM categorias WHERE IdCategoria = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
	}
}
?>
