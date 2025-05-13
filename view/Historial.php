<?php
require_once __DIR__ . '/../DB/Conexion.php';
$conexion = Conexion::conectar();

$query = "SELECT v.id AS venta_id, v.fecha, l.titulo, c.nombre AS categoria, v.cantidad, l.precio, (v.cantidad * l.precio) AS total
          FROM ventas v
          JOIN libros l ON v.libro_id = l.id
          JOIN categorias c ON l.categoria_id = c.id
          ORDER BY v.fecha DESC";

$resultado = $conexion->query($query);
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="../style/historial.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="header-barcelona">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <a href="index.php" class="navbar-brand text-white fw-bold fs-3">📚 Librería Virtual</a>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="Historial.php">Historial de ventas</a></li>
               
            </ul>
        </nav>
    </div>
</header>

<div class="historial-container container my-5">
    <h1 class="text-center mb-4">Historial de Compras</h1>

    <table class="table table-bordered table-striped table-hover text-center">
        <thead class="table-header">
            <tr>
                <th># Venta</th>
                <th>Fecha</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['venta_id'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['categoria']) ?></td>
                    <td><?= $row['cantidad'] ?></td>
                    <td><?= number_format($row['precio'], 2) ?> €</td>
                    <td class="fw-bold"><?= number_format($row['total'], 2) ?> €</td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer class="footer-barcelona text-white py-4 mt-5">
    <div class="container text-center">
        <p>© 2025 Librería Virtual - Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>

<?php $conexion->close(); ?>
