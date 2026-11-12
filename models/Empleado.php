<?php
require_once "config/database.php";

class Empleado {

    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM empleados");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT * FROM empleados WHERE IdEmpleado = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function correoExiste($correo, $excluirId = null) {
        $db = Database::conectar();

        if ($excluirId !== null) {
            $stmt = $db->prepare(
                "SELECT IdEmpleado FROM empleados
                 WHERE Correo = ? AND IdEmpleado != ? LIMIT 1"
            );
            $stmt->bind_param("si", $correo, $excluirId);
        } else {
            $stmt = $db->prepare(
                "SELECT IdEmpleado FROM empleados
                 WHERE Correo = ? LIMIT 1"
            );
            $stmt->bind_param("s", $correo);
        }

        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public static function guardar(
        $nombre, $apellido, $direccion, $telefono, $correo,
        $salario, $contrasena, $idCargo = null, $idSucursal = null
    ) {
        $db = Database::conectar();
        $fechaContratacion = date('Y-m-d');
        $passwordHash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $db->prepare(
            "INSERT INTO empleados
            (Nombre, Apellido, Direccion, Telefono, Correo, Salario,
             FechaContratacion, IdCargo, IdSucursal, PasswordHash)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssdsiss",
            $nombre, $apellido, $direccion, $telefono, $correo,
            $salario, $fechaContratacion, $idCargo, $idSucursal,
            $passwordHash
        );

        return $stmt->execute();
    }

    public static function actualizar(
        $id, $nombre, $apellido, $direccion, $telefono, $correo,
        $salario, $idCargo = null, $idSucursal = null
    ) {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "UPDATE empleados
             SET Nombre=?, Apellido=?, Direccion=?, Telefono=?,
                 Correo=?, Salario=?, IdCargo=?, IdSucursal=?
             WHERE IdEmpleado=?"
        );

        $stmt->bind_param(
            "sssssdsii",
            $nombre, $apellido, $direccion, $telefono, $correo,
            $salario, $idCargo, $idSucursal, $id
        );

        return $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "DELETE FROM empleados WHERE IdEmpleado = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function autenticar($correo, $contrasena) {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "SELECT IdEmpleado, Nombre, Apellido, Correo, PasswordHash
             FROM empleados WHERE Correo = ? LIMIT 1"
        );

        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $empleado = $stmt->get_result()->fetch_object();

        if (!$empleado || empty($empleado->PasswordHash)) {
            return false;
        }

        if (!password_verify($contrasena, $empleado->PasswordHash)) {
            return false;
        }

        unset($empleado->PasswordHash);
        return $empleado;
    }
}
?>