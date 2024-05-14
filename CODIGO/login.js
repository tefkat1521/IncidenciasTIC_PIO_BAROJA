
$(document).ready(function () {
    $(".login-box").fadeIn(1500, function () {
        $(this).css("display", "block");
    });
    $('#loginForm').submit(function (event) {
        event.preventDefault();
        ComprobarCredenciales(); // Llamada a la función para comprobar credenciales
        
    });
});

function comprobarCredenciales() {
    var user = $('#username').val();
    var pass = $('#password').val();

    $.ajax({
        type: 'POST',
        url: 'code.php',
        data: {
            user: user,
            pass: pass
        },
        success: function (response) {
            if (response === 'admin') {
                // Si las credenciales son para el administrador, redirige a admin.html
                window.location.href = 'admin.html';
            } else if (response === 'true') {
                // Si las credenciales son correctas, redirige a index.html
                window.location.href = 'index.html';
            } else {
                // Si las credenciales son incorrectas, mostrar un mensaje de alerta
                alert('Usuario y/o contraseña incorrectos');
            }
        },
        error: function () {
            // Si hay un error en la solicitud AJAX, mostrar un mensaje de alerta
            alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
        }
    });
}

