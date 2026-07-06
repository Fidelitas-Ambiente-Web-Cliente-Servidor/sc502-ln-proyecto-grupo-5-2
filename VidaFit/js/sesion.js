function cerrarSesion() {
    cerrarSesionUsuario();
}

document.addEventListener('DOMContentLoaded', function () {
    protegerPagina();

    var botonesLogout = document.querySelectorAll('.logout');
    botonesLogout.forEach(function (boton) {
        boton.addEventListener('click', cerrarSesion);
    });
});
