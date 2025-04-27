-- Borrar todas las tablas existentes (¡Precaución: Esto eliminará todos los datos!)
DROP TABLE IF EXISTS DetallesCompra;
DROP TABLE IF EXISTS Carrito;
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS TallasProductos;
DROP TABLE IF EXISTS VariacionesProductos;
DROP TABLE IF EXISTS Opiniones;
DROP TABLE IF EXISTS Compras;
DROP TABLE IF EXISTS Tokens;
DROP TABLE IF EXISTS Direcciones;
DROP TABLE IF EXISTS Reclamaciones;
DROP TABLE IF EXISTS Productos;
DROP TABLE IF EXISTS Descuentos;
DROP TABLE IF EXISTS Colecciones;
DROP TABLE IF EXISTS Categorias;
DROP TABLE IF EXISTS Tallas;
DROP TABLE IF EXISTS Colores;
DROP TABLE IF EXISTS MetodosPago;
DROP TABLE IF EXISTS Usuarios;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    Email VARCHAR(255) PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido1 VARCHAR(100),
    Apellido2 VARCHAR(100),
    Password VARCHAR(255) NOT NULL,
    Telefono VARCHAR(20),
    Estado BOOLEAN DEFAULT TRUE,
    NewsLetter BOOLEAN DEFAULT FALSE
);

-- Tabla Categorias
CREATE TABLE Categorias (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT
);

-- Tabla Colecciones
CREATE TABLE Colecciones (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT
);

-- Tabla Descuentos
CREATE TABLE Descuentos (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    FechaIni DATE,
    FechaFin DATE,
    Cantidad DECIMAL(10, 2),
    Tipo ENUM('cantidad', 'porcentaje')
);

-- Tabla Productos
CREATE TABLE Productos (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(255) NOT NULL,
    Stock INT DEFAULT 0,
    Descripcion TEXT,
    Precio DECIMAL(10, 2) NOT NULL,
    CATEGORIAID INT,
    COLECCIONID INT,
    DESCUENTOID INT,
    FOREIGN KEY (CATEGORIAID) REFERENCES Categorias(Id),
    FOREIGN KEY (COLECCIONID) REFERENCES Colecciones(Id),
    FOREIGN KEY (DESCUENTOID) REFERENCES Descuentos(Id)
);

-- Tabla Colores
CREATE TABLE Colores (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla VariacionesProductos
CREATE TABLE VariacionesProductos (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    IDPRODUCTO INT NOT NULL,
    IDCOLORPATRON INT NOT NULL,
    IDCOLORBASE INT NOT NULL,
    FOREIGN KEY (IDPRODUCTO) REFERENCES Productos(Id),
    FOREIGN KEY (IDCOLORPATRON) REFERENCES Colores(Id),
    FOREIGN KEY (IDCOLORBASE) REFERENCES Colores(Id),
    UNIQUE KEY `UK_ProductoColores` (`IDPRODUCTO`, `IDCOLORPATRON`, `IDCOLORBASE`)
);

-- Tabla Tallas
CREATE TABLE Tallas (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Talla VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla TallasProductos
CREATE TABLE TallasProductos (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    IDVARIACION INT NOT NULL,
    IDTALLA INT NOT NULL,
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id),
    FOREIGN KEY (IDTALLA) REFERENCES Tallas(Id),
    UNIQUE KEY `UK_VariacionTalla` (`IDVARIACION`, `IDTALLA`)
);

-- Tabla Método Pago
CREATE TABLE MetodosPago (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tipo VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla Compras
CREATE TABLE Compras (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    EstadoPago VARCHAR(50),
    IDMETODOPAGO INT,
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    PrecioTotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (IDMETODOPAGO) REFERENCES MetodosPago(Id),
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email)
);

-- Tabla Opiniones
CREATE TABLE Opiniones (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Valoracion INT CHECK (Valoracion >= 1 AND Valoracion <= 5),
    Descripcion TEXT,
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    IDPRODUCTO INT NOT NULL,
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email),
    FOREIGN KEY (IDPRODUCTO) REFERENCES Productos(Id)
);

-- Tabla Imágenes
CREATE TABLE Imagenes (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    FotoAnverso VARCHAR(255),
    FotoReverso VARCHAR(255),
    IDVARIACION INT NOT NULL,
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id)
);

-- Tabla Reclamaciones
CREATE TABLE Reclamaciones (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Motivo VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    Foto VARCHAR(255),
    Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    Estado ENUM('pendiente', 'cerrada', 'rechazada') DEFAULT 'pendiente',
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email)
);

-- Tabla Direcciones
CREATE TABLE Direcciones (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Numero VARCHAR(10),
    CodPostal VARCHAR(20),
    Calle VARCHAR(255) NOT NULL,
    Poblacion VARCHAR(100) NOT NULL,
    Puerta VARCHAR(50),
    Planta VARCHAR(50),
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email)
);

-- Tabla Carrito
CREATE TABLE Carrito (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    IDVARIACION INT NOT NULL,
    Cantidad INT DEFAULT 1,
    FechaAgregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email),
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id),
    UNIQUE KEY `UK_UsuarioVariacion` (`EMAILUSUARIO`, `IDVARIACION`)
);

-- Tabla DetallesCompra
CREATE TABLE DetallesCompra (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    IDCOMPRA INT NOT NULL,
    IDVARIACION INT NOT NULL,
    IDTALLA INT NOT NULL,
    Cantidad INT NOT NULL,
    PrecioTotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (IDCOMPRA) REFERENCES Compras(Id),
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id),
    FOREIGN KEY (IDTALLA) REFERENCES Tallas(Id),
    UNIQUE KEY `UK_CompraVariacionTalla` (`IDCOMPRA`, `IDVARIACION`, `IDTALLA`)
);

-- Tabla Tokens
CREATE TABLE Tokens (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    IdToken VARCHAR(255),
    Expiracion DATETIME,
    EMAILUSUARIO VARCHAR(255),
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email)
);

-- INSERTS

-- Tabla Usuarios
INSERT INTO Usuarios (Email, Nombre, Apellido1, Password) VALUES
('admin@farko.es', 'Admin', 'Farko', 'admin123'),
('usuario1@farko.es', 'Usuario', 'Uno', 'usuario1'),
('usuario2@farko.es', 'Usuario', 'Dos', 'usuario2'),
('usuario3@farko.es', 'Usuario', 'Tres', 'usuario3'),
('usuario4@farko.es', 'Usuario', 'Cuatro', 'usuario4');

-- Tabla Categorias
INSERT INTO Categorias (Nombre, Descripcion) VALUES
('Pantalones', 'Variedad de pantalones para todos los estilos'),
('Camisetas', 'Camisetas de manga corta, larga y sin mangas'),
('Accesorios', 'Complementos para tu outfit'),
('Niños', 'Ropa para los más pequeños'),
('Sudaderas', 'Sudaderas con y sin capucha');

-- Tabla Colecciones
INSERT INTO Colecciones (Nombre, Descripcion) VALUES
('Primavera 2025', 'Nueva colección de primavera'),
('Verano 2025', 'Ropa fresca para el verano'),
('Básicos', 'Prendas esenciales para tu armario'),
('Deportiva', 'Ropa cómoda para hacer ejercicio'),
('Noche', 'Elegancia para ocasiones especiales'),
('Casual', 'Ropa informal para el día a día'),
('Urbana', 'Estilo de la ciudad'),
('Retro', 'Inspiración vintage'),
('Fiesta', 'Looks para celebrar'),
('Ofertas', 'Precios especiales');

-- Tabla Descuentos
INSERT INTO Descuentos (Nombre, Descripcion, FechaIni, FechaFin, Cantidad, Tipo) VALUES
('soyunratilla', 'Descuento del 5%', '2025-05-01', '2025-05-31', 5.00, 'porcentaje'),
('hermano', 'Descuento de 10€', '2025-06-01', '2025-06-30', 10.00, 'cantidad'),
('veranito', 'Descuento del 50%', '2025-07-01', '2025-07-31', 50.00, 'porcentaje');

-- Tabla Productos
INSERT INTO Productos (Nombre, Stock, Descripcion, Precio, CATEGORIAID, COLECCIONID, DESCUENTOID) VALUES
('Camiseta básica algodón', 50, 'Camiseta de algodón suave', 19.99, 2, 3, NULL),
('Pantalón vaquero recto', 30, 'Vaquero clásico de corte recto', 49.99, 1, 3, NULL),
('Sudadera con capucha', 40, 'Sudadera cómoda con capucha', 39.99, 5, 1, NULL),
('Gorra de béisbol', 60, 'Gorra deportiva de algodón', 12.99, 3, 4, NULL),
('Camiseta estampada', 35, 'Camiseta con diseño original', 24.99, 2, 1, NULL),
('Pantalón corto deportivo', 45, 'Pantalón corto ideal para deporte', 29.99, 1, 4, NULL),
('Sudadera cuello redondo', 25, 'Sudadera informal de cuello redondo', 34.99, 5, 3, NULL),
('Cinturón de cuero', 55, 'Cinturón de cuero de alta calidad', 29.99, 3, 3, NULL),
('Vestido de verano', 20, 'Vestido ligero para los días cálidos', 59.99, 2, 2, NULL),
('Pegatina logo Farko', 100, 'Pegatina con el logo de la marca', 2.99, 3, 3, NULL);

-- Tabla Colores
INSERT INTO Colores (Nombre) VALUES
('Negro'),
('Blanco'),
('Azul'),
('Rojo'),
('Verde');

-- Tabla VariacionesProductos
INSERT INTO VariacionesProductos (IDPRODUCTO, IDCOLORPATRON, IDCOLORBASE) VALUES
(1, 1, 1), (1, 2, 2), (1, 3, 3), (1, 4, 4), (1, 5, 5),
(2, 1, 1), (2, 2, 2), (2, 3, 3), (2, 4, 4), (2, 5, 5),
(3, 1, 1), (3, 2, 2), (3, 3, 3), (3, 4, 4), (3, 5, 5),
(4, 1, 1), (4, 2, 2), (4, 3, 3), (4, 4, 4), (4, 5, 5),
(5, 1, 1), (5, 2, 2), (5, 3, 3), (5, 4, 4), (5, 5, 5),
(6, 1, 1), (6, 2, 2), (6, 3, 3), (6, 4, 4), (6, 5, 5),
(7, 1, 1), (7, 2, 2), (7, 3, 3), (7, 4, 4), (7, 5, 5),
(8, 1, 1), (8, 2, 2), (8, 3, 3), (8, 4, 4), (8, 5, 5),
(9, 1, 1), (9, 2, 2), (9, 3, 3), (9, 4, 4), (9, 5, 5),
(10, 1, 1), (10, 2, 2), (10, 3, 3), (10, 4, 4), (10, 5, 5);

-- Tabla Tallas
INSERT INTO Tallas (Talla) VALUES
('S'),
('M'),
('L'),
('XL');

-- Tabla TallasProductos
INSERT INTO TallasProductos (IDVARIACION, IDTALLA) VALUES
(1, 1), (1, 2), (1, 3), (1, 4),
(2, 1), (2, 2), (2, 3), (2, 4),
(3, 1), (3, 2), (3, 3), (3, 4),
(4, 1), (4, 2), (4, 3), (4, 4),
(5, 1), (5, 2), (5, 3), (5, 4),
(6, 1), (6, 2), (6, 3), (6, 4),
(7, 1), (7, 2), (7, 3), (7, 4),
(8, 1), (8, 2), (8, 3), (8, 4),
(9, 1), (9, 2), (9, 3), (9, 4),
(10, 1), (10, 2), (10, 3), (10, 4),
(11, 1), (11, 2), (11, 3), (11, 4),
(12, 1), (12, 2), (12, 3), (12, 4),
(13, 1), (13, 2), (13, 3), (13, 4),
(14, 1), (14, 2), (14, 3), (14, 4),
(15, 1), (15, 2), (15, 3), (15, 4),
(16, 1), (16, 2), (16, 3), (16, 4),
(17, 1), (17, 2), (17, 3), (17, 4),
(18, 1), (18, 2), (18, 3), (18, 4),
(19, 1);
