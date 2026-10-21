<?php
require_once "models/Configuracion.php";

class ConfiguracionController {
	public function index() {
		$configuraciones = Configuracion::obtenerTodos();
		require "views/configuraciones/index.php";
	}

	public function crear()
    {
        $editando = false;
        $configuracion = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $iva = $_POST['IVA'] ?? '';

            if (
                $iva === '' ||
                !is_numeric($iva) ||
                (float) $iva < 0 ||
                (float) $iva > 999.99
            ) {
                $error = "Introduce un valor de IVA válido.";

                $configuracion = (object) [
                    'IVA' => $iva
                ];

            } else {
                Configuracion::guardar((float) $iva);

                header(
                    "Location: index.php?controlador=configuracion&accion=index"
                );
                exit;
            }
        }
        require "views/configuraciones/formulario.php";
    }


    public function editar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !ctype_digit((string) $id)) {

            header(
                "Location: index.php?controlador=configuracion&accion=index"
            );
            exit;
        }
        $configuracion = Configuracion::obtenerPorId($id);

        if (!$configuracion) {

            header(
                "Location: index.php?controlador=configuracion&accion=index"
            );
            exit;
        }

        $editando = true;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $iva = $_POST['IVA'] ?? '';

            if (
                $iva === '' ||
                !is_numeric($iva) ||
                (float) $iva < 0 ||
                (float) $iva > 999.99
            ) {
                $error = "Introduce un valor de IVA válido.";

                $configuracion->IVA = $iva;

            } else {
                Configuracion::actualizar($id, (float) $iva);

                header(
                    "Location: index.php?controlador=configuracion&accion=index"
                );
                exit;
            }
        }
        require "views/configuraciones/formulario.php";
    }

	public function eliminar() {
		$id = $_GET['id'] ?? null;
		if ($id) {
			Configuracion::eliminar($id);
		}
		header("Location: index.php?controlador=configuracion&accion=index");
		exit;
	}
}
?>
