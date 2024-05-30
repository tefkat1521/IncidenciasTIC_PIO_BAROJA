
    $html_output = '<div class="container pricePadd" id="incidencias">';

     $contador = 1;
    
    foreach($array_incidencias as $index => $laincidencia) {
        
        if($laincidencia["niveldeprioridad"]==1){$prioridad = "Baja";}
        elseif($laincidencia["niveldeprioridad"]==2){$prioridad = "Media";}
        elseif($laincidencia["niveldeprioridad"]==3){$prioridad = "Alta";}
        else{$prioridad = "Sin asignar";}
        
        if($laincidencia["ciclo"]==null){$ciclo = "-----";}
        else{$ciclo = $laincidencia["ciclo"];}

        $fecha = new DateTime($laincidencia["fecha"]);
        $fechaFormateada = $fecha->format('d-m-Y');

        $html_output .= '
        <div class="col-md-3 inc' . htmlspecialchars($laincidencia["estado"]) . '" onclick="editarIncidencia(' . htmlspecialchars($contador) . ')" data-numIncidencia="' . htmlspecialchars($contador) . '">
        <div  class="panel panel-default">
    <div id="blue" class="panel-heading">
        <h3 class="panel-title">Basic</h3>
    </div>
    <div class="panel-body">
            <ul>
            <li class="list-group-item"><b>Fecha: </b>'. $fechaFormateada .'</li>
            <li class="list-group-item"><b>Aula: </b>'. $laincidencia["Nombre_aula"] .'</li>
            <li class="list-group-item"><b>'. $ciclo .'</li>
            <li class="list-group-item"><b>'. $laincidencia["tipo_incidencia"] .'</li>
            <li class="list-group-item"><b>'. $laincidencia["estado"] .'</li>
            <li class="list-group-item"><b>Urgencia: </b>'. $prioridad .'</li>
            <li class="list-group-item">'. $laincidencia["descripcion"] .'</li>
            </ul>';

        if($laincidencia["estado"] != "Solucionado") {
            $html_output .= '
            <button id="toggle-pencil-' . $index . '" class="btn btn-default toggle-pencil">Estado
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <button id="toggle-sort-' . $index . '" class="btn btn-default toggle-sort">Prioridad
                <span class="glyphicon glyphicon-sort-by-attributes"></span>
            </button>
            <br><br>
            <div id="form1-' . $index . '" style="display: none">
                <form method="post" action="admin.php">
                    <label>Cambiar estado</label><br>
                    <select name="estado">
                        <option value="" selected disabled>Seleccionar estado</option>
                        <option value="Creada">Creada</option>
                        <option value="En_proceso">En proceso</option>
                        <option value="Solucionado">Solucionado</option>
                    </select>
                    <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                    <input class="botonactualizar" type="submit" name="submit" value="Actualizar">
                </form>
            </div>
            <br>
            <div id="form2-' . $index . '" style="display: none">
                <form method="post" action="admin.php">
                    <label>Asignar Prioridad</label><br>
                    <select name="urgencia">
                        <option value="" selected disabled>Seleccionar urgencia</option>
                        <option value="1">Baja</option>
                        <option value="2">Media</option>
                        <option value="3">Alta</option>
                    </select>
                    <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                    <input class="botonactualizar" type="submit" name="submit" value="Actualizar">
                </form>
            </div>
            <div id="form3-' . $index . '" style="display: none">
                <form method="post" action="admin.php">
                    <label>Cambiar estado</label><br>
                    <select name="estado2" required>
                        <option value="" selected disabled>Seleccionar estado</option>
                        <option value="Creada">Creada</option>
                        <option value="En_proceso">En proceso</option>
                        <option value="Solucionado">Solucionado</option>
                    </select>
                    <br>
                    <label>Asignar Prioridad</label><br>
                    <select name="urgencia2" required>
                        <option value="" selected disabled>Seleccionar urgencia</option>
                        <option value="1">Baja</option>
                        <option value="2">Media</option>
                        <option value="3">Alta</option>
                    </select>
                    <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                    <input class="botonactualizar" type="submit" name="submit2" value="Actualizar">
                </form>
            </div>
            <br>
        ';
        
        }

        $html_output .= '
            <div id="borrado">
                <form method="post" action="admin.php">
                    <input type="hidden" name="id2" value="' . $laincidencia["id_incidencia"] . '">
                    <span class="glyphicon glyphicon-trash" type="submit" name="submitborrado"></span>
                    <input class="botonborrar" type="submit" name="submitborrado" value="Borrar">
                    
                </form>
            </div>
        </div>';

        // array_push($arrContIncidencias, $laincidencia["id_incidencia"]);
        $arrContIncidencias[] = $laincidencia["id_incidencia"];
        $contador++;
       
    }

    $html_output .= '</div>';
} else {
    $html_output = '<div>No existen incidencias</div>';
}