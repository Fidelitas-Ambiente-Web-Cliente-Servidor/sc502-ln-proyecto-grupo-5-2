function guardarConfig() {
    let msg = document.getElementById('mensajeConfig');
    msg.textContent = '✅ Preferencias guardadas.';

    setTimeout(function () {
        msg.textContent = '';
    }, 2500);
}

function togglePass(idCampo) {
    let input = document.getElementById(idCampo);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

function cambiarContrasena() {
    document.getElementById('errorActual').textContent = '';
    document.getElementById('errorNueva').textContent = '';
    document.getElementById('errorConfirmar').textContent = '';
    document.getElementById('mensajePass').textContent = '';

    let actual = document.getElementById('passActual').value;
    let nueva = document.getElementById('passNueva').value;
    let confirmar = document.getElementById('passConfirmar').value;

    let valido = true;

    if (actual.trim() === '') {
        document.getElementById('errorActual').textContent = 'Ingrese su contraseña actual.';
        valido = false;
    }

    if (nueva.trim() === '') {
        document.getElementById('errorNueva').textContent = 'La nueva contraseña es obligatoria.';
        valido = false;
    } else if (nueva.trim().length < 8) {
        document.getElementById('errorNueva').textContent = 'La contraseña debe tener mínimo 8 caracteres.';
        valido = false;
    }

    if (confirmar.trim() === '') {
        document.getElementById('errorConfirmar').textContent = 'Confirme la nueva contraseña.';
        valido = false;
    } else if (nueva !== confirmar) {
        document.getElementById('errorConfirmar').textContent = 'Las contraseñas no coinciden.';
        valido = false;
    }

    if (!valido) return;

    document.getElementById('passActual').value = '';
    document.getElementById('passNueva').value = '';
    document.getElementById('passConfirmar').value = '';

    document.getElementById('mensajePass').textContent = '✅ Contraseña actualizada correctamente.';

    setTimeout(function () {
        document.getElementById('mensajePass').textContent = '';
    }, 3000);
}

function cerrarSesion() {
    window.location.href = 'inicioSesion.html';
}