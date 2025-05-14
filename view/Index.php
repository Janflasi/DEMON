<?php
require_once __DIR__ . '/../Controller/VentaController.php';
$conn = Conexion::conectar();

if (isset($_GET['titulo']) && !empty(trim($_GET['titulo']))) {
    $titulo = $conn->real_escape_string($_GET['titulo']);
    $sql = "SELECT libros.*, categorias.nombre AS categoria FROM libros 
            LEFT JOIN categorias ON libros.categoria_id = categorias.id 
            WHERE libros.titulo LIKE '%$titulo%'";
} else {
    $sql = "SELECT libros.*, categorias.nombre AS categoria FROM libros 
            LEFT JOIN categorias ON libros.categoria_id = categorias.id";
}

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📚 Librería Virtual</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/29/29302.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<header class="py-3 shadow">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="index.php">📚 Librería Virtual</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="Historial.php">Historial de ventas</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<div class="container py-3">
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownCategorias" data-bs-toggle="dropdown" aria-expanded="false">
            Filtrar por categoría
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownCategorias">
            <li><a class="dropdown-item" href="#" onclick="filtrarCategoria('Todos')">Todos</a></li>
            <li><a class="dropdown-item" href="#" onclick="filtrarCategoria('Novela')">Novela</a></li>
            <li><a class="dropdown-item" href="#" onclick="filtrarCategoria('Fantasía')">Fantasía</a></li>
            <li><a class="dropdown-item" href="#" onclick="filtrarCategoria('Ciencia')">Ciencia</a></li>
        </ul>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
        <h1>📚 Librería Virtual</h1>

        <form method="GET" action="index.php" class="d-flex mb-4">
            <input class="form-control me-2" type="search" name="titulo" placeholder="Buscar libro" aria-label="Buscar" value="<?= isset($_GET['titulo']) ? htmlspecialchars($_GET['titulo']) : '' ?>">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>

        <div>
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                Ver carrito 🛒
            </button>
            <button id="vaciar-carrito-btn" class="btn btn-danger mt-2">Vaciar carrito</button>
        </div>
    </div>

    <div class="row" id="book-list">
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($libro = $resultado->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 animate-card">
                        <img src="https://cdn-icons-png.flaticon.com/512/29/29302.png" class="card-img-top book-img" alt="Logo del libro" style="max-height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($libro['titulo']) ?></h5>
                            <p class="card-text"><strong>Categoría:</strong> <?= htmlspecialchars($libro['categoria']) ?></p>
                            <p class="card-text"><strong>Precio:</strong> $<?= number_format($libro['precio'], 2) ?></p>
                            <p class="card-text"><strong>Descripción:</strong> <?= htmlspecialchars($libro['descripcion']) ?></p>
                            <p class="card-text"><strong>Disponible:</strong> <?= $libro['cantidad'] ?> unidades</p>
                            <p class="card-text"><strong>Ventas:</strong> <?= $libro['ventas'] ?> vendidos</p>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary agregar-carrito"
                                    data-id="<?= $libro['id'] ?>"
                                    data-titulo="<?= htmlspecialchars($libro['titulo']) ?>"
                                    data-precio="<?= $libro['precio'] ?>"
                                    data-cantidad="1">
                                Agregar al carrito
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="alert alert-warning">
                    No hay libros disponibles.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">🛒 Carrito de compras</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group mb-2" id="cart-list"></ul>
            <strong>Total: $<span id="cart-total">0</span></strong>
            <button class="btn btn-success w-100 mt-3" id="checkout-btn">Finalizar compra</button>
        </div>
    </div>
</div>

<footer class="mt-5 py-4 text-center">
    <div class="container">
        <p class="mb-1">© 2025 Librería Virtual - Todos los derechos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/libro.js"></script>



</body>
</html>
