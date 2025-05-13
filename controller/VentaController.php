<<<<<<< HEAD
<?php
require_once __DIR__ . '/../model/Ventas.php';

class VentaController {
    private $ventas;

    public function __construct() {
        $this->ventas = new Ventas();
    }

    // Función para procesar la venta
    public function procesarVenta($libros) {
        try {
            $this->ventas->registrarVenta($libros);
            return true; // Venta exitosa
        } catch (Exception $e) {
            return false; // Error en la venta
        }
    }
}
?>
=======
<?php
require_once __DIR__ . '/../model/Ventas.php';

class VentaController {
    private $ventas;

    public function __construct() {
        $this->ventas = new Ventas();
    }

    // Función para procesar la venta
    public function procesarVenta($libros) {
        try {
            $this->ventas->registrarVenta($libros);
            return true; // Venta exitosa
        } catch (Exception $e) {
            return false; // Error en la venta
        }
    }
}
?>
>>>>>>> 681627f6ed9bf0c515773cd85c45954592b9e126
