<?php
require_once "config/database.php";

class Sucursal {
    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM sucursales ORDER BY Nombre");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM sucursales WHERE IdSucursal = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($nombre, $direccion) {
        $db = Database::conectar();
        $stmt = $db->prepare("INSERT INTO sucursales (Nombre, Direccion) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $direccion);
        $stmt->execute();
    }

    public static function actualizar($id, $nombre, $direccion) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "UPDATE sucursales SET Nombre = ?, Direccion = ? WHERE IdSucursal = ?"
        );
        $stmt->bind_param("ssi", $nombre, $direccion, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM sucursales WHERE IdSucursal = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
