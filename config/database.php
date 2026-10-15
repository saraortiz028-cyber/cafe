<?php
class Database {
    public static function conectar() {
        return new mysqli("localhost", "root", "", "bbdd_final", 3307);
    }
}
?>