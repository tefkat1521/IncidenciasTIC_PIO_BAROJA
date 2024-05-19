$(document).ready(function() {
    $(".login-box").fadeIn(1500, function () {
        $(this).css("display", "block");
    });

    $('#loginForm').submit(function (event) {
        
        event.preventDefault();
        comprobarCredenciales(); // Llamada a la función para comprobar credenciales
    });

    $('#pswdButton').click(function(e) {
        //e.preventDefault(); // Evita que el formulario se envíe automáticamente
        
        var password1 = $('#password').val(); // Obtener el valor del primer campo de contraseña
        var password2 = $('#confirmPassword').val(); // Obtener el valor del segundo campo de contraseña
    
        if (password1 !== password2) {
            alert("Las contraseñas no coinciden. Por favor, inténtelo de nuevo.");
            // Limpiar los campos de contraseña
            $('#password').val('');
            $('#confirmPassword').val('');
            return false; // Detener el envío del formulario
        } else if(password1 == "" || password2 == "")
            {
                alert("Hay campos sin rellenar");
            }
        else {
            // Mostrar el popup de confirmación
            var confirmacion = confirm("¿Seguro que desea cambiar la contraseña?");
            if (confirmacion) {
                // Mostrar mensaje de contraseña cambiada correctamente
                cambiarcontraseña(password1);
                //alert("Contraseña cambiada correctamente");
                // Redirigir a la página index.html después de 2 segundos
                // setTimeout(function() {
                    // window.location.href = "index.html";
                // }, 1000);
            } else {
                // Si el usuario cancela, no hacer nada
                return false;
            }
        }
    });
    function cambiarcontraseña(newPass, idprofe) {  //AQUÍ LA FUNCIÓN QUE CAMBIARÁ LA CONTRASEÑA DESDE EL PHP EN LA BASE DE DATOS
        $.ajax({
            type: 'POST',
            url: 'code.php',
            data: {
                newPass: newPass,
                idprofe: idprofe
            },
            success: function (response) {
                if (response === '1') {
                    alert('contraseña cambaida correctamente');
                } else {
                    alert('error mal');
                }
            },
            error: function () {
                // Si hay un error en la solicitud AJAX, mostrar un mensaje de alerta
                alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
            }
        });
    }
    
});


$(document).ready(function() {
    $('#toggle-pencil').click(function() {
        var form1 = $('#form1');
        if (form1.css('visibility') === 'hidden') {
            form1.css('visibility', 'visible');
        } else {
            form1.css('visibility', 'hidden');
        }
    });

    $('#toggle-sort').click(function() {
        var form2 = $('#form2');
        if (form2.css('visibility') === 'hidden') {
            form2.css('visibility', 'visible');
        } else {
            form2.css('visibility', 'hidden');
        }
    });
});

