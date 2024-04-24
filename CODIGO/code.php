<?php
require "clases/incidencias.php";

//Inicializamos la base de datos.
$conexion = mysqli_connect("localhost", "root", "", "incidencias_tic");
mysqli_select_db($conexion, "incidencias_tic") or die("No se puede seleccionar la BD");

session_start();//Inicializamos variables de sesión
// session_set_cookie_params(3600);

// Verificar si se envió el formulario
if (isset($_POST['user'])) {
    comprobarCredenciales();
}

if (isset($_POST['PaginaPrincipal'])) {
    mostrarIncidencias();
}


if (isset($_POST['sesion'])) {
    returnUser();
}

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
        $out .= "<tr><th>ID</th><th>Descripción</th><th>Tipo</th><th>Fecha</th><th>Aula</th><th>Estado</th></tr>";

        foreach ($resultado as $incidencia) {
            $out .= "<tr>";
            $out .= "<td>" . $incidencia['id_incidencia'] . "</td>";
            $out .= "<td>" . $incidencia['descripcion'] . "</td>";
            $out .= "<td>" . $incidencia['tipo_incidencia'] . "</td>";
            $out .= "<td>" . $incidencia['fecha'] . "</td>";
            $out .= "<td>" . $incidencia['Nombre_aula'] . "</td>";
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


function returnUser(){
    if (isset($_SESSION['usuario'])) {
        echo $_SESSION['usuario'];
    }else {
        echo "exit";
    }
}
// session_destroy();
?>
