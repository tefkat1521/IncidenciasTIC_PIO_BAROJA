<?php
    $conexion = mysqli_connect("localhost","root",'',"incidencias_tic");
    mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");

    if(isset($_POST["AREVISION"]))
    {
        
        $resultado = mysqli_query($conexion, "UPDATE Incidencias SET Estado = 'En_proceso' WHERE id_incidencia = '". $_POST['revision']."'");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();
        }
        header("Location: tablaincidencias.php"); 
        exit(); 

    }
    elseif(isset($_POST["ARESUELTAS"]))
    {

        $resultado = mysqli_query($conexion, "UPDATE Incidencias SET Estado = 'Solucionado' WHERE id_incidencia = '". $_POST['solucionado']."'");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();
        }
        header("Location: tablaincidencias.php"); 
        exit(); 

    }
    elseif(isset($_POST["APENDIENTE"]))
    {

        $resultado = mysqli_query($conexion, "UPDATE Incidencias SET Estado = 'Pendiente' WHERE id_incidencia = '". $_POST['pendiente']."'");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();
        }
        header("Location: tablaincidencias.php"); 
        exit(); 

    }


?>