<?php
    require "clases/incidencias.php";
    require "clases/aulas.php";
    require "clases/ciclo.php";
    require "clases/profesor.php";
    require "clases/tipo_incidencia.php";

// Inicializamos la base de datos.
// $conexion = mysqli_connect('127.0.0.1', 'admindb', 'admin', 'incidencias_tic');
// mysqli_select_db($conexion, "incidencias_tic") or die("No se puede seleccionar la BD");

session_start(); // Inicializamos variables de sesión
<<<<<<< HEAD
echo("uno");

// Habilitar la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Comprobar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos necesarios están presentes en la solicitud POST
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        echo $user;
        comprobarCredenciales();
    } else {
        // Manejar el caso en que los datos POST no estén presentes
        http_response_code(400); // Bad Request
        echo "Faltan parámetros.";
    }
} else {
    // Manejar el caso en que la solicitud no sea POST
    http_response_code(405); // Method Not Allowed
    echo "Método no permitido.";
=======

if (isset($_POST['user'])) {
    comprobarCredenciales();
>>>>>>> parent of c7114a4 (a)
}


if (isset($_POST['PaginaPrincipal'])) {
    mostrarIncidencias();
}

if (isset($_POST['sesion'])) {
    returnUser();
}

if (isset($_POST["insertar"])) {
    mostrarFormularioIncidencia();
    
}
if (isset($_POST["hecho"])) {
       insertarIncidencia();
    }
if (isset($_POST['cerrarSesion'])) {
    session_destroy();
    header("Location: login.html");
    exit; // Asegura que el script se detenga después de la redirección
}
if (isset($_POST['newPass'])) {
    $newpass = $_POST['newPass'];
    cambiarContraseña($newpass, $_SESSION['usuario']);
}

/*****************************FUNCIONES*********************************************** */
// Definir la función comprobarCredenciales
function comprobarCredenciales()
{
    // Obtener las credenciales del formulario
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $prof = new profesor();

    // Comprobar si la cadena proporcionada contiene un símbolo "@"
    if (strpos($user, '@') !== false) {
        // Si contiene un símbolo "@", verificar si coincide con el correo electrónico en la base de datos
        $bool = $prof->comprobar_correo_contrasena_con_arroba($user,$pass);
    } else {
        // Si no contiene un símbolo "@", buscar coincidencias con la primera parte del correo electrónico
        $bool = $prof->comprobar_correo_contrasena_sin_arroba($user,$pass);

    }
    // error.log($user ." ". $pass);

    if ($bool) {
        // Usuario y contraseña válidos
        if ($user ==  "maite" || $user == "maite@educa.madrid.org") {
            $_SESSION['usuario'] = $user;
            $_SESSION['pass'] = $pass;
            echo "admin";
        } else {
            $_SESSION['usuario'] = $user;
            $_SESSION['pass'] = $pass;
            echo "true";
        }
    } else {
        // Usuario y/o contraseña incorrectos
        echo "false";
    }
}

function mostrarIncidencias()
{
    $out = ""; // Inicializamos la variable fuera del bloque if

    $incidencia = new incidencias();
    $resultado = $incidencia->get_incidencias_por_profesor($_SESSION['usuario']);

    if ($resultado) {

        $incidencia = new incidencias();
        $resultado = $incidencia->get_incidencias_por_profesor($_SESSION['usuario']);
        
        if ($resultado) {
            $out .= "<table>";
            $out .= "<thead><tr><th>ID</th><th>Fecha</th><th>Tipo</th><th>Aula</th><th>Ciclo</th><th>Descripci&oacute;n</th><th>Estado</th></tr></thead>";
            $out .= "<tbody>";
        
            foreach ($resultado as $incidencia) {
                if($incidencia['ciclo'] == null) {
                    $ciclo = "------";
                } else {
                    $ciclo = $incidencia['ciclo'];
                }
        
                $fecha = new DateTime($incidencia["fecha"]);
                $fechaFormateada = $fecha->format('d-m-Y');

                // Determinamos el color de fondo según el estado
                $estado = $incidencia['estado'];
                $colorFondo = '';
                if ($estado == 'Creada') {
                    $colorFondo = 'background-color: #D6EAF8;';
                } elseif ($estado == 'En_proceso') {
                    $colorFondo = 'background-color: #FDEBD0;';
                }

                $out .= "<tr>";
                $out .= "<td data-label='ID'>" . $incidencia['id_incidencia'] . "</td>";
                $out .= "<td data-label='Fecha'>" . $fechaFormateada . "</td>";
                $out .= "<td data-label='Tipo'>" . $incidencia['tipo_incidencia'] . "</td>";
                $out .= "<td data-label='Aula'>" . $incidencia['Nombre_aula'] . "</td>";
                $out .= "<td data-label='Ciclo'>" . $ciclo . "</td>";
                $out .= "<td data-label='Descripci&oacute;n'>" . $incidencia['descripcion'] . "</td>";
                // Añadimos el estilo en línea para la celda del estado
                $out .= "<td data-label='Estado' style='" . $colorFondo . "'>" . $estado . "</td>";
                $out .= "</tr>";
            }
        
            $out .= "</tbody>";
            $out .= "</table>";
        }

    } else {
        $out .= "No se encontraron incidencias.";
    }
    echo $out;
}

function returnUser()
{
    if (isset($_SESSION['usuario'])) {
        $user = $_SESSION['usuario'];
        $profe = new profesor();
        if($profe->get_nombre_profesor($user) != null)
        {
            echo $profe->get_nombre_profesor($user);
        }
        else
        {
            echo "exit";
        }
    } else {
        echo "exit";
    }
}







function insertarIncidencia()
{
     // Obtener datos del formulario
        $aula = $_POST["aula"];
        $fecha = date("Y-m-d");
        $descripcion = $_POST["descripcion"];
        $tipo = $_POST["tipo"];
        $estado = "Creada";

        // Obtener el ID del profesor
        $objeto_profesor = new profesor();
        $id_profesor = $objeto_profesor->get_id_profesor($_SESSION['usuario']);

        // Insertar la incidencia
        $incidencias = new Incidencias();
        
        if (isset($_POST["ciclo"]))
        {
            $ciclo = $_POST["ciclo"];
            $incidencias->insertar_incidencia($fecha, $aula, $descripcion, $tipo, $id_profesor, $ciclo, $estado);
        }
        else
        {
            $incidencias->insertar_incidencia2($fecha, $aula, $descripcion, $tipo, $id_profesor, $estado);
        }
       
        header("Location: index.html");
        exit; // Asegura que el script se detenga después de la redirección
}

function mostrarFormularioIncidencia()
{
    // Inicializar la variable de cadena
    $htmlOutput = "";
    // Obtener información de aulas, ciclos y tipos de incidencia
    $aulas = new aula();
    $array_aula = $aulas->get_aula();

    $cicloObj = new ciclo();
    $array_ciclo = $cicloObj->get_ciclo();

    $tipoIncidencia = new Tipo_Incidencia();
    $array_tipos = $tipoIncidencia->get_Tipo_Incidencia();

    // Agregar el formulario HTML a la cadena

    $htmlOutput .= '<div class="col-md-8 formulariocrearincidencia mx-auto">';
    $htmlOutput .= '<form method="post" action="code.php">';
    

    // Selector para aula
    $htmlOutput .= '<select id="elaula" name="aula" class="form-control myInputFooter required" required onchange="habilitarSegundoSelect()">';
    $htmlOutput .= '<option value="" selected disabled hidden>Selecciona un Aula</option>'; // Placeholder
    foreach ($array_aula as $aula) {
        $htmlOutput .= "<option value='" . $aula['ID_Aula'] . "'>" . $aula['Nombre_aula'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';
    
    // Selector para ciclo
    $htmlOutput .= '<select id="elciclo" name="ciclo" class="form-control myInputFooter required" required disabled>';
    $htmlOutput .= '<option value="" selected disabled hidden>Selecciona un ciclo</option>'; // Placeholder
    foreach ($array_ciclo as $ciclo) {
        $htmlOutput .= "<option value='" . $ciclo['id_ciclo'] . "'>" . $ciclo['ciclo'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';
    
    
    // Selector para tipo de incidencia
    $htmlOutput .= '<select name="tipo" class="form-control myInputFooter required" required>';
    $htmlOutput .= '<option value="" selected disabled hidden>Selecciona una incidencia</option>'; // Placeholder
    foreach ($array_tipos as $tipo) {
        $htmlOutput .= "<option value='" . $tipo['id_tipo_incidencia'] . "'>" . $tipo['tipo_incidencia'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';
    $htmlOutput .= '<textarea id="descripcion" name="descripcion" required class="myInputFooter" placeholder="Descripción" style="width: 100%; height: 15em; resize: none;" maxlength="255"></textarea><br>';
    $htmlOutput .= '<input type="submit" name="hecho" value="CREAR" class="form-control myButton">';
    $htmlOutput .= '</form>';
    $htmlOutput .= '</div>';

 
    // Imprimir la cadena HTML completa
    echo $htmlOutput;
    
    
}

function cambiarcontraseña($pass, $usu)
{
    $Profe = new Profesor();
    echo $Profe->updatecontraseña($pass, $usu);    
}

?>
