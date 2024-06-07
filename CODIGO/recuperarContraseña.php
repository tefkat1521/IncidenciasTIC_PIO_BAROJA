
<?php
    require "clases/profesor.php";

    if (isset($_POST['user'])) {
        comprobarCredenciales();
    }

    function comprobarCredenciales()
    {
        
        // Obtener las credenciales del formulario
        $user = $_POST['user'];
    
        $prof = new profesor();

        
        if ($prof->comprobar_correo_contrasena_con_arroba($user,$pass)) 
        {
            echo "true";
            $prof->enviarCorreo($user);
        } 
        else 
        {
            echo "false";
        }

    }
?>