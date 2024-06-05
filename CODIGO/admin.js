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
                $('#section4').html(response);

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

// function toggleForms(index, formType) {
//     var form1 = $('#form1-' + index);
//     var form2 = $('#form2-' + index);
//     var form3 = $('#form3-' + index);

//     if (formType === 'form1') {
//         form1.toggle();
//     } else if (formType === 'form2') {
//         form2.toggle();
//     }

//     if (form1.is(':visible') && form2.is(':visible')) {
//         form3.show();
//         form1.hide();
//         form2.hide();
//     } else {
//         form3.hide();
//     }
// }


function toggleForms(index, formType) {
    const form1 = document.getElementById(`form1-${index}`);
    const form2 = document.getElementById(`form2-${index}`);
    const form3 = document.getElementById(`form3-${index}`);

    if (formType === 'form1') {
        if (form1) form1.classList.toggle('show');
    } else if (formType === 'form2') {
        if (form2) form2.classList.toggle('show');
    }

    // Check visibility and toggle form3 accordingly
    const isForm1Visible = form1 && form1.classList.contains('show');
    const isForm2Visible = form2 && form2.classList.contains('show');

    if (isForm1Visible && isForm2Visible) {
        if (form3) form3.classList.add('show');
        if (form1) form1.classList.remove('show');
        if (form2) form2.classList.remove('show');
    } else {
        if (form3) form3.classList.remove('show');
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

function borrarProfesor() {
    var xhttp = new XMLHttpRequest();
    var borrarProfesor = 0;
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var borrarProfesor = this.response; // Obtener la respuesta del servidor
            var DivProfesor = document.getElementById("borrarProfesor");
            DivProfesor.innerHTML = borrarProfesor;
        }
    };

    xhttp.open("POST", "admin.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("borrarProfesor=" + borrarProfesor);
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
    borrarProfesor();

    
});


document.addEventListener("DOMContentLoaded", function() {
    // Obtener todas las incidencias
    var incidencias = document.querySelectorAll('.panel-body');

    // Inicializar la altura máxima como cero
    var maxHeight = 0;

    // Iterar sobre todas las incidencias para encontrar la más alta
    incidencias.forEach(function(incidencia) {
        // Obtener la altura actual de la incidencia
        var height = incidencia.offsetHeight;
        
        // Actualizar la altura máxima si la altura actual es mayor
        maxHeight = Math.max(maxHeight, height);
    });

    // Establecer la altura máxima a todas las incidencias
    incidencias.forEach(function(incidencia) {
        incidencia.style.height = maxHeight + 'px';
    });
});


