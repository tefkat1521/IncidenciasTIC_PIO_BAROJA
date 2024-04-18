document.addEventListener("DOMContentLoaded", function () {
    var PaginaPrincipal = 0;

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var TablaIncidencias = this.response; // Obtener la respuesta del servidor
            var DivIncidencias = document.getElementById("contenedor_incidencias");

            DivIncidencias.innerHTML =TablaIncidencias;
        }
    };


    xhttp.open("POST", "code.php", true); // true indica una solicitud asíncrona
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("PaginaPrincipal=" + PaginaPrincipal);
});