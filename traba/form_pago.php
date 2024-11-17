<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Pago</title>
</head>
<body>
    <h1>Añadir Pago</h1>
    <form method="POST" action="procesar_pago.php">
        <label for="id_cliente">ID Cliente:</label>
        <input type="number" id="id_cliente" name="id_cliente" required>

        <label for="fecha_pago">Fecha de Pago:</label>
        <input type="date" id="fecha_pago" name="fecha_pago" required>

        <label for="monto_recibido">monto recibido:</label>
        <input type="number" id="monto_recibido" name="monto_recibido" required>

        <!-- Nuevo campo: Nro Comprobante -->
        <label for="nro_comprobante">Nro Comprobante:</label>
        <input type="text" id="nro_comprobante" name="nro_comprobante" required>

        <!-- Nuevo campo: ID Contrato -->
        <label for="id_contrato">ID Contrato:</label>
        <input type="number" id="id_contrato" name="id_contrato" required>

        <!-- Nuevo campo: No Cuota -->
        <label for="nro_cuota">No Cuota:</label>
        <input type="number" id="nro_cuota" name="nro_cuota" required>

        <!-- Nuevo campo: Tipo de Cuota -->
        <label for="tipo_cuota">Tipo de Cuota:</label>
        <input type="text" id="tipo_cuota" name="tipo_cuota" required>

        <!-- Nuevo campo: Estado -->
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="pagado">Pagado</option>
            <option value="vencido">Vencido</option>
        </select>

        <!-- Nuevo campo: Moneda -->
        <label for="moneda">Moneda:</label>
        <select id="moneda" name="moneda" required>
            <option value="USD">USD</option>
            <option value="BOL">BOL</option>
            </select>

        <!-- Nuevo campo: TC (Tipo de Cambio) -->
        <label for="tc">TC (Tipo de Cambio):</label>
        <input type="number" id="tc" name="tc" step="0.01" required>

        <button type="submit">Guardar Pago</button>
    </form>
    <a href="infoclientes.php">Volver a Principal</a>
</body>
</html>
