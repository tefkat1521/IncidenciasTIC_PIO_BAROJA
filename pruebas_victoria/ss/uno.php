
$MostrarIncidencia = '<div class="container pricePadd" id="incidencias">';

// Desglosa la incidencia en variables individuales
if($array_incidencias["niveldeprioridad"]==1){
    $prioridad = "Baja";
} elseif($array_incidencias["niveldeprioridad"]==2){
    $prioridad = "Media";
} elseif($array_incidencias["niveldeprioridad"]==3){
    $prioridad = "Alta";
} else {
    $prioridad = "Sin asignar";
}

$fecha = new DateTime($array_incidencias["fecha"]);
$fechaFormateada = $fecha->format('d-m-Y');

// Construye el HTML de la incidencia
$MostrarIncidencia .= '
    <div class="col-md-3 inc' . htmlspecialchars($array_incidencias["estado"]) . '">

    <div  class="panel panel-default">
    <div id="blue" class="panel-heading">
        <h3 class="panel-title">Basic</h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item"><b>Fecha: </b>'. $fechaFormateada .'</li>
            <li class="list-group-item"><b>Aula: </b>'. $array_incidencias["Nombre_aula"] .'</li>
            <li class="list-group-item"><b>Ciclo: </b>'. $array_incidencias["ciclo"] .'</li>
            <li class="list-group-item"><b>Tipo: </b>'. $array_incidencias["tipo_incidencia"] .'</li>
            <li class="list-group-item"><b>Estado: </b>'. $array_incidencias["estado"] .'</li>
            <li class="list-group-item"><b>Urgencia: </b>'. $prioridad .'</li>
            <li class="list-group-item">'. $array_incidencias["descripcion"] .'</li>
        </ul>';

if($array_incidencias["estado"] != "Solucionado") {
    $MostrarIncidencia .= '
        <button id="toggle-pencil" class="btn btn-default toggle-pencil">Estado
            <span class="glyphicon glyphicon-pencil"></span>
        </button>
        <button id="toggle-sort" class="btn btn-default toggle-sort">Prioridad
            <span class="glyphicon glyphicon-sort-by-attributes"></span>
        </button>
        <br><br>
        <div id="form1" style="display: none">
            <form method="post" action="admin.php">
                <label>Cambiar estado</label><br>
                <select name="estado">
                    <option value="" selected disabled>Seleccionar estado</option>
                    <option value="Creada">Creada</option>
                    <option value="En_proceso">En proceso</option>
                    <option value="Solucionado">Solucionado</option>
                </select>
                <input type="hidden" name="id" value="' . $array_incidencias["id_incidencia"] . '"><br>
                <input class="botonactualizar" type="submit" name="submit" value="Actualizar">
            </form>
        </div>
        <br>
        <div id="form2" style="display: none">
            <form method="post" action="admin.php">
                <label>Asignar Prioridad</label><br>
                <select name="urgencia">
                    <option value="" selected disabled>Seleccionar urgencia</option>
                    <option value="1">Baja</option>
                    <option value="2">Media</option>
                    <option value="3">Alta</option>
                </select>
                <input type="hidden" name="id" value="' . $array_incidencias["id_incidencia"] . '"><br>
                <input class="botonactualizar" type="submit" name="submit" value="Actualizar">
            </form>
        </div>
        <div id="form3" style="display: none">
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
                <input type="hidden" name="id" value="' . $array_incidencias["id_incidencia"] . '"><br>
                <input class="botonactualizar" type="submit" name="submit2" value="Actualizar">
            </form>
        </div>
        <br>
    ';

$MostrarIncidencia .= '
        <div id="borrado">
            <form method="post" action="admin.php">
                <input type="hidden" name="id2" value="' . $array_incidencias["id_incidencia"] . '">
                <span class="glyphicon glyphicon-trash" type="submit" name="submitborrado"></span>
                <input class="botonborrar" type="submit" name="submitborrado" value="Borrar">
                
            </form>
        </div>
    </div>
    </div>
    </div>';

$MostrarIncidencia .= '</div>';

// Imprime los detalles de la incidencia
echo $MostrarIncidencia+"hola";

// Captura la salida y devuelve como una variable
return ob_get_clean();
}
}
