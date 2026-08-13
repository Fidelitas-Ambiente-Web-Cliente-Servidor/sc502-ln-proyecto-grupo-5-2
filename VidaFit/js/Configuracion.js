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
