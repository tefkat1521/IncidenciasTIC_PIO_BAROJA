<?php
    $conexion = mysqli_connect("localhost","root","","incidencias_tic");
    mysqli_select_db($conexion,"incidencias_tic") or die ("No se puede seleccionar la BD");

if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

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
?>
