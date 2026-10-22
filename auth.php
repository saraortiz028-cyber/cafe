<?php

class Auth
{
    public static function iniciarSesion(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        ini_set('session.use_strict_mode', '1');

        session_set_cookie_params([
            'httponly' => true,
            'secure' => !empty($_SERVER['HTTPS'])
                && $_SERVER['HTTPS'] !== 'off',
            'samesite' => 'Lax'
        ]);

        session_start();

        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function estaAutenticado(): bool
    {
        return isset($_SESSION['empleado'])
            && is_array($_SESSION['empleado']);
    }

    public static function csrfToken(): string
    {
        return $_SESSION['csrf_token'];
    }

    public static function validarCsrf(?string $token): bool
    {
        return is_string($token)
            && isset($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}