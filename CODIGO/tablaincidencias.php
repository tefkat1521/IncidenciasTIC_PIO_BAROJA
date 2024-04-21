<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestor de Incidencias TIC</title>
    <link rel="stylesheet" href="tablaincidencias.css">
</head>
<body>
    <p>Amarillo -> no esta en revision ,  Rojo -> en proceso de solucion,  Verde -> hecha</p>
    <div id=incidencias>
    <?php

    //Comprobaciones de cookies y sesiones
    /**
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

        $conexion = mysqli_connect("localhost","root",'',"incidencias_tic");
        mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");
        if (mysqli_connect_errno()) {
            printf("<p>Conexión fallida: %s</p>", mysqli_connect_error());
            exit();}


            $incidencias = mysqli_query($conexion, 
            "SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.niveldeprioridad, i.estado, t.tipo_incidencia 
            FROM Incidencias i, Aula a , Tipo_Incidencia t
            WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia 
            ORDER BY i.niveldeprioridad DESC;");
            $NI = mysqli_num_rows($incidencias);

            if ($NI > 0) 
            {
                while ($INC = mysqli_fetch_array($incidencias, MYSQLI_ASSOC)) 
                {
    ?>
                    <div class="inc<?php echo $INC["estado"]; ?>">
                        <ul>
                            <li>Fecha: <?php echo $INC["fecha"]; ?> </li>
                            <li>Aula: <?php echo $INC["Nombre_aula"]; ?> </li>
                            <li>Tipo: <?php echo $INC["tipo_incidencia"]; ?> </li>
                            <li><?php echo $INC["descripcion"]; ?> </li>
                            <li>Nivel de urgencia: <?php echo $INC["niveldeprioridad"]; ?> </li>
                        </ul>

                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="revision" value="<?php echo $INC["id_incidencia"]; ?>">
                        <input type=submit name="AREVISION" value="En proceso">
                        </form>

                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="solucionado" value="<?php echo $INC["id_incidencia"]; ?>">
                        <input type=submit name="ARESUELTAS" value="Hecha">
                        </form>

                        <!--No es necesario , pero es de prueba -->
                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="pendiente" value="<?php echo $INC["id_incidencia"]; ?>">
                        <input type=submit name="APENDIENTE" value="Pasar a pendiente ">
                        </form>

                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="borrar" value="<?php echo $INC["id_incidencia"]; ?>">
                        <input type=submit name="ABORRAR" value="Dar por terminada y borrar">
                        </form>

                    </div>
    
         
    <?php
                }
    ?>
    </div>
    <?php
            }
            else
            {
    ?>              
                    <div>No existen incidencias</div>
    <?php
            }

    ?>
    

</body>
</html>