<?php
require "clases/profesor.php";

if (isset($_POST['email'])) {
    comprobarCredenciales();
}

function comprobarCredenciales()
{
    // Obtener las credenciales del formulario
    $user = $_POST['email'];
    
    $prof = new profesor();

    if ($prof->comprobar_correo_contrasena_con_arroba($user, "asdfsdf")) {
        $prof->enviarCorreo($user);
        echo "true";
    } else {
        echo "false";
    }
}
?>
