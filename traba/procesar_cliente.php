<?php
// Verificar si el formulario fue enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que se recibió el nombre del cliente
    if (isset($_POST['nombre_cliente']) && !empty($_POST['nombre_cliente'])) {
        $nombre_cliente = $_POST['nombre_cliente'];

        // Conexión a la base de datos
        $conexion = new mysqli('localhost', 'root', '', 'sistema_pagos');

        // Comprobar la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
 // Insertar el nuevo cliente
        $sql = "INSERT INTO clientes (nombre_cliente) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('s', $nombre_cliente);

        if ($stmt->execute()) {
            echo "Cliente añadido correctamente.";
        } else {
            echo "Error al añadir cliente: " . $conexion->error;
        }

        $stmt->close();
        $conexion->close();
    } else {
        echo "Error: El campo 'nombre_cliente' es obligatorio.";
    }
} else {
    echo "Método no permitido.";
}