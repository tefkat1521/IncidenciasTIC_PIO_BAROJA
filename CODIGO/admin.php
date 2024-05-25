<?php
ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "465");

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

// if (isset($_POST['PaginaAdmin'])) {
//     mostrarIncidencias("0");
// }
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

if(isset($_POST["value"])){
    mostrarIncidencias($_POST["value"]);
}

function mostrarIncidencias($filtro){
    ob_start(); // Inicia el búfer de salida

    // require "clases/incidencias.php";
    // $incidencias = new Incidencias();


    $incidencias = new Incidencias();

    switch ($filtro) {
        case '0':
            $array_incidencias = $incidencias->get_incidencias_datos();
            break;

            case 'Solucionado':
            $array_incidencias = $incidencias->get_incidencias_en_solucionado();
            break;

            case 'Creada':
            $array_incidencias = $incidencias->get_incidencias_en_pediente();
            break;

            case 'proceso':
            $array_incidencias = $incidencias->get_incidencias_en_proceso();
            break;

            case 'Alta':
            $array_incidencias = $incidencias->get_incidencias_prioridad_alta();
            break;

            case 'Media':
            $array_incidencias = $incidencias->get_incidencias_prioridad_media();
            break;

            case 'Baja':
            $array_incidencias = $incidencias->get_incidencias_prioridad_baja();
            break;

            case 'Nulo':
            $array_incidencias = $incidencias->get_incidencias_sin_asignar();
            break;
        
        default:
            # code...
            break;
    }
    //     if ($filtro == "0") {
    //     $array_incidencias = $incidencias->get_incidencias_datos();
    // }else {
    //     $array_incidencias = $incidencias->get_incidencias_en_solucionado();
    // }

    
    // Almacena la parte HTML en una variableiç


if (count($array_incidencias) > 0) {
    $html_output = '<div id="incidencias">';

    

    foreach($array_incidencias as $index => $laincidencia) {
        
        if($laincidencia["niveldeprioridad"]==1){$prioridad = "Baja";}
        elseif($laincidencia["niveldeprioridad"]==2){$prioridad = "Media";}
        elseif($laincidencia["niveldeprioridad"]==3){$prioridad = "Alta";}
        else{$prioridad = "Sin asignar";}

        $fecha = new DateTime($laincidencia["fecha"]);
        $fechaFormateada = $fecha->format('d-m-Y');

        $html_output .= '
        <div class="inc'. $laincidencia["estado"] .'">
        <div class="chincheta"></div>
            <ul>
                <li><b>Fecha: </b>'. $fechaFormateada .'</li>
                <li><b>Aula: </b>'. $laincidencia["Nombre_aula"] .'</li>
                <li><b>Ciclo: </b>'. $laincidencia["ciclo"] .'</li>
                <li><b>Tipo: </b>'. $laincidencia["tipo_incidencia"] .'</li>
                <li><b>Estado: </b>'. $laincidencia["estado"] .'</li>
                <li><b>Urgencia: </b>'. $prioridad .'</li>
                <li>'. $laincidencia["descripcion"] .'</li>
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
                        <select name="estado2">
                            <option value="" selected disabled>Seleccionar estado</option>
                            <option value="Creada">Creada</option>
                            <option value="En_proceso">En proceso</option>
                            <option value="Solucionado">Solucionado</option>
                        </select>
                        <br>
                        <label>Asignar Prioridad</label><br>
                        <select name="urgencia2">
                            <option value="" selected disabled>Seleccionar urgencia</option>
                            <option value="1">Baja</option>
                            <option value="2">Media</option>
                            <option value="3">Alta</option>
                        </select>
                        <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                        <input class="botonactualizar" type="submit" name="submit" value="Actualizar">
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

       
    }

    $html_output .= '</div>';
} else {
    $html_output = '<div>No existen incidencias</div>';
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
    $out = '<div class="col-md-8" style="margin: 5em;">';
    // $out .= '<form method="post" action="code.php">';
    $out .= '';
    $out .= '<form id="loginform" action="admin.php" method="post">';

    // $out .= '<label>Nombre Completo</label>';
    $out .= '<input type="text" name="nombre" class="form-control myInputFooter required" required placeholder="Nombre completo"/><br>';
    

    // $out .= '<label>Correo</label>';
    $out .= '<input type="text" name="correo" class="form-control myInputFooter required" required placeholder="Correo"/><br>';

    // $out .= '<label>Departamento</label>';
    $out .= '<select name="dept" class="form-control myInputFooter required" required>';
    $out .= '<option value="" selected disabled hidden>Departamento</option>'; // Placeholder
    foreach($array_deps as $depart) {
        $out .= "<option value='".$depart['dep']."'>".$depart['Nombre_dep']."</option>";
    }
    $out .= '</select><br><br>';


    // $out .= '<label>Contraseña</label>';
    $out .= '<input type="password" name="pass" class="form-control myInputFooter required" required  placeholder="Contraseña"/><br>';
    // $out .= '<label>Repita la contraseña</label>';
    $out .= '<input type="password" class="form-control myInputFooter required" required  placeholder="Repita la Contraseña"/><br>';
    $out .= '<input type="submit" name="hecho" value="CREAR" class="form-control myButton">';
    $out .= '</form>';
    $out .= '</div>';
    echo $out;


// ini_set("SMTP", "smtp.gmail.com");
// ini_set("smtp_port", "587"); // Utiliza el puerto 587 para TLS

// $to = "dmarchenad123@gmail.com";
// $subject = "Ola";
// $message = "Hola, este es un correo de prueba enviado desde PHP.com";
// $headers = "From: dmarchenad123@gmail.com";

// // Envío del correo
// if (mail($to, $subject, $message, $headers)) {
//     echo $out;
// } else {
//     echo "Error al enviar el correo.";
// }
    
}






?>
