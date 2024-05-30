<?php
//Inicializamos la base de datos.
$conexion = mysqli_connect("localhost", "root", "", "incidencias_tic");
mysqli_select_db($conexion, "incidencias_tic") or die("No se puede seleccionar la BD");

session_start();//Inicializamos variables de sesión

// Verificar si se envió el formulario
if (isset($_POST['PaginaPrincipal'])) {
    mostrarIncidencias();
}

if (isset($_POST['user'])) {
    comprobarCredenciales();
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

//Hacer una función que cuándo se llame desde principal se mande la lista de incidencias de ese profesor

function mostrarIncidencias()
{
    global $conexion;
    // $consulta = "SELECT * FROM incidencias WHERE ID_profe = (SELECT ID_profe FROM profesor WHERE nombre = '{$_SESSION["usuario"]}')";
    $consulta = "SELECT i.id_incidencia, i.fecha, a.Nombre_aula, i.descripcion, i.estado, t.tipo_incidencia, p.ID_Profe
    FROM Incidencias i, Aula a , Tipo_Incidencia t, Profesor p
    WHERE a.ID_Aula = i.ID_Aula AND t.id_tipo_incidencia = i.id_tipo_incidencia AND p.ID_Profe = i.ID_Profe AND  p.ID_Profe = (SELECT ID_profe FROM profesor WHERE nombre = '{$_SESSION["usuario"]}')
    ORDER BY i.niveldeprioridad DESC;";

    $resultado = mysqli_query($conexion, $consulta);
    
    if ($resultado) {
        $incidencias_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        // Liberar el resultado
        mysqli_free_result($resultado);

        $out = "<table>";
        $out .= "<tr><th>ID</th><th>Profesor</th><th>Descripción</th><th>Tipo</th><th>Fecha</th><th>Aula</th><th>Estado</th></tr>";

        foreach ($incidencias_array as $incidencia) {
            $out .= "<tr>";
            $out .= "<td>" . $incidencia['id_incidencia'] . "</td>";
            $out .= "<td>" . $_SESSION["usuario"] . "</td>";
            $out .= "<td>" . $incidencia['descripcion'] . "</td>";
            $out .= "<td>" . $incidencia['tipo_incidencia'] . "</td>";
            $out .= "<td>" . $incidencia['fecha'] . "</td>";
            $out .= "<td>" . $incidencia['Nombre_aula'] . "</td>";
            $out .= "<td>" . $incidencia['estado'] . "</td>";
            $out .= "</tr>";
        }
        $out .= "</table>";
    }
    echo $out;
}

?>
