<?php
include('conec.php');

$conn = getConnection();

// Consulta para obtener los clientes y sus pagos
$sql = "
    SELECT 
        c.id_cliente, 
        c.nombre_cliente, 
        p.id_pago, 
        p.fecha_pago, 
        p.nro_comprobante, 
        p.id_contrato, 
        p.nro_cuota, 
        p.tipo_cuota, 
        p.moneda, 
        p.tipo_cambio, 
        p.monto_recibido, 
        p.pago_en_dolares, 
        p.pago_en_bolivianos
    FROM clientes c
    LEFT JOIN pagos p ON c.id_cliente = p.id_cliente
    ORDER BY c.id_cliente, p.id_pago
";

$result = $conn->query($sql);

$clientes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
    function regresarInicio() {
        // Redirecciona a la página principal (inicio.php o index.php)
        window.location.href = 'index.php';
    }
</script>
    
    <title>Informacion de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Informacion de Clientes y Pagos</h1>

        <!-- Botones para abrir las ventanas modales -->
        <div class="mb-4 text-center">
            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalCliente">Añadir Cliente</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPago">Añadir Pago</button>
        </div>

        <!-- Tabla de datos -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre del Cliente</th>
                    <th>ID Pago</th>
                    <th>Fecha de Pago</th>
                    <th>Nro Comprobante</th>
                    <th>ID Contrato</th>
                    <th>Nro Cuota</th>
                    <th>Tipo de Cuota</th>
                    <th>Moneda</th>
                    <th>Tipo de Cambio</th>
                    <th>monto recibido</th>
                    <th>Pago en Dólares</th>
                    <th>Pago en Bolivianos</th>
                    <th>Acciones</th> <!-- Nueva columna para botones -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= $cliente['id_cliente'] ?></td>
                        <td><?= $cliente['nombre_cliente'] ?></td>
                        <td><?= $cliente['id_pago'] ?: 'N/A' ?></td>
                        <td><?= $cliente['fecha_pago'] ?: 'N/A' ?></td>
                        <td><?= $cliente['nro_comprobante'] ?: 'N/A' ?></td>
                        <td><?= $cliente['id_contrato'] ?: 'N/A' ?></td>
                        <td><?= $cliente['nro_cuota'] ?: 'N/A' ?></td>
                        <td><?= $cliente['tipo_cuota'] ?: 'N/A' ?></td>
                        <td><?= $cliente['moneda'] ?: 'N/A' ?></td>
                        <td><?= $cliente['tipo_cambio'] ?: 'N/A' ?></td>
                        <td><?= $cliente['monto_recibido'] ?: 'N/A' ?></td>
                        <td><?= $cliente['pago_en_dolares'] ?: 'N/A' ?></td>
                        <td><?= $cliente['pago_en_bolivianos'] ?: 'N/A' ?></td>
                        <td>
                            <!-- Botón para editar -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $cliente['id_cliente'] ?>">Editar</button>
                            <!-- Botón para eliminar 
                            <a href="eliminar_cliente.php?id_cliente=<?= $cliente['id_cliente'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a-->
                        
                        </td>
                    </tr>
                    <!-- Modal de edición para este cliente -->
                    <div class="modal fade" id="modalEditar<?= $cliente['id_cliente'] ?>" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="procesar_edicion.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditarLabel">Editar Información</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
                                        <input type="hidden" name="id_pago" value="<?= $cliente['id_pago'] ?>">

                                        <div class="mb-3">
                                            <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="<?= $cliente['nombre_cliente'] ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= $cliente['fecha_pago'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nro_comprobante" class="form-label">Nro Comprobante</label>
                                            <input type="text" class="form-control" id="nro_comprobante" name="nro_comprobante" value="<?= $cliente['nro_comprobante'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="id_contrato" class="form-label">ID Contrato</label>
                                            <input type="number" class="form-control" id="id_contrato" name="id_contrato" value="<?= $cliente['id_contrato'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nro_cuota" class="form-label">No Cuota</label>
                                            <input type="number" class="form-control" id="nro_cuota" name="nro_cuota" value="<?= $cliente['nro_cuota'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tipo_cuota" class="form-label">Tipo de Cuota</label>
                                            <input type="text" class="form-control" id="tipo_cuota" name="tipo_cuota" value="<?= $cliente['tipo_cuota'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="moneda" class="form-label">Moneda</label>
                                            <select class="form-select" id="moneda" name="moneda">
                                                <option value="USD" <?= $cliente['moneda'] == 'USD' ? 'selected' : '' ?>>USD</option>
                                                <option value="BOL" <?= $cliente['moneda'] == 'BOL' ? 'selected' : '' ?>>BOL</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tipo_cambio" class="form-label">TC (Tipo de Cambio)</label>
                                            <input type="number" class="form-control" id="tipo_cambio" name="tipo_cambio" step="0.01" value="<?= $cliente['tipo_cambio'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="monto_recibido" class="form-label">Monto Recibido</label>
                                            <input type="number" class="form-control" id="monto_recibido" name="monto_recibido" step="0.01" value="<?= $cliente['monto_recibido'] ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para añadir cliente -->
    <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="procesar_cliente.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalClienteLabel">Añadir Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_cliente" class="form-label">Nombre del Cliente</label>
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para añadir pago -->
<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="procesar_pago.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoLabel">Añadir Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">ID Cliente</label>
                        <input type="number" class="form-control" id="id_cliente" name="id_cliente" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                    </div>
                    <div class="mb-3">
                        <label for="monto_recibido" class="form-label">Monto Recibido</label>
                        <input type="number" class="form-control" id="monto_recibido" name="monto_recibido" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="nro_comprobante" class="form-label">Nro Comprobante</label>
                        <input type="text" class="form-control" id="nro_comprobante" name="nro_comprobante" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_contrato" class="form-label">ID Contrato</label>
                        <input type="number" class="form-control" id="id_contrato" name="id_contrato" required>
                    </div>
                    <div class="mb-3">
                        <label for="nro_cuota" class="form-label">No Cuota</label>
                        <input type="number" class="form-control" id="nro_cuota" name="nro_cuota" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_cuota" class="form-label">Tipo de Cuota</label>
                        <input type="text" class="form-control" id="tipo_cuota" name="tipo_cuota" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="pagado">Pagado</option>
                            <option value="vencido">Vencido</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="moneda" class="form-label">Moneda</label>
                        <select class="form-select" id="moneda" name="moneda" required>
                            <option value="USD">USD</option>
                            <option value="BOL">BOL</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tc" class="form-label">TC (Tipo de Cambio)</label>
                        <input type="number" class="form-control" id="tc" name="tc" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>