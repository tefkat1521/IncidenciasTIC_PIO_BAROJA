<?php
    require "clases/incidencias.php";
    $incidencias = new Incidencias();



    if(isset($_POST["submit"])) {
        $id_incidencia = $_POST['id'];
    
        // Verificar si se completó el campo de estado
        if(isset($_POST['estado']) && !empty($_POST['estado'])) {
            $estado = $_POST['estado'];
            $incidencias->update_incidencia_estado($id_incidencia, $estado);
            
            // $remitente = 'jesusutrillagonzalez@gmail.com';
            // $destinatario = 'victoria.mdorado2@gmail.com';
            // $asunto = 'Prueba de correo electrónico';
            // $mensaje = 'Este es un correo de prueba enviado desde PHP. Se ha solucionado la incidencia con id: '. $_POST['id'];

            // if ($incidencias->enviarCorreo($remitente, $destinatario, $asunto, $mensaje)) {
            //     echo 'El correo se envió correctamente.';
            // } else {
            //     echo 'Hubo un error al enviar el correo.';
            // }

        }
    
        // Verificar si se completó el campo de urgencia
        if(isset($_POST['urgencia']) && !empty($_POST['urgencia'])) {
            $urgencia = $_POST['urgencia'];
            $incidencias->update_incidencia_prioridad($id_incidencia, $urgencia);
        }
    
        // Si no se completó ningún campo, mostrar un mensaje de error
        if(empty($_POST['estado']) && empty($_POST['urgencia'])) {
            echo "Por favor complete al menos uno de los campos.";
        }
    }
    if(isset($_POST["submitborrado"]))
    {
        $id_incidencia = $_POST['id2'];
        $incidencias->borrar_incidencia($id_incidencia);
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

        $incidencias = new incidencias();
        $array_incidencias = $incidencias->get_incidencias_datos();

            if (count($array_incidencias) > 0) 
            {
                foreach($array_incidencias as $laincidencia)
                {
                    if($laincidencia["niveldeprioridad"]==1){$prioridad = "Baja";}
                    elseif($laincidencia["niveldeprioridad"]==2){$prioridad = "Media";}
                    elseif($laincidencia["niveldeprioridad"]==NULL){$prioridad = "Sin asignar";}
                    else{$prioridad = "Alta";}
    ?>              
                    <div class="inc<?php echo $laincidencia["estado"]; ?>">
                        <ul>
                            <li>Fecha: <?php echo $laincidencia["fecha"]; ?> </li>
                            <li>Aula: <?php echo $laincidencia["Nombre_aula"]; ?> </li>
                            <li>Ciclo: <?php echo $laincidencia["ciclo"]; ?> </li>
                            <li>Tipo: <?php echo $laincidencia["tipo_incidencia"]; ?> </li>
                            <li><?php echo $laincidencia["descripcion"]; ?> </li>
                            <li>Estado: <?php echo $laincidencia["estado"]; ?> </li>
                            <li>Nivel de urgencia: <?php echo $prioridad; ?> </li>
                            
                        </ul>

                        <?php 
                            if($laincidencia["estado"]!="Solucionado")
                            {
                        ?>

                                <div id="form">
                                    
                                    <label>Cambiar estado</label>
                                    <form method="post" action="tablaincidenciasV2.php">
                                        <select name="estado">
                                            <option value="" selected disabled>Seleccionar estado</option>
                                            <option value ="Creada" >Creada</option>
                                            <option value ="En_proceso">En proceso</option>
                                            <option value ="Solucionado">Solucionado</option>
                                        <select>
                                    <br>
                                        <label>Asignar Prioridad</label>
                                        <select name="urgencia">
                                            <option value="" selected disabled>Seleccionar urgencia</option>
                                            <option value ="1">Baja</option>
                                            <option value ="2">Media</option>
                                            <option value ="3">Alta</option>
                                        <select>

                                        <input type="hidden" name="id" value="<?php echo $laincidencia["id_incidencia"]; ?>">
                                        <input type=submit name="submit" value="Actualizar">
                                    </form>

                                    <br><br>
 

                                </div>

                            <?php
                            }
                            ?>

                                <div id="borrado">
                                    <form method="post" action="tablaincidenciasV2.php">
                                        <input type="hidden" name="id2" value="<?php echo $laincidencia["id_incidencia"]; ?>">
                                        <input type=submit name="submitborrado" value="Borrar">
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