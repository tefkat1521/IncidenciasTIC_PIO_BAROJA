
$(document).ready(function () {
    $(".login-box").fadeIn(1500, function () {
        $(this).css("display", "block");
    });
    $('#loginForm').submit(function (event) {
        event.preventDefault();
        ComprobarCredenciales(); // Llamada a la función para comprobar credenciales
        
    });
});

function ComprobarCredenciales() {
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
            if (response === 'true') {
                // Si las credenciales son correctas, redirige a la página index.html
                window.location.href = 'index.html';
            } else {
                // Si las credenciales son incorrectas, mostrar un mensaje de alerta
                alert('Usuario incorrecto mamon');
            }
        }
    });
}
