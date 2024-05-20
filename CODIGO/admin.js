function consultarIncidencias() {
    var PaginaAdmin = 0;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var TablaIncidencias = this.response; // Obtener la respuesta del servidor
            var DivIncidencias = document.getElementById("incidenciasAdmin");

            DivIncidencias.innerHTML = TablaIncidencias;

            // Añadir manejadores de eventos después de que el contenido se haya cargado
            $(document).ready(function() {
                $('[id^=toggle-pencil]').click(function() {
                    var index = this.id.split('-')[2];
                    var form1 = $('#form1-' + index);
                    form1.css('visibility', form1.css('visibility') === 'hidden' ? 'visible' : 'hidden');
                });

                $('[id^=toggle-sort]').click(function() {
                    var index = this.id.split('-')[2];
                    var form2 = $('#form2-' + index);
                    form2.css('visibility', form2.css('visibility') === 'hidden' ? 'visible' : 'hidden');
                });
            });
        }
    };

    xhttp.open("POST", "admin.php", true); // true indica una solicitud asíncrona
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("PaginaAdmin=" + PaginaAdmin);
}
function insertarProfesor() {
    // var nombre = document.getElementById("nombre").value;
    // var correo = document.getElementById("correo").value;
    // var pass = document.getElementById("pass").value;
    // var dept = document.getElementById("dept").value;

    var xhttp = new XMLHttpRequest();
    var newProfesor = 0;
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            
            // Aquí puedes hacer algo con la respuesta del servidor, si es necesario
            var insertarProfesor = this.response; // Obtener la respuesta del servidor
            var DivProfesor = document.getElementById("insertarProfesor");

            DivProfesor.innerHTML = insertarProfesor;
        }
    };

    xhttp.open("POST", "admin.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("newProfesor=" + newProfesor);

    // xhttp.send("nombre=" + nombre + "&correo=" + correo + "&pass=" + pass + "&dept=" + dept + "&newProfesor=1");
}

function SesionUser() {
    var sesion = "";

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var logueado = this.responseText; // Obtener la respuesta del servidor
            if (logueado != "exit") {
                // Usuario logueado
            } else {
                noLogueado();
            }
        }
    };

    xhttp.open("POST", "code.php", true); // true indica una solicitud asíncrona
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("sesion=" + sesion);
}

function noLogueado() {
    window.location.href = "login.html";
}


function initializeButtons() {
    $('.ajax-button').on('click', function () {
        // Eliminar la clase 'active' de todos los botones
        $('.ajax-button').removeClass('active');

        // Añadir la clase 'active' al botón pulsado
        $(this).addClass('active');

        // Obtener el valor del botón pulsado
        var value = $(this).data('value');
        console.log(value);

        // Realizar la solicitud AJAX
        $.ajax({
            url: 'admin.php',
            type: 'GET',
            data: { value: value },
            success: function (response) {
                // Actualizar el contenido de la división de resultados
                $('#result').text(response);

            }
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();
    SesionUser();
    insertarProfesor();
    initializeButtons();
});
