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
    clave_acceso VARCHAR(8),
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
    Estado VARCHAR(20) CHECK (Estado IN ('Solucionado', 'Pendiente', 'En_proceso')),  
    FOREIGN KEY (id_ciclo) REFERENCES Ciclo(id_ciclo) ON DELETE CASCADE,
    FOREIGN KEY (ID_Aula) REFERENCES Aula(ID_Aula) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo_incidencia) REFERENCES Tipo_Incidencia(id_tipo_incidencia) ON DELETE CASCADE,
    FOREIGN KEY (ID_Profe) REFERENCES Profesor(ID_Profe) ON DELETE CASCADE
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
(1, 'Salon de actos'),
(2, 'Despacho');


INSERT INTO Aula (ID_Aula, Nombre_aula, Num_Aula) VALUES
(3, '2.1', 2.1),
(4, '2.2', 2.2),
(5, '2.3', 2.3);

-- Inserta varias ciclos 
INSERT INTO ciclo (id_ciclo, ciclo, turno) VALUES
(1, 'DAW','Matutino'),
(2, 'DAM','Matutino'),
(3, 'TSEAS','Matutino'),
(5, 'Horario De Mañana','Matutino'),
(6, 'Horario De Tarde','Vespertino'),
(4, 'ASIR', 'Vespertino');

/*/////////////////////////////////////////////////////////////-*/


INSERT INTO Departamento (dep, Nombre_dep) VALUES
(1, 'Departamento A'),
(2, 'Departamento B'),
(3, 'Departamento C');

/*admin*/
INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) 
VALUES ( 12345, 'maite', 'maite@educa.madrid.org', 'admin', 1);

INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES
(11111, 'user1', 'user1@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 1),
(22222, 'user2', 'user2@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 1),
(33333, 'user3', 'user3@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 2),
(44444, 'user4', 'user4@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 2),
(55555, 'user5', 'user5@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 3);


/*INCIDENCIAS*************************/

INSERT INTO Incidencias (id_incidencia, fecha, descripcion, id_ciclo, ID_Aula, ID_Profe, id_tipo_incidencia, niveldeprioridad, Estado) VALUES
('SFTW_12345', CURRENT_TIMESTAMP(), 'prueba1', 1, 2, 12345, 'SFTW_', 2, 'Pendiente'),
('CNTVD45677', CURRENT_TIMESTAMP(), 'prueba2', 3, 2, 22222, 'CNTVD', 1, 'Pendiente'),
('RREDM32234', CURRENT_TIMESTAMP(), 'prueba3', 3, 5, 33333, 'RREDM', 1, 'Pendiente'),
('PDI__87655', CURRENT_TIMESTAMP(), 'prueba4', 2, 3, 22222, 'PDI__', 3, 'Pendiente'),
('HRDW_12313', CURRENT_TIMESTAMP(), 'prueba5', 4, 1, 44444, 'HRDW_', 2, 'Pendiente');

