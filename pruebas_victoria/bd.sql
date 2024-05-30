-- Selecciona la base de datos
DROP DATABASE IF EXISTS pruebaemail;

-- Crea la base de datos
CREATE DATABASE pruebaemail;

-- Utiliza la base de datos recién creada
USE pruebaemail;


CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
 `forgot_pass_identity` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
 `created` datetime NOT NULL,
 `modified` datetime NOT NULL,
 `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Insertar registros de ejemplo en la tabla `users`
INSERT INTO `users` (`first_name`, `last_name`, `email`, `password`, `phone`, `forgot_pass_identity`, `created`, `modified`, `status`) VALUES
('John', 'Doe', 'john.doe@example.com', md5('password123'), '555-1234', '', NOW(), NOW(), '1'),
('Jane', 'Smith', 'jane.smith@example.com', md5('password456'), '555-5678', '', NOW(), NOW(), '1'),
('Alice', 'Johnson', 'alice.johnson@example.com', md5('password789'), '555-9012', '', NOW(), NOW(), '1'),
('Bob', 'Brown', 'bob.brown@example.com', md5('password101112'), '555-3456', '', NOW(), NOW(), '1'),
('Charlie', 'Davis', 'charlie.davis@example.com', md5('password131415'), '555-7890', '', NOW(), NOW(), '1');


