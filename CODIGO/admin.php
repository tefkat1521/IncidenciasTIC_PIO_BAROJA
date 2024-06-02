<?php
ini_set("SMTP", "smtp.gmail.com");
ini_set("smtp_port", "465");

require "clases/incidencias.php";
require "clases/profesor.php";
require "clases/departamento.php";
$deps = new departamento();
$array_deps = $deps->get_departamento();

global $arrContIncidencias;
$arrContIncidencias[] = array();


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
        if($estado == "Solucionado")
        {
            $incidencias->enviarCorreo($id_incidencia);
        }
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

if(isset($_POST["submit2"])) {

    $id_incidencia = $_POST['id'];
    $estado = $_POST['estado2'];
    $urgencia = $_POST['urgencia2'];
    $incidencias = new Incidencias();
    $incidencias->update_incidencia_estado_y_prioridad($id_incidencia, $estado, $urgencia);
    if($estado == "Solucionado")
    {
        $incidencias->enviarCorreo($id_incidencia);
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

       // Determinar el color del panel según el estado
       $panel_color = '';
       switch ($laincidencia["estado"]) {
           case 'Creada':
               $panel_color = 'blue';
               break;
           case 'En_proceso':
               $panel_color = 'orange';
               break;
           case 'Solucionado':
               $panel_color = 'green';
               break;
           default:
               $panel_color = '';
               break;
       }


       $html_output .= '
       
       <div class="col-md-3 inc' . htmlspecialchars($laincidencia["estado"]) . '" onclick="editarIncidencia(' . htmlspecialchars($contador) . ')" data-numIncidencia="' . htmlspecialchars($contador) . '">
       <div  class="panel panel-default">
   <div id="'.$panel_color.'" class="panel-heading">
       <h3 class="panel-title">'.$laincidencia["estado"].'</h3>
   </div>

   <div class="panel-body d-flex flex-column">

 



<ul class="list-group" style="margin-bottom: 10px;">
    <li class="list-group-item"><b>Fecha: </b>' . $fechaFormateada . '</li>
    <li class="list-group-item"><b>Aula: </b>' . $laincidencia["Nombre_aula"] . '</li>
    <li class="list-group-item"><b>' . $ciclo . '</b></li>
    <li class="list-group-item"><b>' . $laincidencia["tipo_incidencia"] . '</b></li>
    <li class="list-group-item"><b>Urgencia: </b>' . $prioridad . '</li>

    <li id="descrip" class="list-group-item">' . $laincidencia["descripcion"] . '  
  
    </li>
  
</ul>';

       if($laincidencia["estado"] != "Solucionado") {
           $html_output .= '
           <div class="botoncicos">
           <button id="toggle-pencil-' . $index . '" class="btn btn-default toggle-pencil custom-btn-width">Estado
           </button>
           <button id="toggle-sort-' . $index . '" class="btn btn-default toggle-sort custom-btn-width">Prioridad
           </button>
           </div>

           <div id="form1-' . $index . '" style="display: none">
               <form method="post" action="admin.php">
                   
                   <select name="estado">
                       <option value="" selected disabled>Cambiar estado</option>
                       <option value="Creada">Creada</option>
                       <option value="En_proceso">En proceso</option>
                       <option value="Solucionado">Solucionado</option>
                   </select>
                   <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                   <input class="botonactualizar" type="submit" name="submit" value="Actualizar">
               </form>
           </div>
           
           <div id="form2-' . $index . '" style="display: none">
               <form method="post" action="admin.php">
                
                   <select name="urgencia">
                       <option value="" selected disabled>Asignar Prioridad</option>
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
                   <select name="estado2" required>
                       <option value="" selected disabled>Cambiar estado</option>
                       <option value="Creada">Creada</option>
                       <option value="En_proceso">En proceso</option>
                       <option value="Solucionado">Solucionado</option>
                   </select>
                   
                   <select name="urgencia2" required>
                       <option value="" selected disabled>Asignar Prioridad</option>
                       <option value="1">Baja</option>
                       <option value="2">Media</option>
                       <option value="3">Alta</option>
                   </select>
                   <input type="hidden" name="id" value="' . $laincidencia["id_incidencia"] . '"><br>
                   <input class="botonactualizar" type="submit" name="submit2" value="Actualizar">
               </form>
           </div>';
       
       }

       $html_output .= '
         


           <div id="borrado">
            <form method="post" action="admin.php">
                <input type="hidden" name="id2" value="' . $laincidencia["id_incidencia"] . '">
                <button class="btn btn-default btn-trash" type="submit" name="submitborrado">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            </form>
        </div>




           </div>
           </div>
       </div>';

       // array_push($arrContIncidencias, $laincidencia["id_incidencia"]);
    //    $arrContIncidencias[] = $laincidencia["id_incidencia"];
    //    $contador++;
      
   }

   $html_output .= '</div>';
} else {
   $html_output = '<div>No existen incidencias</div>';
}
// unset($arrContIncidencias);
// Devuelve la salida HTML
echo $html_output;

}







function procesarFormulario() {
    if(isset($_POST["hecho"])) { 
        if ($_POST['pass'] != $_POST['confirmPass']) {
            // echo '<div class="message-box">Usuario no insertado, las contraseñas no coinciden. Redirigiendo...</div>';

            echo "<script>
                setTimeout(function() {
                    window.location.href = 'admin.html';
                }, 3000); // Redirige después de 3 segundos
            </script>";

            // Asegurarse de que el script se detenga
            exit();
        
        }else {
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
}
function generarFormulario($array_deps) {
    $out = '<div class="col-md-8 crearprofe">';
    // $out .= '<form method="post" action="code.php">';
    $out .= '';
    $out .= '<form id="loginform" action="admin.php" method="post">';

    // $out .= '<label>Nombre Completo</label>';
    $out .= '<input type="text" name="nombre" class="form-control myInputFooter required" required placeholder="Nombre completo"/><br>';
    

    // $out .= '<label>Correo</label>';
    $out .= '<input type="text" name="correo" class="form-control myInputFooter required" required placeholder="Correo"/><br>';

    // $out .= '<label>Departamento</label>';
    $out .= '<select name="dept" class="form-control myInputFooter required" required>';
    $out .= '<option value="" selected disabled hidden style="color: #999;">Departamento</option>'; // Placeholder
    foreach($array_deps as $depart) {
        $out .= "<option value='".$depart['dep']."'>".$depart['Nombre_dep']."</option>";
    }
    $out .= '</select><br><br>';
    


    // $out .= '<label>Contraseña</label>';
    $out .= '<input type="password" name="pass" class="form-control myInputFooter required" required pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])([^\s]){3,}$" placeholder="Contraseña"/><br>';
    // $out .= '<label>Repita la contraseña</label>';
    $out .= '<input type="password" name="confirmPass" class="form-control myInputFooter required" required  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])([^\s]){3,}$" placeholder="Repita la Contraseña"/><br>';
    $out .= '<input type="submit" name="hecho" value="CREAR" class="form-control myButton">';
    $out .= '</form>';
    $out .= '<br><p><b>Nota:</b> la contraseña debe tener 3 dígitos, un número y una mayúscula.</p>';
    $out .= '</div>';
    echo $out;
}

?>