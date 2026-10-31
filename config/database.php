<?php

// Configurar zona horaria de toda la aplicación
date_default_timezone_set('America/Managua');

class Database {
    public static function conectar() {
        return new mysqli("localhost", "root", "", "bbdd_final", 3307);
    }
}
?>