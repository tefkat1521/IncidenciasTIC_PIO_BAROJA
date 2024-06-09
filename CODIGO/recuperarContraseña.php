<?php
require "clases/profesor.php";
require "clases/incidencias.php";

if (isset($_POST['email'])) {
    comprobarCredenciales();
}

function comprobarCredenciales()
{
    // Obtener las credenciales del formulario
    $user = $_POST['email'];
    
    $prof = new profesor();
    $incidencia = new Incidencias();

    $response = $prof->comprobar_correo_o_usuario_existe($user);
    if ($response == 'true') {
        $incidencia->enviarCorreoContraseña($user);
        echo 'true';
    } else {
        echo 'false';
    }
}
?>
