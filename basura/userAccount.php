<?php

session_start();

// Incluye el archivo de la clase User (asegúrate de que la ruta es correcta)
include_once 'user.php';

// Instancia la clase User
// $user = new User();
// Supongamos que tienes un archivo separado para la configuración de la base de datos
// include_once 'dbConfig.php';

// Crear una instancia de la clase User pasando la conexión a la base de datos
$user = new User($db);






if(isset($_POST['forgotSubmit'])){
    //check whether email is empty
    if(!empty($_POST['email'])){


        //check whether user exists in the database
        $prevCon['where'] = array('email'=>$_POST['email']); //se busca un registro en la base de datos donde el campo 'email' sea igual al valor proporcionado a través del formulario HTML
        $prevCon['return_type'] = 'count'; // se quiere obtener el número de filas que cumplen con la condición especificada
        $prevUser = $user->getRows($prevCon); //Se realiza la consulta a la base de datos utilizando el método getRows() del objeto $user, pasando como parámetro el arreglo $prevCon que contiene la condición de búsqueda y el tipo de retorno deseado.
        
        
        
        if($prevUser > 0){
            // Se ejecuta si se encuentra al menos un usuario con el correo electrónico proporcionado
            
            // Genera una cadena única utilizando la función md5() combinada con uniqid() y mt_rand()
            $uniqidStr = md5(uniqid(mt_rand()));
            
            // Prepara los datos para la actualización del registro en la base de datos
            $conditions = array('email' => $_POST['email']);
            $data = array('pswrd_olvid' => $uniqidStr);
            
            // Actualiza el registro en la base de datos con el nuevo código de restablecimiento de contraseña
            // Utiliza el método update() del objeto $user, pasando los datos y las condiciones
            $update = $user->update($data, $conditions);
        
        
            
            if($update){
                // Se ejecuta si la actualización del registro del usuario fue exitosa
                
                // Construye el enlace para restablecer la contraseña
                $resetPassLink = 'http://ejemplo.com/recuperarContraseña3.php?fp_code='.$uniqidStr;
                
                // Obtiene los detalles del usuario actualizado
                $con['where'] = array('email'=>$_POST['email']);
                $con['return_type'] = 'single';
                $userDetails = $user->getRows($con);
                
                // Prepara el contenido del correo electrónico para restablecer la contraseña
                $to = $userDetails['email'];
                $subject = "Password Update Request";
                $mailContent = 'Estimado '.$userDetails['first_name'].', 
                <br/>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
                <br/>To reset your password, visit the following link: <a href="'.$resetPassLink.'">'.$resetPassLink.'</a>
                <br/><br/>Regards';
                
                // Establece los encabezados del correo electrónico
                $headers = "MIME-Version: 1.0" . "rn";
                $headers .= "Content-type:text/html;charset=UTF-8" . "rn";
                // Encabezados adicionales
                $headers .= 'From: Tu<[email protected]>' . "rn";
                
                // Envía el correo electrónico
                mail($to, $subject, $mailContent, $headers);
                
                // Establece el mensaje de estado de éxito para mostrar al usuario
                $sessData['status']['type'] = 'success';
                $sessData['status']['msg'] = 'Please check your e-mail, we have sent a password reset link to your registered email.';
            
            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.';
            }
        }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Given email is not associated with any account.'; 
        }
        
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Enter email to create a new password for your account.'; 
    }
    //store reset password status into the session
    $_SESSION['sessData'] = $sessData;
    //redirect to the forgot pasword page
    header("Location:recuperarContraseña2.php");
// Si se envió el formulario de restablecimiento de contraseña
}elseif(isset($_POST['resetSubmit'])){
    // Inicializa la variable para almacenar el código de restablecimiento de contraseña
    $fp_code = '';

    // Verifica si se proporcionaron todas las credenciales necesarias
    if(!empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['fp_code'])){
        // Asigna el código de restablecimiento proporcionado en el formulario a la variable $fp_code
        $fp_code = $_POST['fp_code'];

        // Comparación de la contraseña y la confirmación de la contraseña
        if($_POST['password'] !== $_POST['confirm_password']){
            // Si las contraseñas no coinciden, establece un mensaje de error en la sesión
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Confirm password must match with the password.'; 
        }else{
            // Verifica si el código de identidad existe en la base de datos
            $prevCon['where'] = array('pswrd_olvid' => $fp_code);
            $prevCon['return_type'] = 'single';
            $prevUser = $user->getRows($prevCon);

            if(!empty($prevUser)){
                // Si el código de identidad existe, actualiza la contraseña del usuario en la base de datos
                $conditions = array(
                    'pswrd_olvid' => $fp_code
                );
                $data = array(
                    'password' => md5($_POST['password'])
                );
                $update = $user->update($data, $conditions);

                if($update){
                    // Si la actualización de la contraseña fue exitosa, establece un mensaje de éxito en la sesión
                    $sessData['status']['type'] = 'success';
                    $sessData['status']['msg'] = 'Your account password has been reset successfully. Please login with your new password.';
                }else{
                    // Si ocurrió un problema durante la actualización, establece un mensaje de error en la sesión
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                }
            }else{
                // Si el código de identidad no existe en la base de datos, establece un mensaje de error en la sesión
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'You does not authorized to reset new password of this account.';
            }
        }
    }else{
        // Si no se proporcionaron todas las credenciales necesarias, establece un mensaje de error en la sesión
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.'; 
    }

    // Almacena el estado del restablecimiento de contraseña en la sesión
    $_SESSION['sessData'] = $sessData;

    // Determina la URL de redirección según el resultado del restablecimiento de contraseña
    $redirectURL = ($sessData['status']['type'] == 'success') ? 'index.php' : 'recuperarContraseña3.php?fp_code='.$fp_code;

    // Redirecciona a la URL determinada
    header("Location:".$redirectURL);
}