$(function () {

    const urlBase = 'index.php';

    let modoEdicion = false;
    let valoresOriginales = { nombre: '', correo: '' };

    function cargarStats() {
        $.get(
            urlBase + '?option=obtenerProgresoActual',

            function (res) {
                if (res.response !== '00' || !res.registro) {
                    $('#perfilPesoStat').text('--');
                    $('#perfilImcStat').text('--');
                    return;
                }

                $('#perfilPesoStat').text(parseFloat(res.registro.peso_kg).toFixed(1));
                $('#perfilImcStat').text(
                    res.registro.imc !== null ? parseFloat(res.registro.imc).toFixed(1) : '--'
                );
            },

            'json'
        );
    }

    function cargarRol() {
        $.get(
            urlBase + '?option=obtenerUsuarioActual',

            function (res) {
                if (res.response !== '00' || !res.usuario) return;

                const rol = parseInt(res.usuario.id_rol, 10) === 2 ? 'Profesional' : 'Paciente';
                $('#perfilRol').text(rol);
            },

            'json'
        );
    }

    window.toggleEdicion = function () {
        modoEdicion = !modoEdicion;

        const nombreInput = document.getElementById('nombreCompletoInput');
        const correoInput = document.getElementById('correoUsuarioInput');
        const botonesEdicion = document.getElementById('botonesEdicion');
        const btnEditar = document.getElementById('btnEditar');
        const mensajePerfil = document.getElementById('mensajePerfil');

        mensajePerfil.textContent = '';
        document.getElementById('errorNombre').textContent = '';
        document.getElementById('errorCorreo').textContent = '';

        if (modoEdicion) {
            valoresOriginales = {
                nombre: nombreInput.value,
                correo: correoInput.value
            };

            nombreInput.disabled = false;
            correoInput.disabled = false;
            botonesEdicion.style.display = 'flex';
            btnEditar.textContent = '← Volver';
        } else {
            nombreInput.disabled = true;
            correoInput.disabled = true;
            botonesEdicion.style.display = 'none';
            btnEditar.textContent = 'Editar';
        }
    };

    window.guardarPerfil = function () {
        document.getElementById('errorNombre').textContent = '';
        document.getElementById('errorCorreo').textContent = '';
        document.getElementById('mensajePerfil').textContent = '';

        const nombre = document.getElementById('nombreCompletoInput').value.trim();
        const correo = document.getElementById('correoUsuarioInput').value.trim();

        let valido = true;
        const regexNombre = /^[A-Za-záéíóúÁÉÍÓÚñÑ\s]{5,}$/;

        if (nombre === '') {
            document.getElementById('errorNombre').textContent = 'El nombre es obligatorio.';
            valido = false;
        } else if (!regexNombre.test(nombre)) {
            document.getElementById('errorNombre').textContent = 'El nombre solo puede contener letras y espacios (mínimo 5).';
            valido = false;
        }

        const regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (correo === '') {
            document.getElementById('errorCorreo').textContent = 'El correo es obligatorio.';
            valido = false;
        } else if (!regexCorreo.test(correo)) {
            document.getElementById('errorCorreo').textContent = 'Ingrese un correo electrónico válido.';
            valido = false;
        }

        if (!valido) return;

        $.post(
            urlBase,

            {
                option: 'actualizarPerfil',
                nombre_completo: nombre,
                correo: correo
            },

            function (res) {
                if (res.response === '00') {
                    document.getElementById('mensajePerfil').textContent = '✅ Cambios guardados correctamente.';

                    $('#nombreUsuario').text(nombre);
                    $('.nombreCompletoUsuario').text(nombre);

                    window.toggleEdicion();
                } else {
                    document.getElementById('errorNombre').textContent = res.message || 'No se pudo guardar el perfil.';
                }
            },

            'json'
        );
    };

    window.cancelarEdicion = function () {
        document.getElementById('nombreCompletoInput').value = valoresOriginales.nombre;
        document.getElementById('correoUsuarioInput').value = valoresOriginales.correo;
        document.getElementById('mensajePerfil').textContent = '';

        modoEdicion = true;
        window.toggleEdicion();
    };

    cargarStats();
    cargarRol();

});