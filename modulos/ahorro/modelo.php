<?php

class MetaAhorro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todas las metas de ahorro de un usuario
    public function obtenerTodasLasMetas($usuario_id) {
        $sql = "SELECT * FROM metas_ahorro WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener historial de ahorros por ID de meta
    public function obtenerHistorialPorMeta(int $metaId, int $usuario_id) {
        $sql = "SELECT * FROM historial_ahorros 
                WHERE meta_id = :meta_id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':meta_id' => $metaId,
            ':usuario_id' => $usuario_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva meta de ahorro
    public function guardarMeta($usuario_id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion) {
        try {
            $sql = "INSERT INTO metas_ahorro (usuario_id, nombre_meta, cantidad_meta, fecha_limite, descripcion) 
                    VALUES (:usuario_id, :nombre, :cantidad, :fecha, :descripcion)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $usuario_id,
                ':nombre' => $nombre_meta,
                ':cantidad' => $cantidad_meta,
                ':fecha' => $fecha_limite,
                ':descripcion' => $descripcion
            ]);
            return "✅ Meta guardada exitosamente.";
        } catch (PDOException $e) {
            return "❌ Error al guardar la meta: " . $e->getMessage();
        }
    }

    // Eliminar una meta por su ID y el ID del usuario
    public function eliminarMetaPorId($id, $usuario_id) {
        $sql = "DELETE FROM metas_ahorro WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
        return true;
    }

    // Obtener una meta por su ID y el ID del usuario
    public function obtenerMetaPorId($id, $usuario_id) {
        $sql = "SELECT * FROM metas_ahorro WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar los datos de una meta de ahorro
    public function actualizarMeta($id, $usuario_id, $nombre_meta, $cantidad_meta, $fecha_limite, $descripcion) {
        $sql = "UPDATE metas_ahorro 
                SET nombre_meta = :nombre_meta, 
                    cantidad_meta = :cantidad_meta, 
                    fecha_limite = :fecha_limite, 
                    descripcion = :descripcion 
                WHERE id = :id AND usuario_id = :usuario_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nombre_meta' => $nombre_meta,
            ':cantidad_meta' => $cantidad_meta,
            ':fecha_limite' => $fecha_limite,
            ':descripcion' => $descripcion,
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
        return true;
    }

    // Añadir ahorro a una meta existente
    public function añadirAhorroAMeta($meta_id, $cantidad_ahorrada, $usuario_id, $descripcion = null) {
        if ($cantidad_ahorrada <= 0) {
            return "❌ La cantidad ahorrada debe ser mayor a 0.";
        }

        $meta = $this->obtenerMetaPorId($meta_id, $usuario_id);
        if (!$meta) {
            return "❌ Meta de ahorro no encontrada o no pertenece al usuario.";
        }

        try {
            $this->conn->beginTransaction();

            // Actualizar el valor ahorrado
            $sql_update = "UPDATE metas_ahorro SET ahorrado = ahorrado + :cantidad WHERE id = :id";
            $stmt_update = $this->conn->prepare($sql_update);
            $stmt_update->execute([
                ':cantidad' => $cantidad_ahorrada,
                ':id' => $meta_id
            ]);

            // Insertar en el historial
            $sql_historial = "INSERT INTO historial_ahorros (meta_id, cantidad, descripcion1, usuario_id) 
                            VALUES (:meta_id, :cantidad, :descripcion, :usuario_id)";
            $stmt_historial = $this->conn->prepare($sql_historial);
            $stmt_historial->execute([
                ':meta_id' => $meta_id,
                ':cantidad' => $cantidad_ahorrada,
                ':descripcion' => $descripcion,
                ':usuario_id' => $usuario_id
            ]);

            $this->conn->commit();
            return "✅ Ahorro añadido correctamente.";
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "❌ Error al añadir el ahorro: " . $e->getMessage();
        }
    }
}
