function consultarIncidencias() {
    var PaginaPrincipal = 0;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var TablaIncidencias = this.response; // Obtener la respuesta del servidor
            var DivIncidencias = document.getElementById("contenedor_incidencias");

            DivIncidencias.innerHTML = TablaIncidencias;
        }
    };

    xhttp.open("POST", "code.php", true); // true indica una solicitud asíncrona
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("PaginaPrincipal=" + PaginaPrincipal);
}

function insertarIncidencia() {
    var insertar = "";

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var formulario = this.response; // Obtener la respuesta del servidor
            var divInsertarNueva = document.getElementById("ContenedorInsertarIncidencia");
            divInsertarNueva.innerHTML = formulario;
        }
    };

    xhttp.open("POST", "code.php", true); // true indica una solicitud asíncrona
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("insertar=" + insertar);
}



function SesionUser() {
    var sesion = "";

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var logueado = this.responseText; // Obtener la respuesta del servidor
            if (logueado != "exit"){
                var saludo = document.getElementById("saludo");
                saludo.innerHTML = "HOLA, " + logueado;
            }else{
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


function habilitarSegundoSelect() {
    const primerSelect = document.getElementById("elaula");
    const segundoSelect = document.getElementById("elciclo");
    const opcionesHabilitar = Array.from({length: 20}, (_, i) => (i + 1).toString());

    if (opcionesHabilitar.includes(primerSelect.value)) {
        segundoSelect.disabled = true;
    } else {
        segundoSelect.disabled = false;
    }
}



////////////////////////////////////////LLAMADAS FUNCIONES///////////////////////////////////////////////////

// Llama a la función consultarIncidencias al cargar el DOM
document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();
    SesionUser();
    insertarIncidencia();   
});

