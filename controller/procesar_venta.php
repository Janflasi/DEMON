<<<<<<< HEAD
<?php
require_once __DIR__ . '/../model/Ventas.php';
require_once __DIR__ . '/VentaController.php';

// Asegúrate de recibir los datos JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
    exit;
}

$controller = new VentaController();
$resultado = $controller->procesarVenta($data['cart']);

echo json_encode(['success' => $resultado]);
?>
=======
<?php
require_once __DIR__ . '/../model/Ventas.php';
require_once __DIR__ . '/VentaController.php';

// Asegúrate de recibir los datos JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Datos no válidos']);
    exit;
}

$controller = new VentaController();
$resultado = $controller->procesarVenta($data['cart']);

echo json_encode(['success' => $resultado]);
?>
>>>>>>> 681627f6ed9bf0c515773cd85c45954592b9e126
