DROP DATABASE IF EXISTS incidencias_tic;

-- Crea la base de datos
CREATE DATABASE incidencias_tic;

-- Utiliza la base de datos recién creada
USE incidencias_tic;

-- Crea la tabla Departamento
CREATE TABLE Departamento (
    dep INT PRIMARY KEY,
    Nombre_dep VARCHAR(50)
);

-- Crea la tabla Profesor
CREATE TABLE Profesor (
    ID_Profe INT PRIMARY KEY,
    nombre VARCHAR(50),
    correo VARCHAR(100),
    clave_acceso VARCHAR(255),
    dep INT,
    FOREIGN KEY (dep) REFERENCES Departamento(dep) ON DELETE CASCADE
);

-- Crea la tabla Aula
CREATE TABLE Aula (
    ID_Aula INT PRIMARY KEY,
    Nombre_aula VARCHAR(50),
    Num_Aula FLOAT
);



CREATE TABLE Tipo_Incidencia (
    id_tipo_incidencia VARCHAR(5) PRIMARY KEY ,
    tipo_incidencia VARCHAR(20)
);



CREATE TABLE Ciclo (
    id_ciclo INT PRIMARY KEY,
    ciclo VARCHAR(20),
    turno VARCHAR(30) NOT NULL CHECK(turno IN ('Vespertino', 'Matutino'))
);



-- Crea la tabla Incidencias
CREATE TABLE Incidencias (
    id_incidencia VARCHAR(10) PRIMARY KEY ,
    fecha DATE,
    descripcion VARCHAR(255),
    id_ciclo INT,
    ID_Aula INT,
    ID_Profe INT,
    id_tipo_incidencia VARCHAR(5),
    niveldeprioridad INT CHECK (niveldeprioridad IN (1, 2, 3)),
    Estado VARCHAR(20) CHECK (Estado IN ('Solucionado', 'Creada', 'En_proceso')),  
    FOREIGN KEY (id_ciclo) REFERENCES Ciclo(id_ciclo) ON DELETE CASCADE,
    FOREIGN KEY (ID_Aula) REFERENCES Aula(ID_Aula) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo_incidencia) REFERENCES Tipo_Incidencia(id_tipo_incidencia) ON DELETE CASCADE,
    FOREIGN KEY (ID_Profe) REFERENCES Profesor(ID_Profe) ON DELETE SET NULL
);

/******************************************************************************************************/

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('SFTW_','Software');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('HRDW_','Hardware');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('CNTVD','Conectividad');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('RREDM','Recursos EducaMadrid');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('OF365','Office 365/Teams');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('PDI__','PDI');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('IMPRS','Impresión');

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES ('OTROS','Otros');
/*/////////////////////////////////////////////////////////////-*/


-- Inserta varias aulas en la tabla Aula
INSERT INTO Aula (ID_Aula, Nombre_aula) VALUES
(1, 'DEP Servicion a la Comunidad'),
(2, 'DEP Administración y gestión'),
(3, 'DEP Comercio y Marketing'),
(4, 'DEP Informática y Comunicaciones'),
(5, 'DEP Inglés'),
(6, 'DEP Formación y Orientación Laboral'),
(7, 'DEP Orientación'),
(8, 'DEP ACE'),
(9, 'DEP Actividades Físicas y Deportivas'),
(10, 'Despacho Jefatura'),
(11, 'Despacho Dirección'),
(12, 'Despacho Secretaría'),
(13, 'Sala de Profesores'),
(14, 'Biblioteca'),
(15, 'Secretaria'),
(16, 'Conserjería'),
(17, 'Salón de actos'),
(18, 'Sala de emprendimiento'),
(19, 'Sala de convivencia'),
(20, 'Gimnasio');


INSERT INTO Aula (ID_Aula, Nombre_aula, Num_Aula) VALUES
(21, 'B.1', 1),
(22, 'B.2', 2),
(23, 'B.3', 3),
(24, 'B.4', 4),
(25, 'B.5', 5),
(26, 'B.7', 7),
(27, 'B.9', 9),
(28, 'B.11', 11),
(29, 'B.13', 13),
(30, '1.1', 1.1),
(31, '1.2', 1.2),
(32, '1.3', 1.3),
(33, '1.4', 1.4),
(34, '1.5', 1.5),
(35, '1.6', 1.6),
(36, '1.7', 1.7),
(37, '1.8', 1.8),
(38, '1.9', 1.9),
(39, '1.10', 1.10),
(40, '1.11', 1.11),
(41, '1.12', 1.12),
(42, '1.13', 1.13),
(43, '1.14', 1.14),
(44, '1.15', 1.15),
(45, '1.16', 1.16),
(46, '1.17', 1.17),
(47, '1.18', 1.18),
(48, '1.19', 1.19),
(49, '1.20', 1.20),
(50, '1.21', 1.21),
(51, '1.22', 1.22),
(52, '1.23', 1.23),
(53, '2.1', 2.1),
(54, '2.2', 2.2),
(55, '2.3', 2.3),
(56, '2.4', 2.4),
(57, '2.5', 2.5),
(58, '2.6', 2.6),
(59, '2.7', 2.7),
(60, '2.8', 2.8),
(61, '2.9', 2.9),
(62, '2.11', 2.11),
(63, '2.13', 2.13);

-- Inserta varias ciclos 
INSERT INTO Ciclo (id_ciclo, ciclo, turno) VALUES
(1, '1º COMERCIO-INT','Matutino'),
(2, '1º ASIR-DUAL','Matutino'),
(3, '1º DAW-DUAL','Matutino'),
(5, '1º APD','Matutino'),
(6, '1º AEI','Matutino'),
(7, '1º GB ACCESO', 'Matutino'),
(8, '2º GB ACCESO','Matutino'),
(9, '2º TYL V','Vespertino'),
(10, '1º TYL V','Vespertino'),
(11, '1º CI','Matutino'),
(12, '2ºCI-DISTANCIA','Matutino'),
(13, '1º GB COM','Matutino'),
(14, '2º GB COM','Matutino'),
(15, '1º COM M','Matutino'),
(16, '1º COM V','Vespertino'),
(17, '2º COM M','Matutino'),
(18, '2º COM V','Vespertino'),
(19, '1º AFD A','Matutino'),
(20, '1º AFD B','Matutino'),
(21, '2º AFD A','Matutino'),
(22, '2º AFD B','Matutino'),
(23, '1º IS A','Matutino'),
(24, '2º IS A','Matutino'),
(25, '1º IS V','Vespertino'),
(26, '2º IS V','Vespertino'),
(27, '1º IS B','Matutino'),
(28, '2º IS B','Matutino'),
(29, '1º GUIA','Matutino'),
(30, '2º GUIA','Matutino'),
(31, '2º EI A','Matutino'),
(32, '2º EI B','Matutino'),
(33, '1º JARD','Matutino'),
(34, '2º JARD','Matutino'),
(35, 'ACEPELU','Matutino'),
(36, 'ACE MBE','Matutino'),
(37, '1º EI B','Matutino'),
(38, '1º DAW','Matutino'),
(39, '1º DAM V','Vespertino'),
(40, '2º DAM V','Vespertino'),
(41, '1º SMR V','Vespertino'),
(42, '2º SMR V','Vespertino'),
(43, '2º DAW','Matutino'),
(44, '1º AF','Matutino'),
(45, '2º AF','Matutino'),
(46, '1º ASDI V','Vespertino'),
(47, '1º GA','Matutino'),
(48, '2º GA','Matutino'),
(49, '2º MC A M','Matutino'),
(50, '1º MC A M','Matutino'),
(51, '2º APSD','Matutino'),
(52, '1º MC V','Vespertino'),
(53, '2º MC V','Vespertino');

/*/////////////////////////////////////////////////////////////-*/


INSERT INTO Departamento (dep, Nombre_dep) VALUES
(1, 'Servicios a la Comunidad'),
(2, 'Administración y Gestión'),
(3, 'Comercio y Marketing'),
(4, 'Actividades Físicas y Deportivas'),
(5, 'Informática y Comunicaciones'),
(6, 'Inglés'),
(7, 'Formación y Orientación Laboral'),
(8, 'Orientación'),
(9, 'ACE');

/*admin*/
INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) 
VALUES ( 12345, 'Maite Alhama', 'maite@educa.madrid.org', '$2y$10$O6Ej0yhfs1aCk6OJEvydOOhAhxox/am4L8I/QCw7kjG8gLhgdybjC', 5);


INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES
(11111, 'Jesus Utrilla', 'jesus.utrilla1@educa.madrid.org', '$2y$10$mRRfsumVRPkK6XbLxa8SIOYO8cpj.cLIT9.01zEWQK3LpeqGqPRm.', 1),
(22222, 'Victoria Muñoz', 'victoria.munozdorado@educa.madrid.org', '$2y$10$ncxckb3j9Hggy5bck05ktOYaPNJS2wFamvauoPZzL/5ZgwJkSftF6', 2),
(33333, 'David Leonel', 'david.marchena@educa.madrid.org', '$2y$10$XO1CqjX3Em0XrAxyn/51A.tv6axW.SjNTXQgjo1aoPdWBK8J9Bgui', 4);



/*INCIDENCIAS*************************/

INSERT INTO Incidencias (id_incidencia, fecha, descripcion, id_ciclo, ID_Aula, ID_Profe, id_tipo_incidencia, niveldeprioridad, Estado) VALUES
('SFTW_12345', '2023-01-15', 'prueba1', 1, 23, 12345, 'SFTW_', null, 'Creada'),
('CNTVD45677', '2023-02-20', 'prueba2', 3, 25, 11111, 'CNTVD', null, 'Creada'),
('RREDM32234', '2023-03-18', 'prueba3', 45, 40, 33333, 'RREDM', 1, 'En_proceso'),
('PDI__87655', '2023-04-22', 'prueba4', 50, 35, 12345, 'PDI__', null, 'Creada'),
('IMPRS87445', '2023-05-10', 'prueba5', 42, 33, 22222, 'IMPRS', 3, 'En_proceso'),
('PDI__35741', '2023-06-15', 'prueba6', 23, 29, 22222, 'PDI__', null, 'Creada'),
('OTROS95147', '2023-07-23', 'prueba7', 26, 60, 12345, 'OTROS', 2, 'En_proceso'),
('CNTVD15467', '2023-08-30', 'prueba8', 36, 57, 33333, 'CNTVD', null, 'Creada'),
('SFTW_64825', '2023-09-12', 'prueba9', 43, 54, 33333, 'SFTW_', 3, 'En_proceso'),
('OF36578231', '2023-10-05', 'prueba10', 14, 42, 22222, 'OF365', null, 'Creada'),
('HRDW_36847', '2023-11-18', 'prueba11', 17, 45, 33333, 'HRDW_', null, 'Creada'),
('RREDM23168', '2023-12-22', 'prueba12', 7, 31, 11111, 'RREDM', null, 'Creada'),
('HRDW_12313', '2023-06-08', 'prueba13', 29, 14, 22222, 'HRDW_', null, 'Creada');
