<?php
// modulos/ahorro/controlador.php

// Cargar Dompdf (ajusta la ruta si tu proyecto tiene diferente estructura)
require_once 'C:/xampp/htdocs/docdinner-main/vendor/autoload.php';

use Dompdf\Dompdf;

include 'modulos/ahorro/modelo.php';

class AhorroController {
    private $metaAhorroModel;

    public function __construct($db) {
        $this->metaAhorroModel = new MetaAhorro($db);
    }

    public function ahorro() {
        $rutaVista = __DIR__ . '/vista/';

        try {
            if (!isset($_SESSION['usuario_id'])) {
                header("Location: index.php?ruta=login");
                exit("⚠️ Error: Usuario no autenticado.");
            }

            $usuario_id = $_SESSION['usuario_id'];

            if (isset($_GET['accion'])) {
                $accion = $_GET['accion'];

                switch ($accion) {
                    case 'crear':
                        include $rutaVista . 'crear.php';
                        return;

                    case 'eliminar':
                        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($id) {
                            $this->metaAhorroModel->eliminarMetaPorId($id, $usuario_id);
                        }
                        // Redirigir siempre después de la acción, sin mensaje en URL
                        header("Location: index.php?ruta=main&modulo=ahorro");
                        exit;

                    case 'editar':
                        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($id) {
                            $meta = $this->metaAhorroModel->obtenerMetaPorId($id, $usuario_id);
                            if ($meta) {
                                include $rutaVista . 'editar.php';
                                return;
                            }
                        }
                        header("Location: index.php?ruta=main&modulo=ahorro"); // Redirigir si ID inválido o meta no encontrada
                        exit;

                    case 'ahorroGuardar':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $meta_id = filter_input(INPUT_POST, 'meta_id', FILTER_VALIDATE_INT);
                            $cantidad_ahorrada = filter_input(INPUT_POST, 'cantidad_ahorrada', FILTER_VALIDATE_FLOAT);
                            $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING) ?? null;

                            if ($meta_id && $cantidad_ahorrada !== false && $cantidad_ahorrada > 0) {
                                // CORRECCIÓN CLAVE: Segundo argumento debe ser $cantidad_ahorrada
                                $this->metaAhorroModel->añadirAhorroAMeta($meta_id, $cantidad_ahorrada, $usuario_id, $descripcion);
                            }
                        }
                        // Redirigir siempre después de la acción, sin mensaje en URL
                        header("Location: index.php?ruta=main&modulo=ahorro");
                        exit;

                    // NUEVO CASO PARA DESHACER AHORRO
                    case 'deshacerAhorro':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $historial_id = filter_input(INPUT_POST, 'historial_id', FILTER_VALIDATE_INT);
                            $meta_id = filter_input(INPUT_POST, 'meta_id', FILTER_VALIDATE_INT);
                            $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_FLOAT);

                            if ($historial_id && $meta_id && $cantidad !== false && $cantidad > 0) {
                                $this->metaAhorroModel->deshacerAhorro($historial_id, $meta_id, $cantidad, $usuario_id);
                            }
                        }
                        // Redirigir siempre después de la acción, sin mensaje en URL
                        header("Location: index.php?ruta=main&modulo=ahorro");
                        exit;

                    case 'generar_pdf':
                        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($id) {
                            $this->generarPDF($id);
                            return;
                        }
                        // Si el ID es inválido, podrías redirigir o mostrar un mensaje
                        echo "ID de meta inválido para generar PDF.";
                        return; // O header("Location: index.php?ruta=main&modulo=ahorro"); exit;
                }
            }

            // Manejo de formularios POST para crear y actualizar metas
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['crearMeta'])) {
                    $nombre_meta = filter_input(INPUT_POST, 'nombre_meta', FILTER_SANITIZE_STRING);
                    $cantidad_meta = filter_input(INPUT_POST, 'cantidad_meta', FILTER_VALIDATE_FLOAT);
                    $fecha_limite = filter_input(INPUT_POST, 'fecha_limite', FILTER_SANITIZE_STRING);
                    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING) ?? null;

                    if ($nombre_meta && $cantidad_meta !== false && $fecha_limite) {
                        $this->metaAhorroModel->guardarMeta($usuario_id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion);
                    }
                    header("Location: index.php?ruta=main&modulo=ahorro");
                    exit;

                } elseif (isset($_POST['actualizarMeta'])) {
                    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                    $nombre_meta = filter_input(INPUT_POST, 'nombre_meta', FILTER_SANITIZE_STRING);
                    $cantidad_meta = filter_input(INPUT_POST, 'cantidad_meta', FILTER_VALIDATE_FLOAT);
                    $fecha_limite = filter_input(INPUT_POST, 'fecha_limite', FILTER_SANITIZE_STRING);
                    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING) ?? null;

                    if ($id && $nombre_meta && $cantidad_meta !== false && $fecha_limite) {
                        $this->metaAhorroModel->actualizarMeta($id, $usuario_id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion);
                    }
                    header("Location: index.php?ruta=main&modulo=ahorro");
                    exit;
                }
            }

            // Vista por defecto: listar metas del usuario
            $result = $this->metaAhorroModel->obtenerTodasLasMetas($usuario_id);
            
            // Pasar el modelo y el usuario_id a la vista para el historial y otras operaciones
            $data = [
                'result' => $result,
                'usuario_id' => $usuario_id,
                'metaAhorroModel' => $this->metaAhorroModel
            ];
            extract($data);

            // No se imprimen mensajes de GET aquí, se espera que la vista los maneje si es necesario
            include $rutaVista . 'ahorro.php';

        } catch (Exception $e) {
            error_log("❌ Error fatal en AhorroController: " . $e->getMessage());
            echo "<h1>Ha ocurrido un error inesperado. Por favor, inténtelo de nuevo más tarde.</h1>";
        }
    }

    private function generarPDF($id) {
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        if (!$usuario_id) {
            echo "Usuario no autenticado para generar PDF.";
            return;
        }

        $meta = $this->metaAhorroModel->obtenerMetaPorId($id, $usuario_id);
        $historial = $this->metaAhorroModel->obtenerHistorialPorMeta($id, $usuario_id);

        if (!$meta) {
            echo "Meta no encontrada o no te pertenece.";
            return;
        }

        $html = '<!DOCTYPE html>
                 <html>
                 <head>
                     <meta charset="utf-8">
                     <title>Reporte de Meta de Ahorro</title>
                     <style>
                         body { font-family: DejaVu Sans, sans-serif; margin: 20px; color: #333; }
                         h1 { color: #1e3a8a; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; }
                         h3 { color: #3b82f6; margin-top: 25px; border-bottom: 1px dashed #ccc; padding-bottom: 5px;}
                         p { margin: 5px 0; line-height: 1.5; }
                         ul { list-style-type: none; padding: 0; }
                         li { margin-bottom: 10px; border: 1px solid #e2e8f0; padding: 10px; border-radius: 5px; background-color: #f8fafc; }
                         .header-section { margin-bottom: 20px; }
                         .summary-box {
                             border: 1px solid #a7f3d0;
                             background-color: #ecfdf5;
                             padding: 15px;
                             border-radius: 8px;
                             margin-top: 20px;
                         }
                         .progress-bar-container {
                            width: 100%;
                            background-color: #e0e0e0;
                            border-radius: 5px;
                            height: 20px;
                            overflow: hidden;
                            margin-top: 10px;
                        }
                        .progress-bar {
                            height: 100%;
                            background-color: #22c55e; /* green-500 */
                            text-align: center;
                            color: white;
                            line-height: 20px; /* Centrar texto verticalmente */
                            font-size: 12px;
                            border-radius: 5px;
                        }
                        .footer {
                            text-align: center;
                            margin-top: 40px;
                            font-size: 10px;
                            color: #777;
                        }
                     </style>
                 </head>
                 <body>';
        $html .= '<div class="header-section">';
        $html .= '<h1>Reporte de Meta de Ahorro: ' . htmlspecialchars($meta['nombre_meta']) . '</h1>';
        $html .= '<p><strong>Descripción:</strong> ' . (empty($meta['descripcion']) ? 'N/A' : htmlspecialchars($meta['descripcion'])) . '</p>';
        $html .= '</div>';

        $html .= '<div class="summary-box">';
        $html .= '<p><strong>Cantidad Meta:</strong> $' . number_format($meta['cantidad_meta'], 2) . ' COP</p>';
        $html .= '<p><strong>Cantidad Ahorrada:</strong> $' . number_format($meta['ahorrado'], 2) . ' COP</p>';
        $html .= '<p><strong>Fecha Límite:</strong> ' . htmlspecialchars($meta['fecha_limite']) . '</p>';
        $progreso_porcentaje = ($meta['cantidad_meta'] > 0) ? round(($meta['ahorrado'] / $meta['cantidad_meta']) * 100) : 0;
        $html .= '<p><strong>Progreso:</strong> ' . $progreso_porcentaje . '%</p>';
        $html .= '<div class="progress-bar-container"><div class="progress-bar" style="width:' . $progreso_porcentaje . '%;">'.$progreso_porcentaje.'%</div></div>';
        $html .= '</div>';

        $html .= '<h3>Historial de Ahorros</h3><ul>';
        if (is_array($historial) && count($historial) > 0) {
            foreach ($historial as $ahorro) {
                $html .= '<li>';
                $html .= '<p><strong>Cantidad:</strong> $' . number_format($ahorro['cantidad'], 2) . ' COP</p>';
                $html .= '<p><strong>Fecha:</strong> ' . htmlspecialchars($ahorro['fecha']) . '</p>';
                if (!empty($ahorro['descripcion1'])) {
                    $html .= '<p><strong>Descripción:</strong> ' . htmlspecialchars($ahorro['descripcion1']) . '</p>';
                }
                $html .= '</li>';
            }
        } else {
            $html .= '<li>No hay historial de ahorros registrado para esta meta.</li>';
        }
        $html .= '</ul>';

        $html .= '<div class="footer">Generado por DocDinner el ' . date('d/m/Y H:i') . '</div>';
        $html .= '</body></html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("reporte_meta_ahorro_" . $id . ".pdf", ["Attachment" => false]);
    }
}