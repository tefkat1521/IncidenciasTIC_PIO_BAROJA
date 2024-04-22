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



-- Crea la tabla Incidencias
CREATE TABLE Incidencias (
    id_incidencia VARCHAR(10) PRIMARY KEY ,
    fecha DATE,
    descripcion VARCHAR(255),
    ciclo VARCHAR(50),
    ID_Aula INT,
    ID_Profe INT,
    id_tipo_incidencia VARCHAR(5),
    niveldeprioridad INT CHECK (niveldeprioridad IN (1, 2, 3)),
    Estado VARCHAR(20) CHECK (Estado IN ('Solucionado', 'Pendiente', 'En_proceso')),
    FOREIGN KEY (ID_Aula) REFERENCES Aula(ID_Aula) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo_incidencia) REFERENCES Tipo_Incidencia(id_tipo_incidencia) ON DELETE CASCADE,
    FOREIGN KEY (ID_Profe) REFERENCES Profesor(ID_Profe)
);

/******************************************************************************************************/

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)), 
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Software'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Hardware'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Conectividad'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Recursos EducaMadrid'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Office 365/Teams'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'PDI'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Impresión'
);

INSERT INTO Tipo_Incidencia (id_tipo_incidencia, tipo_incidencia) 
VALUES (
    CONCAT(
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(65 + RAND() * 26)),  
        LPAD(FLOOR(RAND() * 1000), 3, '0')  
    ),
    'Otros'
);
/*/////////////////////////////////////////////////////////////-*/


-- Inserta varias aulas en la tabla Aula
INSERT INTO Aula (ID_Aula, Nombre_aula) VALUES
(1, 'Salon de actos'),
(2, 'Despacho');


INSERT INTO Aula (ID_Aula, Nombre_aula, Num_Aula) VALUES
(3, '2.1', 2.1),
(4, '2.2', 2.2),
(5, '2.3', 2.3);

/*/////////////////////////////////////////////////////////////-*/


INSERT INTO Departamento (dep, Nombre_dep) VALUES
(1, 'Departamento A'),
(2, 'Departamento B'),
(3, 'Departamento C');

/*admin*/
INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) 
VALUES (FLOOR(RAND() * 90000) + 10000, 'maite', 'maite@educa.madrid.org', 'admin', 1);

INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES
(FLOOR(RAND() * 90000) + 10000, 'user1', 'user1@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 1),
(FLOOR(RAND() * 90000) + 10000, 'user2', 'user2@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 1),
(FLOOR(RAND() * 90000) + 10000, 'user3', 'user3@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 2),
(FLOOR(RAND() * 90000) + 10000, 'user4', 'user4@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 2),
(FLOOR(RAND() * 90000) + 10000, 'user5', 'user5@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 3);


