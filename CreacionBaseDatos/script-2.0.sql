-- Borrar todas las tablas existentes (¡Precaución: Esto eliminará todos los datos!)
DROP TABLE IF EXISTS DetallesCompra;
DROP TABLE IF EXISTS Carrito;
DROP TABLE IF EXISTS Imagenes;
DROP TABLE IF EXISTS TallasProductos;
DROP TABLE IF EXISTS Stock;
DROP TABLE IF EXISTS Opiniones;
DROP TABLE IF EXISTS VariacionesProductos;
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
DROP TABLE IF EXISTS MetodoPago;
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
    Descripcion TEXT,
    Precio DECIMAL(10, 2) NOT NULL,
    CATEGORIAID INT,
    COLECCIONID INT,
    DESCUENTOID INT,
    FOREIGN KEY (CATEGORIAID) REFERENCES Categorias(Id) on delete set null,
    FOREIGN KEY (COLECCIONID) REFERENCES Colecciones(Id) on delete set null,
    FOREIGN KEY (DESCUENTOID) REFERENCES Descuentos(Id) on delete set null
);

-- Tabla Colores
CREATE TABLE Colores (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    ColorPatron VARCHAR(50) NOT NULL,
    ColorBase VARCHAR(50) NOT NULL,
    UNIQUE KEY `UK_ColorPatronBase` (`ColorPatron`, `ColorBase`)
);

-- Tabla VariacionesProductos
CREATE TABLE VariacionesProductos (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    IDPRODUCTO INT NOT NULL,
    IDCOLOR INT NOT NULL,
    FOREIGN KEY (IDPRODUCTO) REFERENCES Productos(Id) on delete cascade,
    FOREIGN KEY (IDCOLOR) REFERENCES Colores(Id) on delete cascade
);

-- Tabla Tallas
CREATE TABLE Tallas (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla TallasProductos (Tabla de union para la relacion M:M entre Variaciones y Tallas)
CREATE TABLE TallasProductos (
    IDVARIACION INT NOT NULL,
    IDTALLA INT NOT NULL,
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id) on delete cascade,
    FOREIGN KEY (IDTALLA) REFERENCES Tallas(Id) on delete cascade,
    PRIMARY KEY (IDVARIACION, IDTALLA)
);

-- Tabla Stock
CREATE TABLE Stock (
    IDPRODUCTO INT NOT NULL,
    IDVARIACION INT NOT NULL,
    stock INT DEFAULT 0,
    FOREIGN KEY (IDPRODUCTO) REFERENCES Productos(Id) on delete cascade,
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id) on delete cascade,
    PRIMARY KEY (IDPRODUCTO, IDVARIACION)
);

-- Tabla MetodoPago
CREATE TABLE MetodoPago (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tipo VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla Compras
CREATE TABLE Compras (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    EstadoPago ENUM('pendiente', 'pagada', 'rechazada') DEFAULT 'pendiente',
    IDMETODOPAGO INT,
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    PrecioTotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (IDMETODOPAGO) REFERENCES MetodoPago(Id) on delete set null,
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email) on delete cascade
);

-- Tabla Opiniones
CREATE TABLE Opiniones (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Valoracion INT CHECK (Valoracion >= 1 AND Valoracion <= 5),
    Descripcion TEXT,
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    IDPRODUCTO INT NOT NULL,
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email) on delete cascade,
    FOREIGN KEY (IDPRODUCTO) REFERENCES Productos(Id) on delete cascade
);

-- Tabla Imagenes
CREATE TABLE Imagenes (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tipo ENUM('anverso', 'reverso') DEFAULT ('anverso'),
    Ruta VARCHAR(255),
    IDPRODUCTO INT NOT NULL,
    FOREIGN KEY (IDPRODUCTO) REFERENCES Productos(Id) on delete cascade
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
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email) on delete cascade
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
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email) on delete cascade
);

-- Tabla Carrito
CREATE TABLE Carrito (
    EMAILUSUARIO VARCHAR(255) NOT NULL,
    IDVARIACION INT NOT NULL,
    IDTALLA INT NOT NULL,
    Cantidad INT DEFAULT 1,
    FechaAgregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email) on delete cascade,
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id) on delete cascade,
    FOREIGN KEY (IDTALLA) REFERENCES Tallas(Id) on delete cascade,
    PRIMARY KEY (EMAILUSUARIO, IDVARIACION)
);

-- Tabla DetallesCompra
CREATE TABLE DetallesCompra (
    IDCOMPRA INT NOT NULL,
    IDVARIACION INT NOT NULL,
    IDTALLA INT NOT NULL,
    Cantidad INT NOT NULL,
    PrecioTotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (IDCOMPRA) REFERENCES Compras(Id) on delete cascade,
    FOREIGN KEY (IDVARIACION) REFERENCES VariacionesProductos(Id) on delete cascade,
    FOREIGN KEY (IDTALLA) REFERENCES Tallas(Id) on delete cascade,
    PRIMARY KEY (IDCOMPRA, IDVARIACION, IDTALLA)
);

-- Tabla Tokens
CREATE TABLE Tokens (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    IdToken VARCHAR(255),
    Expiracion DATETIME,
    EMAILUSUARIO VARCHAR(255),
    FOREIGN KEY (EMAILUSUARIO) REFERENCES Usuarios(Email) on delete cascade
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
('Niños', 'Ropa para los mas pequeños'),
('Sudaderas', 'Sudaderas con y sin capucha');

-- Tabla Colecciones
INSERT INTO Colecciones (Nombre, Descripcion) VALUES
('Primavera 2025', 'Nueva coleccion de primavera'),
('Verano 2025', 'Ropa fresca para el verano'),
('Basicos', 'Prendas esenciales para tu armario'),
('Deportiva', 'Ropa comoda para hacer ejercicio'),
('Noche', 'Elegancia para ocasiones especiales'),
('Casual', 'Ropa informal para el dia a dia'),
('Urbana', 'Estilo de la ciudad'),
('Retro', 'Inspiracion vintage'),
('Fiesta', 'Looks para celebrar'),
('Ofertas', 'Precios especiales');

-- Tabla Descuentos
INSERT INTO Descuentos (Nombre, Descripcion, FechaIni, FechaFin, Cantidad, Tipo) VALUES
('soyunratilla', 'Descuento del 5%', '2025-05-01', '2030-05-31', 5.00, 'porcentaje'),
('hermano', 'Descuento de 10€', '2025-06-01', '2025-06-30', 10.00, 'cantidad'),
('veranito', 'Descuento del 50%', '2025-07-01', '2025-07-31', 50.00, 'porcentaje');

-- Tabla Productos
INSERT INTO Productos (Nombre, Descripcion, Precio, CATEGORIAID, COLECCIONID, DESCUENTOID) VALUES
('Camiseta basica algodon', 'Camiseta de algodon suave', 20.00, 2, 3, NULL),
('Pantalon corto chándal', 'Pantalón corto perfecto para Verano', 25.00, 1, 3, NULL),
('Sudadera con capucha', 'Sudadera comoda con capucha', 45.00, 5, 1, NULL),
('Agricultores', 'Camiseta de agricultores original de Farko', 30.00, 2, 1, NULL),
('Diabla', 'Camiseta diabla original de Farko', 35.00, 2, 4, NULL),
('Pegatina logo Farko', 'Pegatina con el logo de la marca', 1.99, 3, 3, NULL);

-- Tabla Colores
INSERT INTO Colores (ColorPatron, ColorBase) VALUES
('Negro', 'Blanco'), 
('Blanco', 'Negro'), 
('Blanco', 'Amarillo'), 
('Blanco', 'Azul'), 
('Blanco', 'Gris'), 
('Blanco', 'Naranja'), 
('Blanco', 'Rosa'), 
('Negro', 'Negro'), 
('Blanco', 'Blanco'), 
('Morado', 'Morado'), 
('Gris', 'Gris'), 
('Rojo', 'Rojo'), 
('Verde', 'Verde'), 
('Amarillo', 'Blanco'), 
('Verde', 'Blanco'), 
('Rosa', 'Blanco'), 
('Rojo', 'Blanco'), 
('Rosa', 'Negro'), 
('Rojo', 'Negro'); 


-- Tabla VariacionesProductos
INSERT INTO VariacionesProductos (IDPRODUCTO, IDCOLOR) VALUES
(1, 11), (1, 10), (1, 12),
(2, 1), (2, 2), 
(3, 3), (3, 4), (3, 5),
(3, 6), (3, 7), (3, 17),
(4, 14), (4, 17), (4, 15),
(5, 18), (5, 16), (5, 17), (5,19),
(6, 9), (6, 11), (6,8), (6, 13);

-- Tabla Tallas
INSERT INTO Tallas (Nombre) VALUES
('S'),
('M'),
('L'),
('XL');

-- Tabla TallasProductos
INSERT INTO TallasProductos (IDVARIACION, IDTALLA) VALUES
-- Camiseta básica algodón (Producto ID 1) 
(1, 1), (1, 2), (1, 4), 
(2, 1), (2, 3), (2, 4), 
(3, 1), (3, 2), (3, 3), 

-- Pantalón corto chándal (Producto ID 2)
(4, 1), (4, 2), (4, 3), 
(5, 2), (5, 3), (5, 4), 

-- Sudadera con capucha (Producto ID 3)
(6, 4), 
(7, 1), (7, 2), (7, 3), (7, 4), 
(8, 4), 
(9, 1), (9, 4), 
(10, 3), (10, 4), 
(11, 1), (11, 3), (11, 4), 

-- Camiseta Agricultores (Producto ID 4)
(12, 1), (12, 2), (12, 3), (12, 4), 
(13, 1), (13, 2), (13, 3), (13, 4), 
(14, 1), (14, 2), (14, 3), (14, 4), 

-- Camiseta Diabla (Producto ID5)
(15, 1), (15, 2), (15, 3), (15, 4), 
(16, 1), (16, 2), (16, 3), (16, 4), 
(17, 1), (17, 2), (17, 3), (17, 4), 
(18, 1), (18, 2), (18, 3), (18, 4); 


-- Tabla MetodoPago
INSERT INTO MetodoPago (Tipo) VALUES
('Tarjeta de Credito'),
('PayPal');

-- Tabla Compras
INSERT INTO Compras (EMAILUSUARIO, IDMETODOPAGO, EstadoPago, PrecioTotal) VALUES
('usuario1@farko.es', 1, 'pendiente', 79.98),
('usuario2@farko.es', 2, 'pagada',24.99),
('usuario3@farko.es', 1, 'rechazada', 119.97);

-- Tabla Opiniones
INSERT INTO Opiniones (EMAILUSUARIO, IDPRODUCTO, Valoracion, Descripcion) VALUES
('usuario1@farko.es', 1, 4, 'Buena camiseta, comoda.'),
('usuario2@farko.es', 2, 5, 'Los vaqueros me quedan perfectos.'),
('usuario3@farko.es', 1, 3, 'El color no es exactamente como en la foto.');

-- Tabla Imagenes
INSERT INTO Imagenes (IDPRODUCTO, Tipo, Ruta) VALUES
(1, 'anverso', 'uploads/camisetasbasicas-todas-home-anverso.png'),
(1, 'anverso', 'uploads/camisetabasica-morado-morado-anverso.png'),
(1, 'anverso', 'uploads/camisetabasica-gris-gris-anverso.png'),
(1, 'anverso', 'uploads/camisetabasica-rojo-rojo-anverso.png'),

(2, 'anverso', 'uploads/pantalon-blanco-negro-anverso.jpg'),
(2, 'anverso', 'uploads/pantalon-negro-blanco-anverso.jpg'),

(3, 'anverso', 'uploads/sudaderas-home-anverso.jpg'),
(3, 'anverso', 'uploads/sudadera-blanco-azul-anverso.jpg'),
(3, 'anverso', 'uploads/sudadera-blanco-gris-anverso.jpg'),
(3, 'anverso', 'uploads/sudadera-blanco-rosa-anverso.jpg'),
(3, 'anverso', 'uploads/sudadera-rojo-blanco-anverso.jpg'),
(3, 'anverso', 'uploads/sudadera-blanco-amarillo-anverso.jpg'),
(3, 'anverso', 'uploads/sudadera-blanco-naranja-anverso.jpg'),

(4, 'anverso', 'uploads/agricultores-rojo-blanco-anverso.png'),
(4, 'anverso', 'uploads/agricultor-verde-blanco-anverso.png'),
(4, 'anverso', 'uploads/agricultor-amarillo-blanco-anverso.png'),

(5, 'anverso', 'uploads/camisetadiabla-rosa-negro-anverso.jpg'),
(5, 'anverso', 'uploads/camisetadiabla-rojo-blanco-anverso.jpg'),
(5, 'anverso', 'uploads/camisetadiabla-rojo-negro-anverso.jpg'),
(5, 'anverso', 'uploads/camisetadiabla-rosa-blanco-anverso.jpg'),

(6, 'anverso', 'uploads/pegatina-blanco-anverso.jpg'),
(6, 'anverso', 'uploads/pegatina-gris-anverso.jpg'),
(6, 'anverso', 'uploads/pegatina-negro-anverso.jpg'),
(6, 'anverso', 'uploads/pegatina-verde-anverso.jpg'); 

-- Tabla Reclamaciones
INSERT INTO Reclamaciones (EMAILUSUARIO, Motivo, Descripcion) VALUES
('usuario4@farko.es', 'Talla incorrecta', 'Pedi una L y me llego una M.');

-- Tabla Direcciones
INSERT INTO Direcciones (EMAILUSUARIO, Calle, Poblacion, CodPostal) VALUES
('usuario1@farko.es', 'Calle Falsa 123', 'Madrid', '28001'),
('usuario2@farko.es', 'Avenida Inventada 456', 'Barcelona', '08002');

-- Tabla Carrito
INSERT INTO Carrito (EMAILUSUARIO, IDVARIACION, IDTALLA, Cantidad) VALUES
('usuario1@farko.es', 1, 2, 2),
('usuario2@farko.es', 4, 1, 1);

-- Tabla DetallesCompra
INSERT INTO DetallesCompra (IDCOMPRA, IDVARIACION, IDTALLA, Cantidad, PrecioTotal) VALUES
(1, 1, 1, 1, 19.99),
(1, 4, 2, 1, 49.99),
(1, 7, 3, 1, 9.99),
(2, 10, 1, 1, 24.99),
(3, 13, 4, 2, 59.98), 
(3, 16, 2, 1, 39.99);

-- Tabla Stock
INSERT INTO Stock (IDPRODUCTO, IDVARIACION, Stock) VALUES
(1, 1, 50), (1, 2, 20), (1, 3, 30),
(2, 4, 31), (2, 5, 26), 
(3, 6, 10), (3, 7, 61), (3, 8, 11), 
(3, 9, 43), (3, 10, 33), (3, 11, 62), 
(4, 12, 6), (4, 13, 70), (4, 14, 48),
(5, 15, 81), (5, 16, 40), (5, 17, 75), (5, 18, 59),
(6, 19, 63), (6, 20, 45), (6, 21, 65), (6, 22, 9);
