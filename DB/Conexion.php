<<<<<<< HEAD
<?php
class Conexion {
    public static function conectar() {
        $host = 'localhost';
        $usuario = 'root';
        $clave = '';
        $base_datos = 'Juan';

        $conn = new mysqli($host, $usuario, $clave, $base_datos);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>
=======
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
>>>>>>> 681627f6ed9bf0c515773cd85c45954592b9e126
