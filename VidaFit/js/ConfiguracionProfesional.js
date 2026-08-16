let modoEdicion = false;
let valoresOriginales = {};

const urlBaseConfigProf = 'index.php';

function toggleEdicion() {
    modoEdicion = !modoEdicion;

    let campos = ['nombreCompletoInput', 'correoUsuarioInput'];
    campos.forEach(function (id) {
        document.getElementById(id).disabled = !modoEdicion;
    });

    if (modoEdicion) {
        valoresOriginales = {
            nombre: document.getElementById('nombreCompletoInput').value,
            correo: document.getElementById('correoUsuarioInput').value
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
    document.getElementById('nombreCompletoInput').value = valoresOriginales.nombre;
    document.getElementById('correoUsuarioInput').value = valoresOriginales.correo;

    modoEdicion = true;
    toggleEdicion();
    document.getElementById('mensajePerfil').textContent = '';
}

function limpiarErroresPerfil() {
    document.getElementById('errorNombre').textContent = '';
    document.getElementById('errorCorreo').textContent = '';
}

function guardarPerfil() {
    limpiarErroresPerfil();

    let nombre = document.getElementById('nombreCompletoInput').value.trim();
    let correo = document.getElementById('correoUsuarioInput').value.trim();

    let valido = true;
    let regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s\.]+$/;
    let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

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

    if (!valido) return;

    $.post(
        urlBaseConfigProf,
        {
            option: 'actualizarPerfil',
            nombre_completo: nombre,
            correo: correo
        },
        function (res) {
            if (res.response === '00') {
                $('.nombreCompletoUsuario').text(nombre);
                document.getElementById('mensajePerfil').textContent = res.message || 'Perfil actualizado correctamente.';

                modoEdicion = true;
                toggleEdicion();

                setTimeout(function () {
                    document.getElementById('mensajePerfil').textContent = '';
                }, 3000);
            } else {
                document.getElementById('errorCorreo').textContent = res.message || 'No se pudo actualizar el perfil.';
            }
        },
        'json'
    ).fail(function () {
        document.getElementById('errorCorreo').textContent = 'Ocurrió un error al actualizar el perfil.';
    });
}

function togglePass(idCampo) {
    let input = document.getElementById(idCampo);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}