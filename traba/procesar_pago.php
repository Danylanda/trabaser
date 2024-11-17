<?php
include('conec.php');

$conn = getConnection();
$id_cliente = $_POST['id_cliente'];
$fecha_pago = $_POST['fecha_pago'];
$monto_recibido = $_POST['monto_recibido'];

$sql = "INSERT INTO pagos (id_cliente, fecha_pago, monto_recibido) 
        VALUES ('$id_cliente', '$fecha_pago', '$monto_recibido')";
if ($conn->query($sql)) {
    header("Location: infoclientes.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
