CREATE DATABASE IF NOT EXISTS sambo;
USE sambo;

-- Tabla usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(100) NOT NULL
);

-- Tabla empresas
CREATE TABLE empresas (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(100) NOT NULL,
    telefono VARCHAR(13),
    direccion VARCHAR(150)
);

-- Tabla servicio
CREATE TABLE servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(100),
    precio DECIMAL,
    categoria VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(150),
    id_empresa INT NOT NULL,
    FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Tabla favorito
CREATE TABLE favoritos (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_servicio INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Tabla Reserva
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_servicio INT NOT NULL,
    fecha DATE NOT NULL,
    estado VARCHAR(100) DEFAULT 'pendiente',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON UPDATE CASCADE ON DELETE CASCADE
);



INSERT INTO usuarios (nombre, correo, contrasena) VALUES
('Sambo', 'administrador@sambo.com', 'admin123'),
('Pedro Pérez', 'pedroperez@ejemplo.com', 'abc123.pedroperez'),
('María Márquez', 'mariamarquez@ejemplo.com', 'abc123.mariamarquez'),
('Manuel Miranda', 'manuelmiranda@ejemplo.com', 'abc123.manuelmiranda'),
('Lorena Lorenzo', 'lorenalorenzo@ejemplo.com', 'abc123.lorenalorenzo');

-- Insertar empresass
INSERT INTO empresas (nombre_empresa, correo, contrasena, telefono, direccion) VALUES
('Floristería Flower', 'info@floristeriaflower.com', 'abc123.', '981123456', 'Rúa das Flores, 12, Santiago de Compostela'),
('Catering Galician Food', 'info@galicianfood.com', 'abc123.', '986654321', 'Avda. Atlántida, 55, Vigo');

-- Insertar servicios
INSERT INTO servicios (nombre, descripcion, precio, categoria, ubicacion, id_empresa) VALUES
('Decoración floral boda', 'Arreglos florales para bodas y eventos', 450.00, 'Floristería', 'Santiago de Compostela', 1),
('Catering gourmet', 'Servicio de catering gourmet para eventos', 1200.00, 'Catering', 'Vigo', 2),
('Centro de mesa floral', 'Centros de mesa personalizados', 80.00, 'Floristería', 'Santiago de Compostela', 1);

-- Insertar favoritos
INSERT INTO favoritos (id_usuario, id_servicio) VALUES
(1, 1),
(2, 2);

-- Insertar reservas
INSERT INTO reservas (id_usuario, id_servicio, fecha) VALUES
(1, 2, '2025-06-15'), 
(2, 1, '2025-07-20');
