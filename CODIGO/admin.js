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
document.addEventListener("DOMContentLoaded", function () {
    consultarIncidencias();

});


function editar_incidencia()
{
    let boton =  document.getElementById("form");
    boton.style.display = "block";
}