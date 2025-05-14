<?php
require_once __DIR__ . '/../DB/Conexion.php';

class LibroModel {
    public static function obtenerLibrosPorCategoria($categoria) {
        $conn = Conexion::conectar();

        if ($categoria === 'Todos') {
            $sql = "SELECT libros.*, categorias.nombre AS categoria FROM libros 
                    LEFT JOIN categorias ON libros.categoria_id = categorias.id";
            $stmt = $conn->prepare($sql);
        } else {
            $sql = "SELECT libros.*, categorias.nombre AS categoria FROM libros 
                    LEFT JOIN categorias ON libros.categoria_id = categorias.id 
                    WHERE categorias.nombre = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $categoria);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        $libros = [];

        while ($row = $resultado->fetch_assoc()) {
            $libros[] = $row;
        }

        $stmt->close();
        $conn->close();
        return $libros;
    }
}

require_once __DIR__ . '/../DB/Conexion.php';

class Libro {
    public static function buscarPorTitulo($titulo) {
        $conn = Conexion::conectar();
        $stmt = $conn->prepare("SELECT libros.*, categorias.nombre AS categoria 
                                FROM libros 
                                LEFT JOIN categorias ON libros.categoria_id = categorias.id 
                                WHERE libros.titulo LIKE ?");
        $titulo = "%" . $titulo . "%";
        $stmt->bind_param("s", $titulo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
class NuevoLibroModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Guardar un libro en la base de datos
    public function guardar($titulo, $categoria_id, $precio, $descripcion, $imagen, $cantidad)
    {
        // Preparar la consulta SQL para insertar un libro
        $query = "INSERT INTO libros (titulo, categoria_id, precio, descripcion, imagen, cantidad) 
                  VALUES (:titulo, :categoria_id, :precio, :descripcion, :imagen, :cantidad)";

        // Preparar la sentencia
        $stmt = $this->db->prepare($query);
        
        // Vincular los parámetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':imagen', $imagen);
        $stmt->bindParam(':cantidad', $cantidad);

        // Ejecutar la consulta y devolver el resultado
        return $stmt->execute();
    }

    // Obtener todas las categorías
    public function obtenerCategorias()
    {
        $query = "SELECT * FROM categorias";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
