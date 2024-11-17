<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Cliente</title>
</head>
<body>
    <h1>Añadir Cliente</h1>
    <form method="POST" action="procesar_cliente.php">
        <label for="nombre_cliente">Nombre del Cliente:</label>
        <input type="text" id="nombre_cliente" name="nombre_cliente" required>
        <button type="submit">Guardar Cliente</button>
    </form>
    <a href="infoclientes.php">Volver a Principal</a>
</body>
</html>
