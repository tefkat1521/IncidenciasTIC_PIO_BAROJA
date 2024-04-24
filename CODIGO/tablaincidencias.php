<?php
    require "clases/incidencias.php";
?>

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

        $incidencias = new incidencias();
        $array_incidencias = $incidencias->get_incidencias_por_profesor("user1");

            if (count($array_incidencias) > 0) 
            {
                foreach($array_incidencias as $laincidencia)
                {
    ?>
                    <div class="inc<?php echo $laincidencia["estado"]; ?>">
                        <ul>
                            <li>Fecha: <?php echo $laincidencia["fecha"]; ?> </li>
                            <li>Aula: <?php echo $laincidencia["Nombre_aula"]; ?> </li>
                            <li>Ciclo: <?php echo $laincidencia["ciclo"]; ?> </li>
                            <li>Tipo: <?php echo $laincidencia["tipo_incidencia"]; ?> </li>
                            <li><?php echo $laincidencia["descripcion"]; ?> </li>
                            <li>Nivel de urgencia: <?php echo $laincidencia["niveldeprioridad"]; ?> </li>
                        </ul>

                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="revision" value="<?php echo $IlaincidenciaNC["id_incidencia"]; ?>">
                        <input type=submit name="AREVISION" value="En proceso">
                        </form>

                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="solucionado" value="<?php echo $laincidencia["id_incidencia"]; ?>">
                        <input type=submit name="ARESUELTAS" value="Hecha">
                        </form>

                        <!--No es necesario , pero es de prueba -->
                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="pendiente" value="<?php echo $laincidencia["id_incidencia"]; ?>">
                        <input type=submit name="APENDIENTE" value="Pasar a pendiente ">
                        </form>

                        <form method="post" action="tablaincidenciasCambioestado.php">
                        <input type="hidden" name="borrar" value="<?php echo $laincidencia["id_incidencia"]; ?>">
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