<?php
require "clases/incidencias.php";
    require "clases/aulas.php";
    require "clases/ciclo.php";
    require "clases/profesor.php";
    require "clases/tipo_incidencia.php";

// Inicializamos la base de datos.
$conexion = mysqli_connect("localhost", "root", "", "incidencias_tic");
mysqli_select_db($conexion, "incidencias_tic") or die("No se puede seleccionar la BD");

session_start(); // Inicializamos variables de sesión

if (isset($_POST['user'])) {
    comprobarCredenciales();
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
if (isset($_POST["aula"])) {
       insertarIncidencia();
    }
if (isset($_POST['cerrarSesion'])) {
    session_destroy();
    header("Location: login.html");
    exit; // Asegura que el script se detenga después de la redirección
}

/*****************************FUNCIONES*********************************************** */
// Definir la función comprobarCredenciales
function comprobarCredenciales()
{
    // Importar la variable de conexión global
    global $conexion;

    // Obtener las credenciales del formulario
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $_SESSION['usuario'] = $user;
    $_SESSION['pass'] = $pass;

    // Comprobar si la cadena proporcionada contiene un símbolo "@"
    if (strpos($user, '@') !== false) {
        // Si contiene un símbolo "@", verificar si coincide con el correo electrónico en la base de datos
        $consulta = "SELECT * FROM profesor WHERE correo = '$user' AND clave_acceso = '$pass'";
    } else {
        // Si no contiene un símbolo "@", buscar coincidencias con la primera parte del correo electrónico
        $consulta = "SELECT * FROM profesor WHERE correo LIKE '%$user%' AND clave_acceso = '$pass'";
    }

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si se encontró algún registro que coincida
    if (mysqli_num_rows($resultado) > 0) {
        // Usuario y contraseña válidos
        echo "true";
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
        $out .= "<table>";
        $out .= "<tr><th>ID</th><th>Descripción</th><th>Tipo</th><th>Fecha</th><th>Aula</th><th>Ciclo</th><th>Estado</th></tr>";

        foreach ($resultado as $incidencia) {
            $out .= "<tr>";
            $out .= "<td>" . $incidencia['id_incidencia'] . "</td>";
            $out .= "<td>" . $incidencia['descripcion'] . "</td>";
            $out .= "<td>" . $incidencia['tipo_incidencia'] . "</td>";
            $out .= "<td>" . $incidencia['fecha'] . "</td>";
            $out .= "<td>" . $incidencia['Nombre_aula'] . "</td>";
            $out .= "<td>" . $incidencia['ciclo'] . "</td>";
            $out .= "<td>" . $incidencia['estado'] . "</td>";
            $out .= "</tr>";
        }
        $out .= "</table>";
    } else {
        // Si no hay resultados, podrías mostrar un mensaje indicando que no hay incidencias
        $out .= "No se encontraron incidencias.";
    }
    echo $out;
}

function returnUser()
{
    // Importar la variable de conexión global
    global $conexion;

    // Verificar si existe una sesión de usuario
    if (isset($_SESSION['usuario'])) {
        // Obtener el valor de la variable de sesión
        $user = $_SESSION['usuario'];

        // Consultar la base de datos para obtener el nombre asociado al correo electrónico
        $consulta = "SELECT nombre FROM profesor WHERE correo = '$user' OR correo LIKE '%$user%'";

        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $consulta);

        // Verificar si se encontró algún registro que coincida
        if (mysqli_num_rows($resultado) > 0) {
            // Obtener el nombre del primer registro encontrado
            $row = mysqli_fetch_assoc($resultado);
            $nombre = $row['nombre'];
            
            // Devolver el nombre obtenido
            echo $nombre;
        } else {
            // Si no se encontró ningún registro, devolver "exit"
            echo "exit";
        }
    } else {
        // Si no existe una sesión de usuario, devolver "exit"
        echo "exit";
    }
}



function insertarIncidencia()
{
     // Obtener datos del formulario
        $fecha = date("Y-m-d");
        $aula = $_POST["aula"];
        $descripcion = $_POST["descripcion"];
        $tipo = $_POST["tipo"];
        $ciclo = $_POST["ciclo"];
        $estado = "Creada";

        // Obtener el ID del profesor
        $objeto_profesor = new profesor();
        $id_profesor = $objeto_profesor->get_id_profesor($_SESSION['usuario']);

        // Insertar la incidencia
        $incidencias = new Incidencias();
        $incidencias->insertar_incidencia($fecha, $aula, $descripcion, $tipo, $id_profesor, $ciclo, $estado);
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

    $htmlOutput .= '<div class="col-md-8" style="margin: 5em;">';

    $htmlOutput .= '<form method="post" action="code.php">';
    
    // Selector para ciclo
    $htmlOutput .= '<select name="ciclo" class="form-control myInputFooter required" required>';
    $htmlOutput .= '<option value="" selected disabled hidden>Selecciona un ciclo</option>'; // Placeholder
    foreach ($array_ciclo as $ciclo) {
        $htmlOutput .= "<option value='" . $ciclo['id_ciclo'] . "'>" . $ciclo['ciclo'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';
    
    // Selector para aula
    $htmlOutput .= '<select name="aula" class="form-control myInputFooter required" required>';
    $htmlOutput .= '<option value="" selected disabled hidden>Selecciona un Aula</option>'; // Placeholder
    foreach ($array_aula as $aula) {
        $htmlOutput .= "<option value='" . $aula['ID_Aula'] . "'>" . $aula['Nombre_aula'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';
    
    // Selector para tipo de incidencia
    $htmlOutput .= '<select name="tipo" class="form-control myInputFooter required" required>';
    $htmlOutput .= '<option value="" selected disabled hidden>Selecciona una incidencia</option>'; // Placeholder
    foreach ($array_tipos as $tipo) {
        $htmlOutput .= "<option value='" . $tipo['id_tipo_incidencia'] . "'>" . $tipo['tipo_incidencia'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';
    
    $htmlOutput .= '<textarea id="descripcion" name="descripcion" required class="myInputFooter" placeholder="   Descripción"  style="width: 100%; height: 15em; resize: none;"></textarea><br>';
    $htmlOutput .= '<input type="submit" name="hecho" value="CREAR" class="form-control myButton">';
    $htmlOutput .= '</form>';
    $htmlOutput .= '</div>';
    
    // Imprimir la cadena HTML completa
    echo $htmlOutput;
    
    
}

?>
