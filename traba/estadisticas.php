<?php
// Conexión a la base de datos
include('conec.php');

$conexion = new mysqli('127.0.0.1', 'root', '', 'sistema_pagos');
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consultas para obtener los datos
$sql = "
    SELECT 
        YEAR(fecha_pago) AS anio,
        SUM(monto_recibido) AS pagos_totales,
        SUM(CASE WHEN tipo_cuota = 'Interes' THEN monto_recibido ELSE 0 END) AS pagos_interes,
        SUM(CASE WHEN tipo_cuota = 'Capital' THEN monto_recibido ELSE 0 END) AS pagos_capital
    FROM pagos
    GROUP BY YEAR(fecha_pago)
";
$result = $conexion->query($sql);

$anios = [];
$pagos_totales = [];
$pagos_interes = [];
$pagos_capital = [];

while ($row = $result->fetch_assoc()) {
    $anios[] = $row['anio'];
    $pagos_totales[] = $row['pagos_totales'];
    $pagos_interes[] = $row['pagos_interes'];
    $pagos_capital[] = $row['pagos_capital'];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Filtro de Proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .filter-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .filter-container select {
            padding: 8px;
            font-size: 16px;
        }
        .filter-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .filter-container select {
            padding: 8px;
            font-size: 16px;
        }
    </style>
   
    <title>Estadísticas de Pagos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }
        .container {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }
        .panel {
            background-color: #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            width: 30%;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .panel canvas {
            margin: 0 auto;
        }
        .barra {
            background-color: #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            width: 90%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div style="text-align: left; margin: 20px;">
    <button onclick="regresarInicio()" style="
        padding: 10px 20px; 
        font-size: 16px; 
        background-color: #333; 
        color: white; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer;">
        Inicio
    </button>
</div>
    <h1>Pago Anual</h1>
    
    <form method="POST" action="procesar_filtro.php">
        <div class="filter-container">
            <!-- Filtro de Proyecto -->
            <div>
                <label for="proyecto">Proyecto:</label>
                <select name="proyecto" id="proyecto">
                    <option value="J1">J1</option>
                    <option value="J2">J2</option>
                    <option value="J3">J3</option>
                </select>
            </div>
            <!-- Filtro de Cliente -->
            <div>
                <label for="cliente">Cliente:</label>
                <select name="cliente" id="cliente">
                    <option value="Todos">Todos</option>
                    <option value="Cliente1">Cliente 1</option>
                    <option value="Cliente2">Cliente 2</option>
                    <option value="Cliente3">Cliente 3</option>
                </select>
            </div>
            <!-- Filtro de Cuota -->
            <div>
                <label for="cuota">Cuota:</label>
                <select name="cuota" id="cuota">
                    <option value="Todas">Todas</option>
                    <option value="Cuota1">Cuota 1</option>
                    <option value="Cuota2">Cuota 2</option>
                    <option value="Cuota3">Cuota 3</option>
                </select>
            </div>
        </div>
        <button type="submit">Filtrar</button>
    </form>    

<script>
    function regresarInicio() {
        // Redirecciona a la página principal (inicio.php o index.php)
        window.location.href = 'index.php';
    }
</script>
    <div class="container">
        <!-- Medidor Pagos Totales -->
        <div class="panel">
            <h2>Pagos Totales</h2>
            <canvas id="chartPagosTotales" width="200" height="200"></canvas>
        </div>

        <!-- Medidor Pagos a Interés -->
        <div class="panel">
            <h2>Pagos a Interés</h2>
            <canvas id="chartPagosInteres" width="200" height="200"></canvas>
        </div>

        <!-- Medidor Pagos a Capital -->
        <div class="panel">
            <h2>Pagos a Capital</h2>
            <canvas id="chartPagosCapital" width="200" height="200"></canvas>
        </div>
    </div>

    <div class="barra">
        <h2>Pagos Totales $ por Año</h2>
        <canvas id="chartBarras" width="600" height="400"></canvas>
    </div>

    <script>
        // Datos desde PHP
        /*const anios = <?php echo json_encode($anios); ?>;
        const pagosTotales = <?php echo json_encode($pagos_totales); ?>;
        const pagosInteres = <?php echo json_encode($pagos_interes); ?>;
        const pagosCapital = <?php echo json_encode($pagos_capital); ?>;*/

        // Datos ficticios (arreglos para los pagos por mes)
        const valoresTotales = [13000, 9500, 9375, 8743, 12151, 12686, 14244, 12275, 5977, 9010];
        const valoresInteres = [7000, 4500, 4375, 4143, 6151, 6686, 7244, 5275, 2977, 4010];
        const valoresCapital = [6000, 5000, 5000, 4300, 6000, 6000, 7000, 7000, 3000, 5000];

        // Sumar valores para calcular totales
        const totalPagosTotales = valoresTotales.reduce((a, b) => a + b, 0);
        const totalPagosInteres = valoresInteres.reduce((a, b) => a + b, 0);
        const totalPagosCapital = valoresCapital.reduce((a, b) => a + b, 0);

        const maxValor = totalPagosTotales * 1.2; // Margen superior al total



        // Función para crear un medidor semicircular
        function crearMedidor(ctx, valor, total, color) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [valor, total - valor],
                        backgroundColor: [color, '#E0E0E0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    rotation: -Math.PI,
                    circumference: Math.PI,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    cutout: '75%',
                }
            });
        }

        // Crear medidores
        crearMedidor(
            document.getElementById('chartPagosTotales'),
            totalPagosTotales,
            maxValor,
            //pagosTotales.reduce((a, b) => a + b, 0),
            //pagosTotales.reduce((a, b) => a + b, 0) * 1.2,
            '#333333'
        );
        crearMedidor(
            document.getElementById('chartPagosInteres'),
            //pagosInteres.reduce((a, b) => a + b, 0),
            //pagosTotales.reduce((a, b) => a + b, 0),
            totalPagosInteres,
            maxValor,
            '#FFD700'
        );
        crearMedidor(
            document.getElementById('chartPagosCapital'),
            //pagosCapital.reduce((a, b) => a + b, 0),
            //pagosTotales.reduce((a, b) => a + b, 0),
            totalPagosCapital,
            maxValor,
            '#808080'
        );

        // Gráfica de barras apiladas
        const anios = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct"];
        new Chart(document.getElementById('chartBarras'), {
            type: 'bar',
            data: {
                labels: anios,
                datasets: [
                    {
                        label: 'Pagos Totales',
                        //data: pagosTotales,
                        data: valoresTotales,
                        backgroundColor: '#333333'
                    },
                    {
                        label: 'Pagos Interés',
                        //data: pagosInteres,
                        data: valoresInteres,
                        backgroundColor: '#FFD700'
                    },
                    {
                        label: 'Pagos Capital',
                        //data: pagosCapital,
                        data: valoresCapital,
                        backgroundColor: '#808080'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true }
                }
            }
        });
    </script>
</body>
</html>
