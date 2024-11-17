<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'sistema_pagos');

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener el ID del cliente a editar desde la URL
$id_cliente = $_GET['id_cliente'];

// Consulta para obtener los datos del cliente
$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cliente = $result->fetch_assoc(); // Cargar los datos del cliente
} else {
    echo "Cliente no encontrado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Editar Cliente</h1>
        <form action="procesar_cliente.php" method="POST">
            <!-- Campo oculto para el ID del cliente -->
            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

            <div class="mb-3">
                <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<?= $cliente['nombre_cliente'] ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
