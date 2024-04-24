<?php
    require "clases/incidencias.php";
    $incidencias = new Incidencias();

            if(isset($_POST["EST"]))
            {  
                $incidencias->update_incidencia_estado($_POST['id'], $_POST['estado']);
            }
            elseif(isset($_POST["URG"]))
            {
                $incidencias->update_incidencia_prioridad($_POST['id'], $_POST['urgencia']);
            }
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
        $array_incidencias = $incidencias->get_incidencias_datos();

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
                            <li>Estado: <?php echo $laincidencia["estado"]; ?> </li>
                        </ul>

                        <div id="estado">
                            <label>Cambiar estado</label>
                            <form method="post" action="tablaincidenciasV2.php">
                                <select name="estado" required>
                                    <option value ="Pendiente" selected>Pendiente</option>
                                    <option value ="En_proceso">En proceso</option>
                                    <option value ="Solucionado">Solucionado</option>
                                <select>
                                <input type="hidden" name="id" value="<?php echo $laincidencia["id_incidencia"]; ?>">
                                <input type=submit name="EST" value="Cambiar">
                            </form>
                        </div>

                        <div id="urgencia">
                            <label>Agregar Prioridad</label>
                            <form method="post" action="tablaincidenciasV2.php">
                                <select name="urgencia" required>
                                    <option value ="1">Baja</option>
                                    <option value ="2">Media</option>
                                    <option value ="3">Alta</option>
                                <select>
                                <input type="hidden" name="id" value="<?php echo $laincidencia["id_incidencia"]; ?>">
                                <input type=submit name="URG" value="Cambiar">
                            </form>
                        </div>

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