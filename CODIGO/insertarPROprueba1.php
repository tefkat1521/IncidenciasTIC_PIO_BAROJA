<?php

        $conexion = mysqli_connect("localhost","root","","incidencias_tic");        
        mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();}

        $id = $numero_aleatorio = rand(10000, 99999);
        $nombre = $_GET['nombre'];
        $correo = $_GET['correo'];
        $contrasena = $_GET['pass'];
        $departamento = $_GET['dept'];

        $profesor = mysqli_query($conexion, "INSERT INTO Profesor (ID_Profe, nombre, correo, clave_acceso, dep) VALUES (".$id.", '".$nombre."', '".$correo."', '".$contrasena."', ".$departamento.")");
        
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();
        }
 ?>