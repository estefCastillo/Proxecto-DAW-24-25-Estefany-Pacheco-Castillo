CREATE DATABASE IF NOT EXISTS sambo;
USE sambo;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(100) NOT NULL,
    rol VARCHAR(10) DEFAULT "usuario"
);

CREATE TABLE empresas (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(100) NOT NULL,
    telefono VARCHAR(9) NOT NULL,
    direccion VARCHAR(150) NOT NULL
);

CREATE TABLE servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(100),
    precio DECIMAL,
    tipo_precio VARCHAR(50),       
    imagen VARCHAR(255),          
    categoria VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(150),
    id_empresa INT NOT NULL,
    FOREIGN KEY (id_empresa) REFERENCES empresas(id_empresa) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE favoritos (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_servicio INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_servicio INT NOT NULL,
    fecha DATE NOT NULL,
    cantidad INT NOT NULL, 
    precio_total DECIMAL NOT NULL,
    estado VARCHAR(100) DEFAULT 'pendiente',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES
('Sambo', 'administrador@sambo.com', 'admin123', 'admin'),
('Pedro Pérez', 'pedroperez@ejemplo.com', 'abc123.pedroperez', 'usuario'),
('María Márquez', 'mariamarquez@ejemplo.com', 'abc123.mariamarquez', 'usuario'),
('Manuel Miranda', 'manuelmiranda@ejemplo.com', 'abc123.manuelmiranda', 'usuario'),
('Lorena Lorenzo', 'lorenalorenzo@ejemplo.com', 'abc123.lorenalorenzo', 'usuario');


INSERT INTO empresas (nombre_empresa, correo, contrasena, telefono, direccion) VALUES
('Floristería Flower', 'info@floristeriaflower.com', 'abc123.', '981123456', 'Rúa das Flores, 12, Santiago de Compostela'),
('Catering Galician Food', 'info@galicianfood.com', 'abc123.', '986654321', 'Avda. Atlántida, 55, Vigo');


INSERT INTO servicios (nombre, descripcion, precio, tipo_precio, imagen, categoria, ubicacion, id_empresa) VALUES
('Decoración floral boda', 'Arreglos florales para bodas y eventos', 450.00, 'evento', './img/arreglos_florales.jpg', 'Floristería', 'Santiago de Compostela', 1),
('Catering gourmet', 'Servicio de catering gourmet para eventos', 120.00, 'persona', './img/catering_example.jpg', 'Catering', 'Vigo', 2),
('Pared de fotos', 'Panel de fotos de recuerdo', 80.00, 'unidad', './img/recuerdos.jpg', 'Decoración', 'Santiago de Compostela', 1);

INSERT INTO favoritos (id_usuario, id_servicio) VALUES
(1, 1),
(2, 2);

INSERT INTO reservas (id_usuario, id_servicio, fecha, cantidad) VALUES
(1, 2, '2025-06-15', 50), 
(2, 1, '2025-07-20', 1);
