/* let pacientes = [
    {
        id: 1,
        nombre: 'Sofía Martínez',
        edad: 28,
        peso: 69,
        estatura: 1.70,
        rutina: 'Pierna y Glúteo',
        plan: 'Plan Equilibrio 1800 kcal'
    },
    {
        id: 2,
        nombre: 'Luis Ramírez',
        edad: 35,
        peso: 82,
        estatura: 1.75,
        rutina: 'Tren Superior',
        plan: 'Plan Proteico 2200 kcal'
    },
    {
        id: 3,
        nombre: 'Ana Torres',
        edad: 42,
        peso: 58,
        estatura: 1.62,
        rutina: 'Core y Estabilidad',
        plan: 'Plan Vegetariano 2000 kcal'
    },
    {
        id: 4,
        nombre: 'Miguel Herrera',
        edad: 31,
        peso: 91,
        estatura: 1.78,
        rutina: '',
        plan: ''
    }
];

let citas = cargarCitasGestion();
let profesionalActivoId = obtenerProfesionalActivoId();
let pacienteSeleccionado = null;
let citaReagendarId = null;
let proximoIdCita = citas.reduce(function (max, cita) {
    return cita.id > max ? cita.id : max;
}, 0) + 1;

document.addEventListener('DOMContentLoaded', function () {
    seleccionarProfesional(profesionalActivoId, false);
    renderizarPacientes();
    inicializarModalReagendar();
});

function renderizarProfesionales() {
    let contenedor = document.getElementById('gridProfesionales');
    contenedor.innerHTML = '';

    PROFESIONALES.forEach(function (prof) {
        let div = document.createElement('div');
        div.className = 'profesional-item';

        if (prof.id === profesionalActivoId) {
            div.classList.add('profesional-activo');
        }

        div.onclick = function () {
            seleccionarProfesional(prof.id);
        };

        let badgeTexto = prof.id === profesionalActivoId
            ? 'Sesión actual'
            : prof.pacientes + ' pacientes';

        let badgeClase = prof.id === profesionalActivoId ? 'badge-prof activo' : 'badge-prof';

        div.innerHTML =
            '<img src="img/usuario.png" alt="Profesional" width="50">' +
            '<div>' +
            '<h5>' + prof.nombre + '</h5>' +
            '<p>' + prof.especialidad + '</p>' +
            '<span class="' + badgeClase + '">' + badgeTexto + '</span>' +
            '</div>';

        contenedor.appendChild(div);
    });
}

function seleccionarProfesional(id, renderizarListaPacientes) {
    if (renderizarListaPacientes === undefined) {
        renderizarListaPacientes = true;
    }

    profesionalActivoId = id;
    guardarProfesionalActivoId(id);

    let profesional = obtenerProfesionalPorId(id);
    if (!profesional) return;

    document.getElementById('nombreProfesionalHeader').innerHTML = '<b>' + profesional.nombre + '</b>';
    document.getElementById('especialidadProfesionalHeader').textContent = profesional.especialidad;
    document.getElementById('subtituloCitasProf').textContent = 'Citas asignadas a ' + profesional.nombre;

    renderizarProfesionales();
    renderizarCitas();
    actualizarContadores();

    if (renderizarListaPacientes) {
        renderizarPacientes(document.getElementById('buscarPaciente').value);
    }
}

function persistirCitas() {
    guardarCitas(citas);
}

function recargarCitasProfesional() {
    citas = cargarCitas();
}

function inicializarModalReagendar() {
    document.getElementById('btnCerrarModal').addEventListener('click', cerrarModal);
    document.getElementById('btnCancelarModal').addEventListener('click', cerrarModal);
    document.getElementById('btnConfirmarReagendar').addEventListener('click', confirmarReagendar);

    document.getElementById('modalReagendar').addEventListener('click', function (event) {
        if (event.target.id === 'modalReagendar') {
            cerrarModal();
        }
    });
}

function renderizarPacientes(filtro) {
    let contenedor = document.getElementById('listaPacientes');
    contenedor.innerHTML = '';

    let lista = pacientes;
    if (filtro) {
        let termino = filtro.toLowerCase();
        lista = pacientes.filter(function (p) {
            return p.nombre.toLowerCase().includes(termino);
        });
    }

    if (lista.length === 0) {
        contenedor.innerHTML = '<p class="mensaje-vacio pequeno">No se encontraron pacientes.</p>';
        return;
    }

    lista.forEach(function (paciente) {
        let div = document.createElement('div');
        div.className = 'paciente-item';
        if (pacienteSeleccionado && pacienteSeleccionado.id === paciente.id) {
            div.classList.add('seleccionado');
        }
        div.onclick = function () { seleccionarPaciente(paciente.id); };

        div.innerHTML =
            '<img src="img/usuario.png" alt="Paciente">' +
            '<div>' +
            '<h5>' + paciente.nombre + '</h5>' +
            '<small>' + paciente.edad + ' años • ' + paciente.peso + ' kg • ' + paciente.estatura + ' m</small>' +
            '</div>';

        contenedor.appendChild(div);
    });
}

function filtrarPacientes() {
    let termino = document.getElementById('buscarPaciente').value;
    renderizarPacientes(termino);
}

function seleccionarPaciente(id) {
    pacienteSeleccionado = pacientes.find(function (p) { return p.id === id; });

    renderizarPacientes(document.getElementById('buscarPaciente').value);

    document.getElementById('sinSeleccion').classList.add('oculto');
    document.getElementById('detallePaciente').classList.remove('oculto');

    document.getElementById('detNombre').textContent = pacienteSeleccionado.nombre;
    document.getElementById('detInfo').textContent = 'Paciente registrado en VidaFit';
    document.getElementById('detEdad').textContent = pacienteSeleccionado.edad + ' años';
    document.getElementById('detPeso').textContent = pacienteSeleccionado.peso + ' kg';
    document.getElementById('detEstatura').textContent = pacienteSeleccionado.estatura + ' m';

    document.getElementById('nombrePacienteCard').textContent = pacienteSeleccionado.nombre.split(' ')[0];
    document.getElementById('estadoPacienteCard').textContent = 'Paciente activo';

    document.getElementById('imcSinPaciente').classList.add('oculto');
    document.getElementById('seccionIMC').classList.remove('oculto');
    document.getElementById('imcPeso').value = pacienteSeleccionado.peso;
    document.getElementById('imcEstatura').value = pacienteSeleccionado.estatura;
    document.getElementById('resultadoIMC').classList.add('oculto');

    document.getElementById('rutinaSinPaciente').classList.add('oculto');
    document.getElementById('seccionRutina').classList.remove('oculto');
    document.getElementById('selectRutina').value = '';
    document.getElementById('rutinaActual').textContent = pacienteSeleccionado.rutina || 'Sin rutina asignada';
    document.getElementById('mensajeRutina').textContent = '';

    document.getElementById('planSinPaciente').classList.add('oculto');
    document.getElementById('seccionPlan').classList.remove('oculto');
    document.getElementById('selectPlan').value = '';
    document.getElementById('planActual').textContent = pacienteSeleccionado.plan || 'Sin plan asignado';
    document.getElementById('mensajePlan').textContent = '';
}

function calcularIMC() {
    if (!pacienteSeleccionado) return;

    let peso = parseFloat(document.getElementById('imcPeso').value);
    let estatura = parseFloat(document.getElementById('imcEstatura').value);

    if (isNaN(peso) || peso <= 0) {
        alert('Ingrese un peso válido.');
        return;
    }

    if (isNaN(estatura) || estatura <= 0) {
        alert('Ingrese una estatura válida.');
        return;
    }

    let imc = peso / (estatura * estatura);
    let imcRedondeado = imc.toFixed(1);
    let clasificacion = obtenerClasificacionIMC(imc);

    document.getElementById('valorIMC').textContent = imcRedondeado;

    let elemClasificacion = document.getElementById('clasificacionIMC');
    elemClasificacion.textContent = clasificacion.texto;
    elemClasificacion.className = 'estado ' + clasificacion.clase;

    document.getElementById('resultadoIMC').classList.remove('oculto');

    pacienteSeleccionado.peso = peso;
    pacienteSeleccionado.estatura = estatura;
    document.getElementById('detPeso').textContent = peso + ' kg';
    document.getElementById('detEstatura').textContent = estatura + ' m';
    renderizarPacientes(document.getElementById('buscarPaciente').value);
}

function obtenerClasificacionIMC(imc) {
    if (imc < 18.5) {
        return { texto: 'Bajo peso', clase: 'clasificacion-bajo' };
    }
    if (imc < 25) {
        return { texto: 'Normal', clase: 'clasificacion-normal' };
    }
    if (imc < 30) {
        return { texto: 'Sobrepeso', clase: 'clasificacion-sobrepeso' };
    }
    return { texto: 'Obesidad', clase: 'clasificacion-obesidad' };
}

function asignarRutina() {
    if (!pacienteSeleccionado) return;

    let rutina = document.getElementById('selectRutina').value;
    if (rutina === '') {
        document.getElementById('mensajeRutina').textContent = 'Seleccione una rutina.';
        document.getElementById('mensajeRutina').style.color = '#F4A261';
        return;
    }

    pacienteSeleccionado.rutina = rutina;
    document.getElementById('rutinaActual').textContent = rutina;
    document.getElementById('mensajeRutina').textContent = 'Rutina asignada correctamente.';
    document.getElementById('mensajeRutina').style.color = '#2A9D8F';

    setTimeout(function () {
        document.getElementById('mensajeRutina').textContent = '';
    }, 2500);
}

function asignarPlan() {
    if (!pacienteSeleccionado) return;

    let plan = document.getElementById('selectPlan').value;
    if (plan === '') {
        document.getElementById('mensajePlan').textContent = 'Seleccione un plan nutricional.';
        document.getElementById('mensajePlan').style.color = '#F4A261';
        return;
    }

    pacienteSeleccionado.plan = plan;
    document.getElementById('planActual').textContent = plan;
    document.getElementById('mensajePlan').textContent = 'Plan alimenticio asignado correctamente.';
    document.getElementById('mensajePlan').style.color = '#2A9D8F';

    setTimeout(function () {
        document.getElementById('mensajePlan').textContent = '';
    }, 2500);
}

function renderizarCitas() {
    recargarCitasProfesional();

    let contenedor = document.getElementById('listaCitas');
    contenedor.innerHTML = '';

    let citasProfesional = citas.filter(function (cita) {
        return cita.profesionalId === profesionalActivoId;
    });

    if (citasProfesional.length === 0) {
        contenedor.innerHTML = '<p class="mensaje-vacio pequeno">Este profesional no tiene citas registradas.</p>';
        actualizarContadores();
        return;
    }

    citasProfesional.forEach(function (cita) {
        let div = document.createElement('div');
        div.className = 'cita-item';
        div.id = 'cita-' + cita.id;

        let fechaFormateada = formatearFecha(cita.fecha);
        let horaFormateada = formatearHora(cita.hora);
        let claseEstado = obtenerClaseEstado(cita.estado);
        let deshabilitado = cita.estado === 'Cancelada';

        div.innerHTML =
            '<div class="cita-info">' +
            '<h5>' + cita.paciente + '</h5>' +
            '<p>' + fechaFormateada + ' • ' + horaFormateada + '</p>' +
            '<span class="cita-estado ' + claseEstado + '" id="estado-' + cita.id + '">' + cita.estado + '</span>' +
            '</div>' +
            '<div class="cita-acciones">' +
            '<button type="button" class="btn-cita btn-reagendar" onclick="abrirReagendar(' + cita.id + ')" ' + (deshabilitado ? 'disabled' : '') + '>Reagendar</button>' +
            '<button type="button" class="btn-cita btn-cancelar" onclick="cancelarCita(' + cita.id + ')" ' + (deshabilitado ? 'disabled' : '') + '>Cancelar</button>' +
            '<button type="button" class="btn-cita btn-asistida" onclick="marcarAsistida(' + cita.id + ')" ' + (deshabilitado ? 'disabled' : '') + '>Asistida</button>' +
            '<button type="button" class="btn-cita btn-no-asistida" onclick="marcarNoAsistida(' + cita.id + ')" ' + (deshabilitado ? 'disabled' : '') + '>No asistida</button>' +
            '</div>';

        contenedor.appendChild(div);
    });

    actualizarContadores();
}

function formatearFecha(fecha) {
    let partes = fecha.split('-');
    let meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    return partes[2] + ' ' + meses[parseInt(partes[1]) - 1] + ' ' + partes[0];
}

function formatearHora(hora) {
    let partes = hora.split(':');
    let h = parseInt(partes[0]);
    let m = partes[1];
    let periodo = h >= 12 ? 'PM' : 'AM';
    if (h > 12) h -= 12;
    if (h === 0) h = 12;
    return h + ':' + m + ' ' + periodo;
}

function obtenerClaseEstado(estado) {
    switch (estado) {
        case 'Confirmada': return 'estado-confirmada';
        case 'Pendiente': return 'estado-pendiente';
        case 'Cancelada': return 'estado-cancelada';
        case 'Asistida': return 'estado-asistida';
        case 'No asistida': return 'estado-no-asistida';
        default: return 'estado-pendiente';
    }
}

function actualizarEstadoCita(id, nuevoEstado) {
    let cita = citas.find(function (c) { return c.id === id; });
    if (cita) {
        cita.estado = nuevoEstado;
        persistirCitas();
    }

    renderizarCitas();
}

function cancelarCita(id) {
    if (confirm('¿Desea cancelar esta cita?')) {
        actualizarEstadoCita(id, 'Cancelada');
    }
}

function marcarAsistida(id) {
    actualizarEstadoCita(id, 'Asistida');
}

function marcarNoAsistida(id) {
    actualizarEstadoCita(id, 'No asistida');
}

function abrirReagendar(id) {
    citaReagendarId = id;
    let cita = citas.find(function (c) { return c.id === id; });

    document.getElementById('modalPacienteNombre').textContent = 'Paciente: ' + cita.paciente;
    document.getElementById('nuevaFecha').value = cita.fecha;
    document.getElementById('nuevaHora').value = normalizarHora(cita.hora);
    document.getElementById('errorReagendar').textContent = '';
    document.getElementById('mensajeReagendar').textContent = '';
    document.getElementById('modalReagendar').classList.remove('oculto');
}

function normalizarHora(hora) {
    if (!hora) return '';
    let partes = hora.split(':');
    if (partes.length >= 2) {
        return partes[0].padStart(2, '0') + ':' + partes[1].padStart(2, '0');
    }
    return hora;
}

function cerrarModal() {
    document.getElementById('modalReagendar').classList.add('oculto');
    document.getElementById('errorReagendar').textContent = '';
    document.getElementById('mensajeReagendar').textContent = '';
    document.getElementById('nuevaFecha').value = '';
    document.getElementById('nuevaHora').value = '';
    citaReagendarId = null;
}

function confirmarReagendar() {
    let fecha = document.getElementById('nuevaFecha').value.trim();
    let hora = normalizarHora(document.getElementById('nuevaHora').value.trim());

    document.getElementById('errorReagendar').textContent = '';
    document.getElementById('mensajeReagendar').textContent = '';

    if (!fecha) {
        document.getElementById('errorReagendar').textContent = 'Seleccione una fecha válida.';
        return;
    }

    if (!hora) {
        document.getElementById('errorReagendar').textContent = 'Seleccione una hora válida.';
        return;
    }

    if (!citaReagendarId) {
        document.getElementById('errorReagendar').textContent = 'No se encontró la cita seleccionada.';
        return;
    }

    let cita = citas.find(function (c) { return c.id === citaReagendarId; });
    if (cita) {
        cita.fecha = fecha;
        cita.hora = hora;
        cita.estado = 'Confirmada';
        persistirCitas();
    }

    cerrarModal();
    renderizarCitas();
}

function actualizarContadores() {
    recargarCitasProfesional();

    document.getElementById('totalPacientes').textContent = pacientes.length;

    let citasProfesional = citas.filter(function (cita) {
        return cita.profesionalId === profesionalActivoId;
    });

    let pendientes = citasProfesional.filter(function (c) {
        return c.estado === 'Pendiente' || c.estado === 'Confirmada';
    }).length;

    document.getElementById('totalCitasPendientes').textContent = pendientes;
    document.getElementById('contadorCitas').textContent = citasProfesional.length + ' citas registradas';
} */
