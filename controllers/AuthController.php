<?php

require_once "models/Empleado.php";

class AuthController
{
    public function login(): void
    {
        if (Auth::estaAutenticado()) {
            header("Location: index.php?controlador=sucursal&accion=index");
            exit;
        }

        $error = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $correo = trim($_POST['correo'] ?? '');
            $contrasena = $_POST['contrasena'] ?? '';

            if (!Auth::validarCsrf($_POST['csrf_token'] ?? null)) {
                $error = "La sesión del formulario venció. Intenta nuevamente.";
            } else {
                $empleado = Empleado::autenticar($correo, $contrasena);

                if ($empleado) {
                    session_regenerate_id(true);

                    $_SESSION['empleado'] = [
                        'IdEmpleado' => $empleado->IdEmpleado,
                        'Nombre' => $empleado->Nombre,
                        'Apellido' => $empleado->Apellido,
                        'Correo' => $empleado->Correo
                    ];

                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                    header("Location: index.php?controlador=sucursal&accion=index");
                    exit;
                }

                $error = "Correo o contraseña incorrectos.";
            }
        }

        require "views/auth/login.php";
    }

    public function logout(): void
    {
        if (
            ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
            && Auth::validarCsrf($_POST['csrf_token'] ?? null)
        ) {
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();

                setcookie(session_name(), '', [
                    'expires' => time() - 42000,
                    'path' => $params['path'],
                    'domain' => $params['domain'],
                    'secure' => $params['secure'],
                    'httponly' => $params['httponly'],
                    'samesite' => $params['samesite'] ?? 'Lax'
                ]);
            }

            session_destroy();
        }

        header("Location: index.php?controlador=auth&accion=login");
        exit;
    }
}