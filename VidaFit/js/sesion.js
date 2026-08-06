function cerrarSesion() {
    cerrarSesionUsuario();
}

// Protección de sesión DESACTIVADA para que puedas ver la página sin loguearte.
/*
document.addEventListener('DOMContentLoaded', function () {
    protegerPagina();

    var botonesLogout = document.querySelectorAll('.logout');
    botonesLogout.forEach(function (boton) {
        boton.addEventListener('click', cerrarSesion);
    });
});
*/

document.addEventListener('DOMContentLoaded', function () {
    var botonesLogout = document.querySelectorAll('.logout');
    botonesLogout.forEach(function (boton) {
        boton.addEventListener('click', cerrarSesion);
    });
});
