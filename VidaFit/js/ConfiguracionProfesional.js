let modoEdicion = false;
let valoresOriginales = {};

function toggleEdicion() {
    modoEdicion = !modoEdicion;

    let campos = ['campoNombre', 'campoCorreo', 'campoTelefono', 'campoEspecialidad'];
    campos.forEach(function (id) {
        document.getElementById(id).disabled = !modoEdicion;
    });

    if (modoEdicion) {
        valoresOriginales = {
            nombre: document.getElementById('campoNombre').value,
            correo: document.getElementById('campoCorreo').value,
            telefono: document.getElementById('campoTelefono').value,
            especialidad: document.getElementById('campoEspecialidad').value
        };
        document.getElementById('btnEditar').textContent = 'Cancelar edición';
        document.getElementById('botonesEdicion').classList.remove('oculto');
    } else {
        document.getElementById('btnEditar').textContent = 'Editar perfil';
        document.getElementById('botonesEdicion').classList.add('oculto');
        limpiarErroresPerfil();
    }
}

function cancelarEdicion() {
    document.getElementById('campoNombre').value = valoresOriginales.nombre;
    document.getElementById('campoCorreo').value = valoresOriginales.correo;
    document.getElementById('campoTelefono').value = valoresOriginales.telefono;
    document.getElementById('campoEspecialidad').value = valoresOriginales.especialidad;

    modoEdicion = true;
    toggleEdicion();
    document.getElementById('mensajePerfil').textContent = '';
}

function limpiarErroresPerfil() {
    document.getElementById('errorNombre').textContent = '';
    document.getElementById('errorCorreo').textContent = '';
    document.getElementById('errorTelefono').textContent = '';
    document.getElementById('errorEspecialidad').textContent = '';
}

function guardarPerfil() {
    limpiarErroresPerfil();

    let nombre = document.getElementById('campoNombre').value.trim();
    let correo = document.getElementById('campoCorreo').value.trim();
    let telefono = document.getElementById('campoTelefono').value.trim();
    let especialidad = document.getElementById('campoEspecialidad').value;

    let valido = true;
    let regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\.]+$/;
    let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let regexTelefono = /^[\d\s\-\+]{7,15}$/;

    if (nombre === '') {
        document.getElementById('errorNombre').textContent = 'El nombre es obligatorio.';
        valido = false;
    } else if (nombre.length < 5) {
        document.getElementById('errorNombre').textContent = 'Mínimo 5 caracteres.';
        valido = false;
    } else if (!regexNombre.test(nombre)) {
        document.getElementById('errorNombre').textContent = 'Solo letras y espacios.';
        valido = false;
    }

    if (correo === '') {
        document.getElementById('errorCorreo').textContent = 'El correo es obligatorio.';
        valido = false;
    } else if (!regexCorreo.test(correo)) {
        document.getElementById('errorCorreo').textContent = 'Correo electrónico inválido.';
        valido = false;
    }

    if (telefono === '') {
        document.getElementById('errorTelefono').textContent = 'El teléfono es obligatorio.';
        valido = false;
    } else if (!regexTelefono.test(telefono)) {
        document.getElementById('errorTelefono').textContent = 'Teléfono inválido.';
        valido = false;
    }

    if (especialidad === '') {
        document.getElementById('errorEspecialidad').textContent = 'Seleccione una especialidad.';
        valido = false;
    }

    if (!valido) return;

    document.getElementById('nombreHeader').innerHTML = '<b>' + nombre + '</b>';
    document.getElementById('mensajePerfil').textContent = 'Perfil actualizado correctamente.';

    modoEdicion = true;
    toggleEdicion();

    setTimeout(function () {
        document.getElementById('mensajePerfil').textContent = '';
    }, 3000);
}

function togglePass(idCampo) {
    let input = document.getElementById(idCampo);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}


function guardarPreferencias() {
    let msg = document.getElementById('mensajeConfig');
    msg.textContent = 'Preferencias guardadas.';

    setTimeout(function () {
        msg.textContent = '';
    }, 2500);
}
