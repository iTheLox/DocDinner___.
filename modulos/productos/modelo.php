<?php
class Producto {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Obtener todos los gastos del usuario
    public function obtenerTodos($usuario_id) {
        $sql = "SELECT * FROM gastos_fijos WHERE usuario_id = :usuario_id ORDER BY fecha DESC, id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nuevo método: Obtener un gasto por su ID y el ID de usuario
    public function obtenerGastoPorId($id, $usuario_id) {
        $sql = "SELECT * FROM gastos_fijos WHERE id = :id AND usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener el total de todos los gastos del usuario
    public function obtenerTotalGastos($usuario_id) {
        $sql = "SELECT SUM(monto) AS total_gastos FROM gastos_fijos WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_gastos'] ?? 0;
    }

    // Buscar gastos por categoría
    public function buscarPorCategoria($categoria, $usuario_id) {
        $sql = "SELECT * FROM gastos_fijos WHERE categoria = :categoria AND usuario_id = :usuario_id ORDER BY fecha DESC, id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':categoria' => $categoria,
            ':usuario_id' => $usuario_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener total por categoría
    public function obtenerTotalPorCategoria($categoria, $usuario_id) {
        $sql = "SELECT SUM(monto) AS total_categoria FROM gastos_fijos
                WHERE categoria = :categoria AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':categoria' => $categoria,
            ':usuario_id' => $usuario_id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_categoria'] ?? 0;
    }

    // Obtener gastos ordenados por fecha o monto
    public function obtenerOrdenado($orden, $usuario_id) {
        $columna = ($orden === 'fecha') ? 'fecha' : 'monto';
        $sql = "SELECT * FROM gastos_fijos
                WHERE usuario_id = :usuario_id
                ORDER BY $columna DESC, id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar nuevo gasto
    public function guardarGastoFijo($nombre, $monto, $categoria, $descripcion, $fecha, $usuario_id) {
        try {
            $sql = "INSERT INTO gastos_fijos (nombre_gasto, monto, categoria, descripcion, fecha, usuario_id)
                    VALUES (:nombre_gasto, :monto, :categoria, :descripcion, :fecha, :usuario_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nombre_gasto' => $nombre,
                ':monto' => $monto,
                ':categoria' => $categoria,
                ':descripcion' => $descripcion,
                ':fecha' => $fecha,
                ':usuario_id' => $usuario_id
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al guardar gasto fijo: " . $e->getMessage());
            return "Error al guardar gasto fijo: " . $e->getMessage();
        }
    }

    // Actualizar gasto
    public function actualizarGasto($id, $nombre, $monto, $fecha, $categoria, $descripcion, $usuario_id) {
        try {
            $sql = "UPDATE gastos_fijos SET
                        nombre_gasto = :nombre,
                        monto = :monto,
                        fecha = :fecha,
                        categoria = :categoria,
                        descripcion = :descripcion
                    WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nombre' => $nombre,
                ':monto' => $monto,
                ':fecha' => $fecha,
                ':categoria' => $categoria,
                ':descripcion' => $descripcion,
                ':id' => $id,
                ':usuario_id' => $usuario_id
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar gasto: " . $e->getMessage());
            return "Error al actualizar gasto: " . $e->getMessage();
        }
    }

    // Eliminar gasto
    public function eliminarGasto($id, $usuario_id) {
        try {
            $sql = "DELETE FROM gastos_fijos WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':usuario_id' => $usuario_id
            ]);
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return "No se pudo eliminar el gasto o no tienes permisos.";
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar gasto: " . $e->getMessage());
            return "Error al eliminar gasto: " . $e->getMessage();
        }
    }
}
?>