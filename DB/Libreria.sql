-- Crear la base de datos
CREATE DATABASE libreria;
-- Seleccionar la base de datos
USE libreria;

-- Tabla para almacenar las categorías de los libros
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

-- Insertar algunas categorías de ejemplo
INSERT INTO categorias (nombre)
VALUES 
('Novela'),
('Fantasía'),
('Ciencia');

-- Tabla para almacenar los libros
CREATE TABLE libros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  categoria_id INT,
  precio DECIMAL(10, 2),
  descripcion TEXT,
  imagen VARCHAR(255),
  cantidad INT DEFAULT 0,         -- Cantidad de libros disponibles
  ventas INT DEFAULT 0,          -- Total de ventas del libro
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Insertar algunos libros de ejemplo con string descriptivas
INSERT INTO libros (titulo, categoria_id, precio, descripcion, imagen, cantidad)
VALUES 
('Harry Potter', 2, 25.00, 'El inicio de una mágica aventura en Hogwarts, la escuela de magia más famosa. Un joven mago enfrenta oscuros secretos y desafíos.', 'img/harry.jpg', 30),
('El origen de las especies', 3, 30.00, 'La teoría de la evolución explicada por Charles Darwin. Un estudio revolucionario que cambió la comprensión del origen de la vida.', 'img/darwin.jpg', 40),
('Don Quijote', 1, 22.00, 'La icónica historia del caballero andante, Don Quijote de la Mancha, quien lucha por sus ideales en un mundo moderno.', 'img/quijote.jpg', 20),
('El Hobbit', 2, 24.00, 'Un viaje épico en la Tierra Media. Bilbo Baggins, un hobbit, se embarca en una aventura que lo lleva a descubrir su valor.', 'img/hobbit.jpg', 15),
('1984', 1, 18.00, 'Una novela distópica escrita por George Orwell que describe una sociedad totalitaria en la que el gobierno controla todo, incluso el pensamiento.', 'img/1984.jpg', 35),
('Fahrenheit 451', 3, 28.00, 'Una novela de Ray Bradbury que imagina un futuro donde los libros están prohibidos, y los bomberos queman todos los textos.', 'img/fahrenheit451.jpg', 25),
('La sombra del viento', 1, 22.00, 'Una historia de misterio escrita por Carlos Ruiz Zafón. Un joven se adentra en la búsqueda de un autor perdido en la Barcelona de la posguerra.', 'img/sombra.jpg', 20),
('La Biblia', 3, 35.00, 'El texto religioso fundamental del cristianismo. Una obra que ha influenciado la historia, la cultura y la religión durante siglos.', 'img/biblia.jpg', 50);

-- Tabla para registrar las ventas realizadas
CREATE TABLE ventas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  libro_id INT,
  cantidad INT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (libro_id) REFERENCES libros(id)
);

-- Realizar una venta (por ejemplo, vender 2 libros de "Cien años de soledad")
INSERT INTO ventas (libro_id, cantidad)
VALUES (1, 2);  -- Suponiendo que el libro_id de "Cien años de soledad" es 1 y se vendieron 2 unidades

-- Actualizar la cantidad de libros después de una venta
UPDATE libros
SET cantidad = cantidad - 2
WHERE id = 1;

-- Actualizar las ventas totales del libro
UPDATE libros
SET ventas = ventas + 2
WHERE id = 1;
