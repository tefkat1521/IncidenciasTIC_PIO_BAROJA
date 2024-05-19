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

document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();
    SesionUser();
});
