$(document).ready(function () {
    $(".login-box").fadeIn(1500);

    $('#loginForm').submit(function (event) {
        event.preventDefault();
        comprobarCredenciales(); // Llamada a la función para comprobar credenciales
    });
});

function comprobarCredenciales() {
    var user = $("#username").val();
    var pass = $("#password").val();
    console.log(user);
    console.log(pass);

    $.ajax({
        type: 'POST',
        url: "code.php",
        data: {
            user: user,
            pass: pass
        },
        success: function (response) {
            if (response === 'admin') {
                window.location.href = 'admin.html';
            } else if (response === 'true') {
                window.location.href = 'index.html';
            } else {
                alert('Usuario y/o contraseña incorrectos');
                console.log(response);
            }
        },
        error: function () {
            // Si hay un error en la solicitud AJAX, mostrar un mensaje de alerta
            alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
        }
    });
}
