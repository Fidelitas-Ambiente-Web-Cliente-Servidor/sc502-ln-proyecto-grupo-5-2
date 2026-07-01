// citas.js — Pagina Citas

// Array con las citas existentes
let citas = [
    {
        id: 1,
        profesional: 'Dra. Laura Sánchez - Nutricionista',
        fecha: '2025-06-27',
        hora: '10:00 AM',
        motivo: 'Control mensual de peso y plan nutricional',
        estado: 'pendiente'
    },
    {
        id: 2,
        profesional: 'Lic. Carlos Mora - Entrenador',
        fecha: '2025-07-04',
        hora: '8:00 AM',
        motivo: 'Ajuste de rutina de ejercicios',
        estado: 'pendiente'
    },
    {
        id: 3,
        profesional: 'Dra. Laura Sánchez - Nutricionista',
        fecha: '2025-05-15',
        hora: '11:00 AM',
        motivo: 'Primera consulta nutricional',
        estado: 'completada'
    },
    {
        id: 4,
        profesional: 'Lic. Carlos Mora - Entrenador',
        fecha: '2025-04-10',
        hora: '9:00 AM',
        motivo: 'Evaluación física inicial',
        estado: 'completada'
    }
];

let filtroActual = 'todas';
let proximoId = 5;

// Renderiza la lista de citas segun el filtro activo
function renderCitas() {
    let lista = document.getElementById('listaCitas');
    lista.innerHTML = '';

    // Filtra las citas segun el estado seleccionado
    let citasFiltradas = [];
    citas.forEach(function (cita) {
        if (filtroActual === 'todas') {
            citasFiltradas.push(cita);
        } else if (cita.estado === filtroActual) {
            citasFiltradas.push(cita);
        }
    });

    if (citasFiltradas.length === 0) {
        let p = document.createElement('p');
        p.textContent = 'No hay citas en esta categoría.';
        p.style.color = '#5d6880';
        p.style.fontSize = '14px';
        lista.appendChild(p);
        return;
    }

    citasFiltradas.forEach(function (cita) {
        let card = document.createElement('div');
        card.className = 'cita-card';

        // Icono segun el profesional
        let iconoDiv = document.createElement('div');
        iconoDiv.className = 'cita-icono';
        if (cita.profesional.includes('Entrenador')) {
            iconoDiv.classList.add('naranja');
            iconoDiv.textContent = '🏋️';
        } else {
            iconoDiv.textContent = '🩺';
        }

        // Informacion de la cita
        let infoDiv = document.createElement('div');
        infoDiv.className = 'cita-info';

        let h4 = document.createElement('h4');
        h4.textContent = cita.profesional;

        // Formatea la fecha de yyyy-mm-dd a dd/mm/yyyy
        let partes = cita.fecha.split('-');
        let fechaLegible = partes[2] + '/' + partes[1] + '/' + partes[0];

        let pFecha = document.createElement('p');
        pFecha.textContent = '📅 ' + fechaLegible + ' — ' + cita.hora;

        let pMotivo = document.createElement('p');
        pMotivo.textContent = cita.motivo;

        let badge = document.createElement('span');
        badge.className = 'badge-estado';
        if (cita.estado === 'pendiente') {
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

        // Boton cancelar solo para citas pendientes
        if (cita.estado === 'pendiente') {
            let btnCancelar = document.createElement('button');
            btnCancelar.className = 'btn-cancelar';
            btnCancelar.textContent = '✕ Cancelar';

            // Guarda el id en el boton para identificar que cita cancelar
            let citaId = cita.id;
            btnCancelar.onclick = function () {
                cancelarCita(citaId);
            };
            card.appendChild(btnCancelar);
        }

        lista.appendChild(card);
    });

    // Actualiza los contadores en las cards superiores
    actualizarContadores();
}

// Cambia el filtro activo y re-renderiza
function filtrarCitas(filtro, boton) {
    filtroActual = filtro;

    // Actualiza el botón activo
    let botones = document.querySelectorAll('.filtro-cita');
    botones.forEach(function (btn) {
        btn.classList.remove('activo-cita');
    });
    boton.classList.add('activo-cita');

    renderCitas();
}

// Valida y agrega una nueva cita
function agendarCita() {
    // Limpia errores previos
    document.getElementById('errorProfesional').textContent = '';
    document.getElementById('errorFecha').textContent = '';
    document.getElementById('errorHora').textContent = '';
    document.getElementById('errorMotivo').textContent = '';
    document.getElementById('mensajeCita').textContent = '';

    let profesional = document.getElementById('profesional').value;
    let fecha = document.getElementById('fechaCita').value;
    let hora = document.getElementById('horaCita').value;
    let motivo = document.getElementById('motivoCita').value.trim();

    let valido = true;

    // Valida profesional
    if (profesional === '') {
        document.getElementById('errorProfesional').textContent = 'Seleccione un profesional.';
        valido = false;
    }

    // Valida fecha (obligatoria y no pasada)
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

    // Valida hora
    if (hora === '') {
        document.getElementById('errorHora').textContent = 'Seleccione una hora.';
        valido = false;
    }

    // Valida motivo (obligatorio, al menos 10 caracteres)
    if (motivo === '') {
        document.getElementById('errorMotivo').textContent = 'Describa el motivo de la cita.';
        valido = false;
    } else if (motivo.length < 10) {
        document.getElementById('errorMotivo').textContent = 'El motivo debe tener al menos 10 caracteres.';
        valido = false;
    }

    if (!valido) return;

    // Crea el objeto de la nueva cita y lo agrega al array
    let nuevaCita = {
        id: proximoId,
        profesional: profesional,
        fecha: fecha,
        hora: hora,
        motivo: motivo,
        estado: 'pendiente'
    };
    proximoId++;
    citas.push(nuevaCita);

    // Limpia el formulario
    document.getElementById('profesional').value = '';
    document.getElementById('fechaCita').value = '';
    document.getElementById('horaCita').value = '';
    document.getElementById('motivoCita').value = '';

    // Muestra confirmacion
    document.getElementById('mensajeCita').textContent = '✅ Cita agendada exitosamente.';

    renderCitas();
}

// Cancela (elimina) una cita por su id 
function cancelarCita(id) {
    let nuevaLista = [];
    citas.forEach(function (cita) {
        if (cita.id !== id) {
            nuevaLista.push(cita);
        }
    });
    citas = nuevaLista;
    renderCitas();
}

// Actualiza los contadores de las cards superiores
function actualizarContadores() {
    let pendientes = 0;
    let completadas = 0;

    citas.forEach(function (cita) {
        if (cita.estado === 'pendiente') {
            pendientes++;
        } else if (cita.estado === 'completada') {
            completadas++;
        }
    });

    document.getElementById('totalPendientes').textContent = pendientes;
    document.getElementById('totalCompletadas').textContent = completadas;
}

// Inicializacion
document.addEventListener('DOMContentLoaded', function () {
    renderCitas();
});