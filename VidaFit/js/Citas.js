$(function () {

    const urlBase = 'index.php';

    let citas = [];
    let filtroActual = 'todas';

    function estadoNormalizado(estado) {
        if (estado === 'Programada') return 'pendiente';
        if (estado === 'Completada') return 'completada';
        return estado ? estado.toLowerCase() : '';
    }

    function formatearFecha(fechaIso) {
        if (!fechaIso) return '';
        let partes = fechaIso.split('-');
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }

    function formatearHora(horaSql) {
        if (!horaSql) return '';
        let partes = horaSql.split(':');
        let h = parseInt(partes[0], 10);
        let m = partes[1];
        let sufijo = h >= 12 ? 'PM' : 'AM';
        let h12 = h % 12;
        if (h12 === 0) h12 = 12;
        return h12 + ':' + m + ' ' + sufijo;
    }

    function renderCitas() {
        let lista = document.getElementById('listaCitas');
        lista.innerHTML = '';

        // Las canceladas nunca se muestran en la lista.
        let visibles = citas.filter(function (cita) {
            return estadoNormalizado(cita.estado) !== 'cancelada';
        });

        let citasFiltradas = visibles.filter(function (cita) {
            return filtroActual === 'todas' || estadoNormalizado(cita.estado) === filtroActual;
        });

        if (citasFiltradas.length === 0) {
            let p = document.createElement('p');
            p.textContent = 'No hay citas en esta categoría.';
            p.style.color = '#5d6880';
            p.style.fontSize = '14px';
            lista.appendChild(p);
        } else {
            citasFiltradas.forEach(function (cita) {
                let card = document.createElement('div');
                card.className = 'cita-card';

                let iconoDiv = document.createElement('div');
                iconoDiv.className = 'cita-icono';
                iconoDiv.textContent = '🩺';

                let infoDiv = document.createElement('div');
                infoDiv.className = 'cita-info';

                let h4 = document.createElement('h4');
                h4.textContent = cita.nombre_profesional || 'Profesional';

                let pFecha = document.createElement('p');
                pFecha.textContent = '📅 ' + formatearFecha(cita.fecha) + ' — ' + formatearHora(cita.hora);

                let pMotivo = document.createElement('p');
                pMotivo.textContent = cita.motivo || '';

                let badge = document.createElement('span');
                badge.className = 'badge-estado';

                let estado = estadoNormalizado(cita.estado);
                if (estado === 'pendiente') {
                    badge.classList.add('badge-pendiente');
                    badge.textContent = '⏳ Pendiente';
                } else {
                    badge.classList.add('badge-completada');
                    badge.textContent = '✅ Completada';
                }

                infoDiv.appendChild(h4);
                infoDiv.appendChild(pFecha);
                infoDiv.appendChild(pMotivo);
                infoDiv.appendChild(badge);

                card.appendChild(iconoDiv);
                card.appendChild(infoDiv);

                if (estado === 'pendiente') {
                    let btnCancelar = document.createElement('button');
                    btnCancelar.className = 'btn-cancelar';
                    btnCancelar.textContent = '✕ Cancelar';

                    let citaId = cita.id_cita;
                    btnCancelar.onclick = function () {
                        cancelarCita(citaId);
                    };
                    card.appendChild(btnCancelar);
                }

                lista.appendChild(card);
            });
        }

        actualizarContadores(visibles);
    }

    function actualizarContadores(visibles) {
        let pendientes = 0;
        let completadas = 0;
        let profesionales = new Set();

        visibles.forEach(function (cita) {
            let estado = estadoNormalizado(cita.estado);
            if (estado === 'pendiente') pendientes++;
            if (estado === 'completada') completadas++;
            profesionales.add(cita.id_profesional);
        });

        document.getElementById('totalPendientes').textContent = pendientes;
        document.getElementById('totalCompletadas').textContent = completadas;

        let totalProfesionalesEl = document.getElementById('totalProfesionales');
        if (totalProfesionalesEl) {
            totalProfesionalesEl.textContent = profesionales.size;
        }
    }

    function cargarCitas() {
        $.get(
            urlBase + '?option=listarCitasPaciente',

            function (res) {
                if (res.response !== '00') {
                    console.log('Error al cargar citas:', res.message);
                    citas = [];
                } else {
                    citas = res.citas || [];
                }
                renderCitas();
            },

            'json'
        );
    }

    function cargarProximaCita() {
        $.get(
            urlBase + '?option=obtenerProximaCita',

            function (res) {
                let fechaEl = document.getElementById('proximaCitaFecha');
                let horaEl = document.getElementById('proximaCitaHora');

                if (res.response !== '00' || !res.cita) {
                    if (fechaEl) fechaEl.textContent = 'Sin citas';
                    if (horaEl) horaEl.textContent = '';
                    return;
                }

                if (fechaEl) fechaEl.textContent = formatearFecha(res.cita.fecha);
                if (horaEl) horaEl.textContent = formatearHora(res.cita.hora);
            },

            'json'
        );
    }

    function cargarProfesionales() {
        $.get(
            urlBase + '?option=listarProfesionales',

            function (res) {
                let select = document.getElementById('profesional');
                if (!select || res.response !== '00') return;

                select.innerHTML = '<option value="">-- Seleccionar profesional --</option>';

                (res.profesionales || []).forEach(function (prof) {
                    let opt = document.createElement('option');
                    opt.value = prof.id_usuario;
                    // La especialidad ya no se guarda por usuario (la app es
                    // solo para nutricionistas): se muestra como valor fijo.
                    opt.textContent = prof.nombre_completo + ' - Nutricionista';
                    select.appendChild(opt);
                });
            },

            'json'
        );
    }

    function cancelarCita(id) {
        $.post(
            urlBase,

            {
                option: 'cancelarCita',
                id_cita: id
            },

            function (res) {
                if (res.response === '00') {
                    cargarCitas();
                    cargarProximaCita();
                } else {
                    alert(res.message || 'No se pudo cancelar la cita.');
                }
            },

            'json'
        );
    }

    window.filtrarCitas = function (filtro, boton) {
        filtroActual = filtro;

        let botones = document.querySelectorAll('.filtro-cita');
        botones.forEach(function (btn) {
            btn.classList.remove('activo-cita');
        });
        boton.classList.add('activo-cita');

        renderCitas();
    };

    window.agendarCita = function () {
        document.getElementById('errorProfesional').textContent = '';
        document.getElementById('errorFecha').textContent = '';
        document.getElementById('errorHora').textContent = '';
        document.getElementById('errorMotivo').textContent = '';
        document.getElementById('mensajeCita').textContent = '';

        let idProfesional = document.getElementById('profesional').value;
        let fecha = document.getElementById('fechaCita').value;
        let hora = document.getElementById('horaCita').value;
        let motivo = document.getElementById('motivoCita').value.trim();

        let valido = true;

        if (idProfesional === '') {
            document.getElementById('errorProfesional').textContent = 'Seleccione un profesional.';
            valido = false;
        }

        if (fecha === '') {
            document.getElementById('errorFecha').textContent = 'Seleccione una fecha.';
            valido = false;
        } else {
            let hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            let fechaElegida = new Date(fecha + 'T00:00:00');
            if (fechaElegida < hoy) {
                document.getElementById('errorFecha').textContent = 'La fecha no puede ser pasada.';
                valido = false;
            }
        }

        if (hora === '') {
            document.getElementById('errorHora').textContent = 'Seleccione una hora.';
            valido = false;
        }

        if (motivo === '') {
            document.getElementById('errorMotivo').textContent = 'Describa el motivo de la cita.';
            valido = false;
        } else if (motivo.length < 10) {
            document.getElementById('errorMotivo').textContent = 'El motivo debe tener al menos 10 caracteres.';
            valido = false;
        }

        if (!valido) return;

        $.post(
            urlBase,

            {
                option: 'crearCita',
                id_profesional: idProfesional,
                fecha: fecha,
                hora: hora,
                motivo: motivo
            },

            function (res) {
                if (res.response === '00') {
                    document.getElementById('profesional').value = '';
                    document.getElementById('fechaCita').value = '';
                    document.getElementById('horaCita').value = '';
                    document.getElementById('motivoCita').value = '';

                    document.getElementById('mensajeCita').textContent = '✅ Cita agendada exitosamente.';

                    cargarCitas();
                    cargarProximaCita();
                } else {
                    document.getElementById('errorProfesional').textContent =
                        res.message || 'No se pudo agendar la cita.';
                }
            },

            'json'
        );
    };

    cargarProfesionales();
    cargarCitas();
    cargarProximaCita();

});