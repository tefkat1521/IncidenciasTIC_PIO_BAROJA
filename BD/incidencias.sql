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
    clave_acceso VARCHAR(50),
    dep INT,
    FOREIGN KEY (dep) REFERENCES Departamento(dep) ON DELETE CASCADE
);

-- Crea la tabla Aula
CREATE TABLE Aula (
    N_Aula FLOAT PRIMARY KEY
);

-- Crea la tabla Incidencias
CREATE TABLE Incidencias (
    id_incidencia INT PRIMARY KEY AUTO_INCREMENT,
    tipo CHAR(1),
    fecha DATE,
    descripcion VARCHAR(255),
    N_Aula FLOAT,
    ID_Profe INT,
    Estado CHAR(1),
    FOREIGN KEY (N_Aula) REFERENCES Aula(N_Aula) ON DELETE CASCADE,
    FOREIGN KEY (ID_Profe) REFERENCES Profesor(ID_Profe) ON DELETE CASCADE
);