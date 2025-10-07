-- -- CREACIÓN DE LA BASE DE DATOS --
-- Se crea la base de datos
CREATE DATABASE IF NOT EXISTS login_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos recién creada o existente
USE login_db;

-- -- ESTRUCTURA DE LA TABLA usuarios
-- Se define la tabla para almacenar la información de los usuarios.
CREATE TABLE IF NOT EXISTS usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL COMMENT 'Almacena la contraseña hasheada',
  fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY email_unico (email) COMMENT 'Asegura que cada email sea único'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -- VOLCADO DE DATOS DE EJEMPLO PARA LA TABLA usuarios
-- Las contraseñas han sido hasheadas con password_hash() de PHP. Para mas seguridad profe :)
-- '7524' para yomari12@gmail.com
-- '7524' para nefrailbalabarcarigato@gmail.com
-- Eso es todo por hoy mi querido profe :)

INSERT INTO usuarios (nombre, email, password) VALUES
('Yomari Gonzales', 'yomari12@gmail.com', '$2y$10$NW1U6.wi/v.UOOhMaM19nODirGxqg/vKpDq3YgsQPbZF9MGa5nlDm'),
('Nefrail Balabarca', 'nefrailbalabarcarigato@gmail.com', '$2y$10$NW1U6.wi/v.UOOhMaM19nODirGxqg/vKpDq3YgsQPbZF9MGa5nlDm');

