
$(document).ready(function () {
    $(".login-box").fadeIn(1500, function () {
        $(this).css("display", "block");
    });
    $('#loginForm').submit(function (event) {
        event.preventDefault();
        comprobarCredenciales(); // Llamada a la función para comprobar credenciales
        
    });
});

function comprobarCredenciales() {

    var user = $('#email').val();
    $.ajax({
        type: 'POST',
        url: 'recuperarContraseña.php',
        data: {
            user: user,
        },

        success: function (response) {
            if (response === 'true') 
            {
                alert("Se ha enviado un mensaje al correo con un link para cambiar contraseña");
            } 
            else
            {
                alert("Correo invalido");
            }
             
        },
        error: function () {
            // Si hay un error en la solicitud AJAX, mostrar un mensaje de alerta
            alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
        }
    });
}

