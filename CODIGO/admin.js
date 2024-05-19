function consultarIncidencias() {
    var PaginaAdmin = 0;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var TablaIncidencias = this.response; // Obtener la respuesta del servidor
            var DivIncidencias = document.getElementById("incidenciasAdmin");

            DivIncidencias.innerHTML = TablaIncidencias;
        }
    };

    xhttp.open("POST", "admin.php", true); // true indica una solicitud asíncrona
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("PaginaAdmin=" + PaginaAdmin);
}

function editar_incidencia() {
    let boton = document.getElementById("form");
    boton.style.display = "block";
}

function SesionUser() {
    var sesion = "";

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var logueado = this.responseText; // Obtener la respuesta del servidor
            if (logueado != "exit") {
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



