<?php
include('conec.php');

$conn = getConnection();
$id_cliente = $_GET['id_cliente'];

// Eliminar cliente
$sql = "DELETE FROM clientes WHERE id_cliente = $id_cliente";
if ($conn->query($sql)) {
    header("Location: infoclientes.php");
    exit;
} else {
    echo "Error al eliminar cliente: " . $conn->error;
}

$conn->close();
?>
