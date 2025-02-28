function consultarIncidencias() {
    var value = 0; // Inicializar value a 0

    function realizarSolicitud() {
        // Realizar la solicitud AJAX
        $.ajax({
            url: 'admin.php',
            type: 'POST',
            data: { value: value },
            success: function (response) {
                // Actualizar el contenido del div con la respuesta
                $('#section3').html(response);
                console.log(response); // Imprimir la respuesta en la consola



                // Añadir manejadores de eventos después de que el contenido se haya cargado
                $('[id^=toggle-pencil]').click(function () {
                    var index = this.id.split('-')[2];
                    toggleForms(index, 'form1');
                });

                $('[id^=toggle-sort]').click(function () {
                    var index = this.id.split('-')[2];
                    toggleForms(index, 'form2');
                });
            },
            error: function() {
                alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
            }
        });
    }

    // Llamar a realizarSolicitud al cargar la página para enviar el valor inicial 0
    realizarSolicitud();

    $('.filtro_incidencia').on('click', function () {
        // Eliminar la clase 'active' de todos los botones
        $('.filtro_incidencia').removeClass('active');

        // Añadir la clase 'active' al botón pulsado
        $(this).addClass('active');

        // Obtener el valor del botón pulsado
        value = $(this).data('value');
        console.log(value);

        // Realizar la solicitud AJAX
        realizarSolicitud();
    });
}

function toggleForms(index, formType) {
    var form1 = $('#form1-' + index);
    var form2 = $('#form2-' + index);
    var form3 = $('#form3-' + index);

    if (formType === 'form1') {
        form1.toggle();
    } else if (formType === 'form2') {
        form2.toggle();
    }

    if (form1.is(':visible') && form2.is(':visible')) {
        form3.show();
        form1.hide();
        form2.hide();
    } else {
        form3.hide();
    }
}

function insertarProfesor() {
    var xhttp = new XMLHttpRequest();
    var newProfesor = 0;
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var insertarProfesor = this.response; // Obtener la respuesta del servidor
            var DivProfesor = document.getElementById("insertarProfesor");
            DivProfesor.innerHTML = insertarProfesor;
        }
    };

    xhttp.open("POST", "admin.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("newProfesor=" + newProfesor);
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

function editarIncidencia(numIncidencia) {
    $.ajax({
        type: 'POST',
        url: 'admin.php',
        data: {
            numIncidencia: numIncidencia,
        },
        success: function (response) {
            console.log(response);
        },
        error: function () {
            alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();
    SesionUser();
    insertarProfesor();
});






// NO SE USA - NO FUNCIONA
document.addEventListener("DOMContentLoaded", function () {
    var incidenciasAdmin = document.getElementById('incidenciasAdmin');
    var primerDivHijo = incidenciasAdmin.querySelector('div');

    const incidencias = document.querySelectorAll("#incidencias > div");
    const grande = document.getElementById("grande");

    incidencias.forEach((incidencia) => {
        incidencia.addEventListener("click", function () {
            // Obtener el contenido de la incidencia clicada
            const contenido = this.innerHTML;
            console.log(contenido);

            // Llenar el div #grande con el contenido de la incidencia clicada
            grande.innerHTML = contenido;
            // Mostrar el div #grande
            grande.style.display = "block";
        });
    });
});