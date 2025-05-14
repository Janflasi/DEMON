<?php
require_once __DIR__ . '/../model/Libro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoria'])) {
    $categoria = $_POST['categoria'];

    $libros = LibroModel::obtenerLibrosPorCategoria($categoria);

    header('Content-Type: application/json');
    echo json_encode($libros);
    exit;
}


require_once __DIR__ . '/../model/Libro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';

    if (!empty($titulo)) {
        $libros = Libro::buscarPorTitulo($titulo);

        // Devolver como HTML parcial
        foreach ($libros as $libro) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card h-100 animate-card">
                    <img src="../' . htmlspecialchars($libro['imagen']) . '" class="card-img-top book-img" alt="Imagen del libro">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($libro['titulo']) . '</h5>
                        <p class="card-text"><strong>Categoría:</strong> ' . htmlspecialchars($libro['categoria']) . '</p>
                        <p class="card-text"><strong>Precio:</strong> $' . number_format($libro['precio'], 2) . '</p>
                        <p class="card-text"><strong>Descripción:</strong> ' . htmlspecialchars($libro['descripcion']) . '</p>
                        <p class="card-text"><strong>Disponible:</strong> ' . $libro['cantidad'] . ' unidades</p>
                        <p class="card-text"><strong>Ventas:</strong> ' . $libro['ventas'] . ' vendidos</p>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-primary">Agregar al carrito</button>
                    </div>
                </div>
            </div>';
        }

        if (count($libros) === 0) {
            echo '<div class="col-12"><div class="alert alert-info">No se encontraron libros con ese título.</div></div>';
        }
    }
}
