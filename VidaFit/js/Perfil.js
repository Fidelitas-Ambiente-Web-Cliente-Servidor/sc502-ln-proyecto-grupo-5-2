let modoEdicion = false;

function toggleEdicion() {
    modoEdicion = !modoEdicion;

    let campos = document.querySelectorAll('#nombre, #correo, #fechaNacimiento, #telefono, #peso, #talla, #objetivo, #condiciones');
    let botonesEdicion = document.getElementById('botonesEdicion');
    let btnEditar = document.getElementById('btnEditar');
    let mensajePerfil = document.getElementById('mensajePerfil');

    mensajePerfil.textContent = '';

    if (modoEdicion) {
        campos.forEach(function (campo) {
            campo.disabled = false;
        });
        botonesEdicion.style.display = 'flex';
        btnEditar.textContent = '← Volver';
    } else {
        campos.forEach(function (campo) {
            campo.disabled = true;
        });
        botonesEdicion.style.display = 'none';
        btnEditar.textContent = '✏️ Editar';
    }
}

function guardarPerfil() {
    document.getElementById('errorNombre').textContent = '';
    document.getElementById('errorCorreo').textContent = '';
    document.getElementById('errorFecha').textContent = '';
    document.getElementById('errorTelefono').textContent = '';
    document.getElementById('mensajePerfil').textContent = '';

    let nombre = document.getElementById('nombre').value.trim();
    let correo = document.getElementById('correo').value.trim();
    let fecha = document.getElementById('fechaNacimiento').value;
    let telefono = document.getElementById('telefono').value.trim();

    let valido = true;
    let regexNombre = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{5,}$/;

    if (nombre === '') {
        document.getElementById('errorNombre').textContent = 'El nombre es obligatorio.';
        valido = false;
    } else if (!regexNombre.test(nombre)) {
        document.getElementById('errorNombre').textContent = 'El nombre solo puede contener letras y espacios (mínimo 5).';
        valido = false;
    }

    let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (correo === '') {
        document.getElementById('errorCorreo').textContent = 'El correo es obligatorio.';
        valido = false;
    } else if (!regexCorreo.test(correo)) {
        document.getElementById('errorCorreo').textContent = 'Ingrese un correo electrónico válido.';
        valido = false;
    }

    if (fecha === '') {
        document.getElementById('errorFecha').textContent = 'La fecha de nacimiento es obligatoria.';
        valido = false;
    } else {
        let hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        let fechaNac = new Date(fecha + 'T00:00:00');
        if (fechaNac > hoy) {
            document.getElementById('errorFecha').textContent = 'La fecha de nacimiento no puede ser futura.';
            valido = false;
        }
    }

    let regexTel = /^[\d\-]{8,12}$/;
    if (telefono !== '' && !regexTel.test(telefono)) {
        document.getElementById('errorTelefono').textContent = 'Formato de teléfono inválido (ej: 8888-1234).';
        valido = false;
    }

    if (!valido) return;

    document.getElementById('nombreMostrado').textContent = nombre;
    document.getElementById('mensajePerfil').textContent = '✅ Cambios guardados correctamente.';

    toggleEdicion();
}

function cancelarEdicion() {
    modoEdicion = true;
    toggleEdicion();
    document.getElementById('mensajePerfil').textContent = '';
}