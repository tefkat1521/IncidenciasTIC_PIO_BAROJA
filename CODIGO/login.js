document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();
        //Evitamos que el formulario mande a algún lado, si conectamos el html con el php borrar esta línea

        ComprobarCredenciales();//Función para comprobar credenciales de prueba, sin usar base de datos
    });
});

function ComprobarCredenciales() {
    let user = document.getElementById("username").value;
    let pass = document.getElementById("password").value;

    if (user === "admin" && pass === "admin") {
        // Si las credenciales son correctas, redirige a la página paginaprincipal.html
        window.location.href = "paginaprincipal.html";
    } else {
        alert("Usuario o contraseña incorrectos");
    }
}