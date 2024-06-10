const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])([^\s]){3,}$/;

function validatePasswords() {
    const password = $('#password').val();
    const confirmPassword = $('#confirmPassword').val();

    // Validar la contraseña
    if (!passwordPattern.test(password)) {
        alert('La nueva contraseña no cumple los requisitos establecidos');
        return false;
    }

    // Verificar que ambas contraseñas coincidan
    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden.');
        return false;
    }

    return true;
}

$(document).ready(function () {
    $(".login-box").fadeIn(1500, function () {
        $(this).css("display", "block");
    });

    $('#pswdButton').on('click', function () {
        if (validatePasswords()) {
            var password1 = $('#password').val();
            var password2 = $('#confirmPassword').val();

            if (password1 !== password2) {
                // Mostrar mensaje en el div #mens y hacerlo visible
                $('#mens').text("Las contraseñas no coinciden. Por favor, inténtelo de nuevo.");
                $('#mens').css('visibility', 'visible');

                // Limpiar los campos de contraseña
                $('#password').val('');
                $('#confirmPassword').val('');

                // Ocultar el mensaje después de 8 segundos
                setTimeout(function () {
                    $('#mens').css('visibility', 'hidden');
                }, 8000);

                return false; // Detener el envío del formulario

            } else if (password1 == "" || password2 == "") {
                $('#mens').text("Hay campos sin rellenar.");
                $('#mens').css('visibility', 'visible');

                // Ocultar el mensaje después de 8 segundos
                setTimeout(function () {
                    $('#mens').css('visibility', 'hidden');
                }, 8000);
            }
            else {
                // Desactivar el botón de Aceptar para evitar clics adicionales
                $('#pswdButton').prop('disabled', true);

                // Crear los elementos de botón
                var btnAceptar = $('<button>').attr('id', 'mensAceptar').text('Aceptar');
                var btnCancelar = $('<button>').attr('id', 'mensCancelar').text('Cancelar');

                // Agregar los botones al contenedor de botones
                $('#botones').append(btnAceptar);
                $('#botones').append(btnCancelar);

                // Agregar texto al contenedor de texto
                $('#texto').text("¿Seguro que desea cambiar la contraseña?");

                // Hacer visible el contenedor #aaa
                $('#aaa').css('visibility', 'visible');

                // Agregar event listener para el botón Aceptar
                btnAceptar.on('click', function () {
                    // Lógica para el botón Aceptar
                    console.log('Se ha pulsado el botón Aceptar');
                    // Llama a la función correspondiente
                    funcionAceptar();
                });

                // Agregar event listener para el botón Cancelar
                btnCancelar.on('click', function () {
                    // Lógica para el botón Cancelar
                    console.log('Se ha pulsado el botón Cancelar');
                    // Llama a la función correspondiente
                    funcionCancelar();
                });

                // Definir funciones correspondientes a cada botón
                function funcionAceptar() {
                    // Cambiar la contraseña (aquí debes implementar la función cambiarcontraseña)
                    cambiarcontraseña(password1);

                    // Mostrar mensaje de contraseña cambiada correctamente
                    $('#aaa').css('visibility', 'hidden');
                    $('#mens').text("Contraseña cambiada correctamente");
                    $('#mens').css('visibility', 'visible');

                    // Ocultar el mensaje después de 8 segundos
                    setTimeout(function () {
                        // Redirigir al usuario a la página de inicio
                        window.location.href = "index.html";
                    }, 2000);
                }

                function funcionCancelar() {
                    // Si el usuario cancela, no hacer nada
                    $('#mens').css('visibility', 'hidden');
                    $('#aaa').css('visibility', 'hidden');
                    // Redirigir al usuario a la página de inicio
                    window.location.href = "index.html";
                    return false;
                }
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
                    console.log('su contraseña ha sido cambiada');
                } else {
                    alert('error al cambiar la contraseña');
                }
            },
            error: function () {
                // Si hay un error en la solicitud AJAX, mostrar un mensaje de alerta
                alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
            }
        });
    }

    $('#toggle-pencil').click(function () {
        var form1 = $('#form1');
        if (form1.css('visibility') === 'hidden') {
            form1.css('visibility', 'visible');
        } else {
            form1.css('visibility', 'hidden');
        }
    });

    $('#toggle-sort').click(function () {
        var form2 = $('#form2');
        if (form2.css('visibility') === 'hidden') {
            form2.css('visibility', 'visible');
        } else {
            form2.css('visibility', 'hidden');
        }
    });
});
