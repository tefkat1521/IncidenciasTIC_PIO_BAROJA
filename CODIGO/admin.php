<?php
require "clases/incidencias.php";


if (isset($_POST['PaginaAdmin'])) {
    mostrarIncidencias();
}
if(isset($_POST["submit"])) {

    $id_incidencia = $_POST['id'];

    // Verificar si se completó el campo de estado
    if(isset($_POST['estado']) && !empty($_POST['estado'])) {
        $estado = $_POST['estado'];
        $incidencias = new Incidencias();
        $incidencias->update_incidencia_estado($id_incidencia, $estado);
    }

    // Verificar si se completó el campo de urgencia
    if(isset($_POST['urgencia']) && !empty($_POST['urgencia'])) {
        $urgencia = $_POST['urgencia'];
        $incidencias = new Incidencias();
        $incidencias->update_incidencia_prioridad($id_incidencia, $urgencia);
    }

    // Si no se completó ningún campo, mostrar un mensaje de error
    if(empty($_POST['estado']) && empty($_POST['urgencia'])) {
        echo "Por favor complete al menos uno de los campos.";
    }
    header("Location: admin.html");
    exit;
}
if(isset($_POST["submitborrado"]))
    {
        $id_incidencia = $_POST['id2'];
        $incidencias->borrar_incidencia($id_incidencia);
    }


function mostrarIncidencias(){
    ob_start(); // Inicia el búfer de salida

    // require "clases/incidencias.php";
    // $incidencias = new Incidencias();
    $incidencias = new Incidencias();

    
    // Almacena la parte HTML en una variable
    
    
  
    $array_incidencias = $incidencias->get_incidencias_datos();
    
    if (count($array_incidencias) > 0) 
    {
        $html_output = '<div id=incidencias>';

        foreach($array_incidencias as $laincidencia)
        {
            if($laincidencia["niveldeprioridad"]==1){$prioridad = "Baja";}
            elseif($laincidencia["niveldeprioridad"]==2){$prioridad = "Media";}
            elseif($laincidencia["niveldeprioridad"]==NULL){$prioridad = "Sin asignar";}
            else{$prioridad = "Alta";}
            
            $html_output .= '
            <div class="inc'. $laincidencia["estado"] .'">
                <ul>
                    <li>Fecha: '. $laincidencia["fecha"] .'</li>
                    <li>Aula: '. $laincidencia["Nombre_aula"] .'</li>
                    <li>Ciclo: '. $laincidencia["ciclo"] .'</li>
                    <li>Tipo: '. $laincidencia["tipo_incidencia"] .'</li>
                    <li>'. $laincidencia["descripcion"] .'</li>
                    <li>Estado: '. $laincidencia["estado"] .'</li>
                    <li>Nivel de urgencia: '. $prioridad .'</li>
                </ul>';
    
            if($laincidencia["estado"]!="Solucionado")
            {
                $html_output .= '
                <div id="form">
                    <form method="post" action="admin.php">
                    <label>Cambiar estado</label><br>
                        <select name="estado">
                            <option value="" selected disabled>Seleccionar estado</option>
                            <option value="Creada">Creada</option>
                            <option value="En_proceso">En proceso</option>
                            <option value="Solucionado">Solucionado</option>
                        </select>
                        <br>
                        <label>Asignar Prioridad</label><br>
                        <select name="urgencia">
                            <option value="" selected disabled>Seleccionar urgencia</option>
                            <option value="1">Baja</option>
                            <option value="2">Media</option>
                            <option value="3">Alta</option>
                        </select>
                        <input type="hidden" name="id" value="'. $laincidencia["id_incidencia"].'"><br>
                        <input type="submit" name="submit" value="Actualizar">
                    </form>
                </div> <br>';
                
            }
            
            $html_output .= '
                <div id="borrado">
                    <form method="post" action="admin.php">
                        <input type="hidden" name="id2" value="<?php echo $laincidencia["id_incidencia"]; ?>
                        <input type=submit name="submitborrado" value="Borrar">
                    </form>
                </div>
            
            </div>';
        }
    
        $html_output .= '</div>';

    }
    else
    {
        $html_output .= '<div>No existen incidencias</div>';
    }
    
    // Devuelve la salida HTML
    echo $html_output;
}

?>
