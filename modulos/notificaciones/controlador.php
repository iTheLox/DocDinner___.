<?php
// modulos/notificaciones/controlador.php

// Asegúrate de que la sesión esté iniciada. Si ya está en index.php, esta línea es redundante.
// if (session_status() == PHP_SESSION_NONE) { session_start(); }

include 'modulos/notificaciones/modelo.php';

class NotificacionesController {
    private $notificacionesModel;

    public function __construct(PDO $conn) {
        $this->notificacionesModel = new Notificaciones($conn);
    }

    public function notificaciones() {
        // ** Verificación de autenticación y obtención del usuario_id **
        if (!isset($_SESSION['usuario_id'])) {
            // Redirige al login si el usuario no está autenticado
            header("Location: index.php?ruta=login");
            exit("⚠️ Error: Usuario no autenticado para ver notificaciones.");
        }

        $usuario_id = $_SESSION['usuario_id']; // Obtén el ID del usuario de la sesión

        $hoy = date('Y-m-d');
        $proximos_7_dias = date('Y-m-d', strtotime('+7 days'));
        
        // Metas vencidas pero no cumplidas (filtradas por usuario)
        $vencidas = $this->notificacionesModel->obtenerMetasVencidasNoCumplidas($hoy, $usuario_id);

        // Metas próximas a vencer (menos de 7 días, filtradas por usuario)
        $proximas = $this->notificacionesModel->obtenerMetasProximasAVencer($hoy, $proximos_7_dias, $usuario_id);

        // Metas cumplidas (filtradas por usuario)
        $cumplidas = $this->notificacionesModel->obtenerMetasCumplidas($usuario_id);

        // Metas sin progreso (filtradas por usuario)
        $sinProgreso = $this->notificacionesModel->obtenerMetasSinProgreso($usuario_id);

        include 'modulos/notificaciones/vista/notificaciones.php';
    }
}
?>