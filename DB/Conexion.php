<?php
class Conexion {
    public static function conectar() {
        $host = 'localhost';
        $usuario = 'root';
        $clave = '';
        $base_datos = 'libreria';

        $conn = new mysqli($host, $usuario, $clave, $base_datos);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>
