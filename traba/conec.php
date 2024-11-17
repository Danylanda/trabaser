<?php
// Función para establecer la conexión a la base de datos
function getConnection() {
    $servername = "localhost"; // Servidor de la base de datos
    $username = "root";        // Usuario de la base de datos
    $password = "";            // Contraseña de la base de datos
    $dbname = "sistema_pagos"; // Nombre de la base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

// Función para obtener los pagos de la tabla `pagos`
function getPagos($conn) {
    $sql = "
        SELECT 
            MONTH(fecha_pago) AS mes, 
            YEAR(fecha_pago) AS anio, 
            SUM(monto_recibido) AS total,
            SUM(pago_en_dolares) AS interes,
            SUM(pago_en_bolivianos) AS capital
        FROM pagos 
        WHERE YEAR(fecha_pago) = 2024
        GROUP BY mes, anio
    ";

    $result = $conn->query($sql);
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

// Función para obtener todos los clientes
function getClientes($conn) {
    $sql = "SELECT * FROM clientes ORDER BY id_cliente";
    $result = $conn->query($sql);
    $clientes = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clientes[] = $row;
        }
    }
    return $clientes;
}
?>
