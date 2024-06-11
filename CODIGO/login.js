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
<<<<<<< HEAD
    var user = $("#username").val();
    var pass = $("#password").val();
    console.log(user);
    console.log(pass);

    $.ajax({
        type: 'POST',
        url: "code.php",
=======
    var user = $('#username').val();
    var pass = $('#password').val();

    $.ajax({
        type: 'POST',
        url: 'code.php',
>>>>>>> parent of c7114a4 (a)
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
<<<<<<< HEAD
                console.log(response+"hola");
            }
        },
        error: function (xhr, status, error) {
            alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
            console.error('Status: ' + status);
            console.error('Error: ' + error);
        }
=======
                // console.log(user);
                // console.log(pass);
                console.log(response);
            }
        },
>>>>>>> parent of c7114a4 (a)
    });
}
