// function consultarIncidencias() {
//     var PaginaAdmin = 0;

//     var xhttp = new XMLHttpRequest();

//     xhttp.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             var TablaIncidencias = this.response; // Obtener la respuesta del servidor
//             var DivIncidencias = document.getElementById("incidenciasAdmin");

//             DivIncidencias.innerHTML = TablaIncidencias;

//             // Añadir manejadores de eventos después de que el contenido se haya cargado
//             $(document).ready(function() {
//                 $('[id^=toggle-pencil]').click(function() {
//                     var index = this.id.split('-')[2];
//                     var form1 = $('#form1-' + index);
//                     form1.css('visibility', form1.css('visibility') === 'hidden' ? 'visible' : 'hidden');
//                 });

//                 $('[id^=toggle-sort]').click(function() {
//                     var index = this.id.split('-')[2];
//                     var form2 = $('#form2-' + index);
//                     form2.css('visibility', form2.css('visibility') === 'hidden' ? 'visible' : 'hidden');
//                 });
//             });
//         }
//     };

//     xhttp.open("POST", "admin.php", true); // true indica una solicitud asíncrona
//     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhttp.send("PaginaAdmin=" + PaginaAdmin);
// }


// function consultarIncidencias() {
//     var value = 0; // Inicializar value a 0

//     $('.filtro_incidencia').on('click', function () {
//         // Eliminar la clase 'active' de todos los botones
//         $('.filtro_incidencia').removeClass('active');

//         // Añadir la clase 'active' al botón pulsado
//         $(this).addClass('active');

//         // Obtener el valor del botón pulsado
//         value = $(this).data('value');
//         console.log(value);

//         // Realizar la solicitud AJAX
//         $.ajax({
//             url: 'admin.php',
//             type: 'POST',
//             data: { value: value },
//             success: function (response) {
//                 // Actualizar el contenido del div con la respuesta
//                 $('#result').html(response);

//                 // Añadir manejadores de eventos después de que el contenido se haya cargado
//                 $('[id^=toggle-pencil]').click(function () {
//                     var index = this.id.split('-')[2];
//                     var form1 = $('#form1-' + index);
//                     form1.css('display', form1.css('display') === 'none' ? 'block' : 'none');
//                 });

//                 $('[id^=toggle-sort]').click(function () {
//                     var index = this.id.split('-')[2];
//                     var form2 = $('#form2-' + index);
//                     form2.css('display', form2.css('display') === 'none' ? 'block' : 'none');
//                 });

//             }
//         });
//     });
// }


function consultarIncidencias() {
    var value = 0; // Inicializar value a 0

    $('.filtro_incidencia').on('click', function () {
        // Eliminar la clase 'active' de todos los botones
        $('.filtro_incidencia').removeClass('active');

        // Añadir la clase 'active' al botón pulsado
        $(this).addClass('active');

        // Obtener el valor del botón pulsado
        value = $(this).data('value');
        // console.log(value);

        // Realizar la solicitud AJAX
        $.ajax({
            url: 'admin.php',
            type: 'POST',
            data: { value: value },
            success: function (response) {
                // Actualizar el contenido del div con la respuesta
                $('#result').html(response);

                // Añadir manejadores de eventos después de que el contenido se haya cargado
                $('[id^=toggle-pencil]').click(function () {
                    var index = this.id.split('-')[2];
                    toggleForms(index, 'form1');
                });

                $('[id^=toggle-sort]').click(function () {
                    var index = this.id.split('-')[2];
                    toggleForms(index, 'form2');
                });

            }
        });
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



function editarIncidencia(numIncidencia){
    // prueba = this.innerHTML;
    // console.log(prueba);

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
            // Si hay un error en la solicitud AJAX, mostrar un mensaje de alerta
            alert('Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
        }
    });
}



document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();
    SesionUser();
    insertarProfesor();
});



// NO FUNCIONA


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

