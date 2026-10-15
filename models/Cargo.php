<?php
require_once "config/database.php";

class Cargo {
    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM cargos");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM cargos WHERE IdCargo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($nombreCargo) {
        $db = Database::conectar();
        $stmt = $db->prepare("INSERT INTO cargos (NombreCargo) VALUES (?)");
        $stmt->bind_param("s", $nombreCargo);
        $stmt->execute();
    }

    public static function actualizar($id, $nombreCargo) {
        $db = Database::conectar();
        $stmt = $db->prepare("UPDATE cargos SET NombreCargo = ? WHERE IdCargo = ?");
        $stmt->bind_param("si", $nombreCargo, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM cargos WHERE IdCargo = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>