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
function SesionUser() {
    var sesion = "";

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            var logueado = this.responseText; // Obtener la respuesta del servidor
            if (logueado != "exit"){
                var saludo = document.getElementById("saludo");
                saludo.innerHTML = "HOLA " + logueado;
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

// function insertarIncidencia() {
//     var formulario = document.getElementById("formulario_incidencia");
//     var datosFormulario = new FormData(formulario);

//     var xhttp = new XMLHttpRequest();

//     xhttp.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             // Manejar la respuesta del servidor si es necesario
//             console.log(this.responseText);
//         }
//     };

//     xhttp.open("POST", "insertar_incidencia.php", true); // Ajusta la URL según tu estructura
//     xhttp.send(datosFormulario);
// }

// Llama a la función consultarIncidencias al cargar el DOM
document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();
    SesionUser();
    
    
    


});
