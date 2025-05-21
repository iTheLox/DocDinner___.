<?php
$conn = new mysqli("localhost", "root", "", "control_gastos");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = $_POST['id']; // ID del historial
$meta_id = $_POST['meta_id'];
$cantidad = $_POST['cantidad'];

// Validar que los datos existan
if ($id && $meta_id && $cantidad) {
    // 1. Eliminar el historial
    $stmt1 = $conn->prepare(query: "DELETE FROM historial_ahorros WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();

    // 2. Actualizar la meta
    $stmt2 = $conn->prepare("UPDATE metas_ahorro SET ahorrado = ahorrado - ? WHERE id = ?");
    $stmt2->bind_param("di", $cantidad, $meta_id); // d = double, i = int
    $stmt2->execute();

    $stmt1->close();
    $stmt2->close();
    $conn->close();

    header("Location: index.php?ruta=main&modulo=ahorro");
    exit;
} else {
    echo "Datos incompletos para deshacer el ahorro.";
}
?>
