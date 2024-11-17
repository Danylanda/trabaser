<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proyecto = $_POST['proyecto'] ?? 'No seleccionado';
    $cliente = $_POST['cliente'] ?? 'No seleccionado';
    $cuota = $_POST['cuota'] ?? 'No seleccionado';

    echo "<h1>Datos Seleccionados</h1>";
    echo "<p><strong>Proyecto:</strong> $proyecto</p>";
    echo "<p><strong>Cliente:</strong> $cliente</p>";
    echo "<p><strong>Cuota:</strong> $cuota</p>";
}
?>
