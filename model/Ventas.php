<?php
require_once __DIR__ . '/../DB/Conexion.php';

class Ventas {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    // Función para registrar la venta
    public function registrarVenta($libros) {
        $this->conn->begin_transaction(); // Inicia la transacción

        try {
            // Guardar las ventas
            foreach ($libros as $libro) {
                // Insertar la venta
                $sql = "INSERT INTO ventas (libro_id, cantidad) VALUES (?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $libro['id'], $libro['cantidad']);
                $stmt->execute();

                // Actualizar la cantidad de libros
                $sql_update = "UPDATE libros SET cantidad = cantidad - ?, ventas = ventas + ? WHERE id = ?";
                $stmt_update = $this->conn->prepare($sql_update);
                $stmt_update->bind_param("iii", $libro['cantidad'], $libro['cantidad'], $libro['id']);
                $stmt_update->execute();
            }

            // Si todo va bien, confirma la transacción
            $this->conn->commit();
        } catch (Exception $e) {
            // Si ocurre un error, revierte la transacción
            $this->conn->rollback();
            throw $e;
        }
    }
}
?>
