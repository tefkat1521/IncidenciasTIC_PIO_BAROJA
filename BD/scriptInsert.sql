
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


INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES
(1, 'user1', 'user1@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 1),
(2, 'user2', 'user2@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 1),
(3, 'user3', 'user3@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 2),
(4, 'user4', 'user4@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 2),
(5, 'user5', 'user5@educa.madrid.org', SUBSTRING(MD5(RAND()) FROM 1 FOR 8), 3);



