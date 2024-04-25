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

    // Consulta SQL para verificar si el usuario y la contraseña existen en la tabla "profesor"
    $consulta = "SELECT * FROM profesor WHERE nombre = '$user' AND clave_acceso = '$pass'";

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
    if (isset($_SESSION['usuario'])) {
        echo $_SESSION['usuario'];
    } else {
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
        $estado = "Pendiente";

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
    $htmlOutput .= '<form method="post" action="code.php">';
    $htmlOutput .= '<label>Ciclo</label><br>';
    $htmlOutput .= '<select name="ciclo" required>';
    foreach ($array_ciclo as $ciclo) {
        $htmlOutput .= "<option value='" . $ciclo['id_ciclo'] . "'>" . $ciclo['ciclo'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';

    $htmlOutput .= '<label>Aula</label><br>';
    $htmlOutput .= '<select name="aula" required>';
    foreach ($array_aula as $aula) {
        $htmlOutput .= "<option value='" . $aula['ID_Aula'] . "'>" . $aula['Nombre_aula'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';

    $htmlOutput .= '<label>Tipo de Incidencia</label><br>';
    $htmlOutput .= '<select name="tipo" required>';
    foreach ($array_tipos as $tipo) {
        $htmlOutput .= "<option value='" . $tipo['id_tipo_incidencia'] . "'>" . $tipo['tipo_incidencia'] . "</option>";
    }
    $htmlOutput .= '</select><br><br>';

    $htmlOutput .= '<label for="descripcion">Descripción:</label><br>';
    $htmlOutput .= '<textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br>';
    $htmlOutput .= '<input type="submit" name="hecho" value="CREAR">';
    $htmlOutput .= '</form>';

    // Imprimir la cadena HTML completa
    echo $htmlOutput;
}

// session_destroy();
?>
