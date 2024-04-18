document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();
        ComprobarCredenciales(); // Llamada a la función para comprobar credenciales
    });
});

function ComprobarCredenciales() {
    var xhttp = new XMLHttpRequest();
    var user = document.getElementById("username").value;
    var pass = document.getElementById("password").value;

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var sesion = this.response; // Obtener la respuesta del servidor
            if (sesion === "true") {
                // Si las credenciales son correctas, redirige a la página ini.html
                window.location.href = "principal.html";
            } else {
                // Si las credenciales son incorrectas, mostrar un mensaje de alerta
                // alert("Usuario o contraseña incorrectos");
                alert("Usuario incorrecto mamon")
            }
        }
    };

    xhttp.open("POST", "code.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("user=" + user + "&pass=" + pass);
}
