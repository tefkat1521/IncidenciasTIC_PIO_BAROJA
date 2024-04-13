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
    ID_Aula INT,
    ID_Profe INT,
    id_tipo_incidencia VARCHAR(5),
    Estado VARCHAR(20) CHECK (Estado IN ('Solucionado', 'Pendiente', 'En proceso')),
    FOREIGN KEY (ID_Aula) REFERENCES Aula(ID_Aula) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo_incidencia) REFERENCES Tipo_Incidencia(id_tipo_incidencia) ON DELETE CASCADE,
    FOREIGN KEY (ID_Profe) REFERENCES Profesor(ID_Profe)
);



-- CREATE TABLE Recurso (
--     id_recurso VARCHAR(5) PRIMARY KEY,
--     tipo_incidencia VARCHAR(50),
-- );