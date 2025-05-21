<?php
// modulos/productos/controlador.php

// Asegúrate de que la sesión esté iniciada al principio de tu aplicación
// Si ya la tienes en index.php o en algún archivo de configuración global, puedes omitir esta línea
// session_start(); 

include 'modulos/productos/modelo.php';

class ProductosController {
    private $productoModel;

    public function __construct($db) {
        $this->productoModel = new Producto($db);
    }

    public function productos() {
        // Asegúrate de que el usuario esté autenticado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?ruta=login");
            exit("⚠️ Error: Usuario no autenticado.");
        }

        $usuario_id = $_SESSION['usuario_id'];

        $total_gastos = null;
        $categoriaSeleccionada = null;
        $total_categoria = null;
        $gastos = [];
        $ordenSeleccionado = null;
        $resultado = null;

        // ** Recuperar mensajes flash de la sesión si existen **
        $mensaje = null;
        if (isset($_SESSION['mensaje_flash'])) {
            $mensaje = $_SESSION['mensaje_flash'];
            unset($_SESSION['mensaje_flash']); // Eliminar el mensaje después de recuperarlo
        }

        $error = null;
        if (isset($_SESSION['error_flash'])) {
            $error = $_SESSION['error_flash'];
            unset($_SESSION['error_flash']); // Eliminar el mensaje después de recuperarlo
        }

        $id = null;

        if (isset($_GET['accion'])) {
            $accion = $_GET['accion'];

            switch($accion){
                case 'crear':
                    include 'modulos/productos/vista/crear.php'; // Si existe una vista separada para crear
                    exit();
                    break;
                case 'eliminar':
                    if (isset($_GET['id'])) {
                        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                        if ($id === false || $id === null) {
                            $_SESSION['error_flash'] = "ID de gasto inválido para eliminar.";
                            header("Location: index.php?ruta=main&modulo=productos");
                            exit();
                        }
                        $resultado = $this->productoModel->eliminarGasto($id, $usuario_id);
                    
                        if ($resultado === true) {
                            $_SESSION['mensaje_flash'] = "Gasto eliminado correctamente.";
                            header("Location: index.php?ruta=main&modulo=productos");
                            exit();
                        } else {
                            $_SESSION['error_flash'] = $resultado; // El modelo ahora devuelve un string en caso de error
                            header("Location: index.php?ruta=main&modulo=productos");
                            exit();
                        }
                    } else {
                        $_SESSION['error_flash'] = "ID no recibido para eliminar.";
                        header("Location: index.php?ruta=main&modulo=productos");
                        exit();
                    }
                    break;
                case 'editar':
                    // Sin cambios aquí, se mantiene la lógica existente para el modal
                    break;
            }

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['crearGasto'])) {
                $nombre_gasto = filter_input(INPUT_POST, 'nombre_gasto', FILTER_SANITIZE_STRING);
                $monto = filter_input(INPUT_POST, 'monto', FILTER_VALIDATE_FLOAT);
                $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
                $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING) ?? '';
                $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);

                if (empty($nombre_gasto) || $monto === false || $monto === null || empty($categoria) || empty($fecha)) {
                    $_SESSION['error_flash'] = 'Todos los campos obligatorios deben ser completados.';
                    header('Location: index.php?ruta=main&modulo=productos');
                    exit();
                }

                $resultado = $this->productoModel->guardarGastoFijo($nombre_gasto, $monto, $categoria, $descripcion, $fecha, $usuario_id);

                if ($resultado === true) {
                    $_SESSION['mensaje_flash'] = 'Gasto guardado correctamente.';
                } else {
                    $_SESSION['error_flash'] = 'Error al guardar el gasto: ' . $resultado;
                }
                header('Location: index.php?ruta=main&modulo=productos');
                exit();
            } elseif (isset($_POST['actualizarGasto'])) {
                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $nombre = filter_input(INPUT_POST, 'nombre_gasto', FILTER_SANITIZE_STRING);
                $monto = filter_input(INPUT_POST, 'monto', FILTER_VALIDATE_FLOAT);
                $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);
                $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
                $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING) ?? '';

                if ($id === false || $id === null || empty($nombre) || $monto === false || $monto === null || empty($fecha) || empty($categoria)) {
                    $_SESSION['error_flash'] = "Datos de actualización incompletos o inválidos.";
                    header("Location: index.php?ruta=main&modulo=productos");
                    exit();
                }

                $resultado = $this->productoModel->actualizarGasto($id, $nombre, $monto, $fecha, $categoria, $descripcion, $usuario_id);

                if ($resultado === true) {
                    $_SESSION['mensaje_flash'] = "Gasto actualizado correctamente.";
                    header("Location: index.php?ruta=main&modulo=productos");
                    exit();
                } else {
                    $_SESSION['error_flash'] = "Error al actualizar el gasto: " . $resultado;
                    header("Location: index.php?ruta=main&modulo=productos");
                    exit();
                }
            }
            
            // Lógica para los formularios de búsqueda y totales (POST)
            // Se obtienen los gastos base antes de aplicar filtros/orden
            $gastos = $this->productoModel->obtenerTodos($usuario_id);

            if (isset($_POST['ver_total'])) {
                $total_gastos = $this->productoModel->obtenerTotalGastos($usuario_id);
            }

            if (isset($_POST['buscar_categoria'])) {
                $categoriaSeleccionada = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
                if (!empty($categoriaSeleccionada)) {
                    $gastos = $this->productoModel->buscarPorCategoria($categoriaSeleccionada, $usuario_id);
                } else {
                    // Si no se selecciona categoría, se muestran todos los gastos
                }
            }

            if (isset($_POST['ver_total_categoria'])) {
                $categoriaSeleccionada = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
                if (!empty($categoriaSeleccionada)) {
                    $total_categoria = $this->productoModel->obtenerTotalPorCategoria($categoriaSeleccionada, $usuario_id);
                } else {
                    $total_categoria = 0;
                    $_SESSION['error_flash'] = "Por favor, seleccione una categoría para ver su total.";
                    header('Location: index.php?ruta=main&modulo=productos'); // Redirigir para mostrar el error flash
                    exit();
                }
            }

            if (isset($_POST['ordenar_por'])) {
                $ordenSeleccionado = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);
                if (in_array($ordenSeleccionado, ['fecha', 'monto'])) {
                    $gastos = $this->productoModel->obtenerOrdenado($ordenSeleccionado, $usuario_id);
                } else {
                    // Default si el orden es inválido
                }
            }

            // Finalmente, incluye la vista
            include 'modulos/productos/vista/productos.php';

        } else {
            // Carga inicial de la página (GET sin acción ni POST)
            $gastos = $this->productoModel->obtenerTodos($usuario_id);
            include 'modulos/productos/vista/productos.php';
        }
    }
}
?>