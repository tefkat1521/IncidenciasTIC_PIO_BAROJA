<?php
require "clases/incidencias.php";
require "clases/profesor.php";
require "clases/departamento.php";
$deps = new departamento();
$array_deps = $deps->get_departamento();

if(isset($_POST["newProfesor"])){
    generarFormulario($array_deps);
} 
if(isset($_POST["hecho"])){
    
    procesarFormulario();
}

if (isset($_POST['PaginaAdmin'])) {
    mostrarIncidencias();
}
if(isset($_POST["submit"])) {

    $id_incidencia = $_POST['id'];

    // Verificar si se completó el campo de estado
    if(isset($_POST['estado'])) 
    {
        $estado = $_POST['estado'];
        $incidencias = new Incidencias();
        $incidencias->update_incidencia_estado($id_incidencia, $estado);
    }
    elseif(isset($_POST['urgencia']))
    {
        $urgencia = $_POST['urgencia'];
        $incidencias = new Incidencias();
        $incidencias->update_incidencia_prioridad($id_incidencia, $urgencia);
    }

    header("Location: admin.html");
    exit;
}
if(isset($_POST["submitborrado"]))
    {
        $id_incidencia = $_POST['id2'];
        $incidencias = new Incidencias();
        $incidencias->borrar_incidencia($id_incidencia);
        header("Location: admin.html");
        exit;
    }


function mostrarIncidencias(){
    ob_start(); // Inicia el búfer de salida

    // require "clases/incidencias.php";
    // $incidencias = new Incidencias();
    $incidencias = new Incidencias();

    
    // Almacena la parte HTML en una variable
$array_incidencias = $incidencias->get_incidencias_datos();

if (count($array_incidencias) > 0) {
    $html_output = '<div id="incidencias">';

    

    foreach($array_incidencias as $index => $laincidencia) {
        
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

        if($laincidencia["estado"] != "Solucionado") {
            $html_output .= '
                <button id="toggle-pencil-' . $index . '" class="btn btn-default">Estado
                    <span class="glyphicon glyphicon-pencil"></span>
                </button>
                
                <button id="toggle-sort-' . $index . '" class="btn btn-default">Prioridad
                    <span class="glyphicon glyphicon-sort-by-attributes"></span>
                </button>
                <br><br>
                <div id="form1-' . $index . '" style="visibility: hidden;">
                    <form method="post" action="admin.php">
                        <label>Cambiar estado</label><br>
                        <select name="estado">
                            <option value="" selected disabled>Seleccionar estado</option>
                            <option value="Creada">Creada</option>
                            <option value="En_proceso">En proceso</option>
                            <option value="Solucionado">Solucionado</option>
                        </select>
                        <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                        <input type="submit" name="submit" value="Actualizar">
                    </form>
                </div>
                <br>
                
                <div id="form2-' . $index . '" style="visibility: hidden;">
                    <form method="post" action="admin.php">
                        <label>Asignar Prioridad</label><br>
                        <select name="urgencia">
                            <option value="" selected disabled>Seleccionar urgencia</option>
                            <option value="1">Baja</option>
                            <option value="2">Media</option>
                            <option value="3">Alta</option>
                        </select>
                        <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                        <input type="submit" name="submit" value="Actualizar">
                    </form>
                </div>
                <br>
            ';
        }

        $html_output .= '
            <div id="borrado">
                <form method="post" action="admin.php">
                    <input type="hidden" name="id2" value="' . $laincidencia["id_incidencia"] . '">
                    <input type="submit" name="submitborrado" value="Borrar">
                </form>
            </div>
        </div>';

       
    }

    $html_output .= '</div>';
} else {
    $html_output .= '<div>No existen incidencias</div>';
}

// Devuelve la salida HTML
echo $html_output;

}






function procesarFormulario() {
    if(isset($_POST["hecho"])) { 
        $prof = new profesor();
        $prof->insertar_profesor($_POST["nombre"], $_POST["correo"], $_POST["pass"], $_POST["dept"]);
        if($prof) {
            echo "Insertado profesor: " . $_POST["nombre"];
            echo " Redirigiendo...";
            header("Location: admin.html"); // Redirige a admin.html
            exit; // Asegura que el script se detenga después de la redirección
        }
    }
}
function generarFormulario($array_deps) {
    $out = '';
    $out .= '<form id="loginform" action="admin.php" method="post">';
    $out .= '<label>Nombre Completo</label>';
    $out .= '<input type="text" name="nombre" required/><br>';
    $out .= '<label>Correo</label>';
    $out .= '<input type="text" name="correo" required/><br>';
    $out .= '<label>Departamento</label>';
    $out .= '<select name="dept" required>';
    foreach($array_deps as $depart) {
        $out .= "<option value='".$depart['dep']."'>".$depart['Nombre_dep']."</option>";
    }
    $out .= '</select><br><br>';
    $out .= '<label>Contraseña</label>';
    $out .= '<input type="password" name="pass" required/><br>';
    $out .= '<label>Repita la contraseña</label>';
    $out .= '<input type="password" required/><br>';
    $out .= '<input type="submit" name="hecho" value="CREAR">';
    $out .= '</form>';
    echo $out;
}






?>
