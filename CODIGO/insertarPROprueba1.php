<?php

        $conexion = mysqli_connect("localhost","root","","incidencias_tic");        
        mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();}

        $nombre = $_GET['nombre'];
        $correo = $_GET['correo'];
        $contrasena = $_GET['pass'];
        $departamento = $_GET['dept'];

        $profesor = mysqli_query($conexion, "INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES (".(FLOOR(RAND() * 90000) + 10000).", '".$nombre."', '".$correo."', '".$contrasena."', 1)");
        $NI = mysqli_num_rows($incidencias);
 ?>