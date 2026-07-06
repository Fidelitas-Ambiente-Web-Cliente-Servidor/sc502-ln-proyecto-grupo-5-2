const PROFESIONALES = [
    {
        id: 1,
        nombre: 'Dr. Carlos Mendoza',
        especialidad: 'Nutricionista clínico',
        pacientes: 12
    },
    {
        id: 2,
        nombre: 'Dra. Laura Sánchez',
        especialidad: 'Nutricionista',
        pacientes: 12
    },
    {
        id: 3,
        nombre: 'Dr. Roberto Vega',
        especialidad: 'Médico general',
        pacientes: 9
    },
    {
        id: 4,
        nombre: 'Dra. Patricia Jiménez',
        especialidad: 'Endocrinóloga',
        pacientes: 7
    },
    {
        id: 5,
        nombre: 'Lic. Fernando Castro',
        especialidad: 'Fisioterapeuta',
        pacientes: 10
    }
];

const CLAVE_CITAS = 'vidafit_citas';
const CLAVE_CITAS_GESTION = 'vidafit_citas_gestion';
const CLAVE_CITAS_PACIENTE = 'vidafit_citas_paciente';
const CLAVE_PROFESIONAL_ACTIVO = 'vidafit_profesional_activo';

function obtenerProfesionalPorId(id) {
    return PROFESIONALES.find(function (prof) {
        return prof.id === id;
    });
}

function obtenerEtiquetaProfesional(profesional) {
    return profesional.nombre + ' - ' + profesional.especialidad;
}

function obtenerProfesionalPorEtiqueta(etiqueta) {
    return PROFESIONALES.find(function (prof) {
        return obtenerEtiquetaProfesional(prof) === etiqueta;
    });
}

function obtenerCitasIniciales() {
    return [
        {
            id: 1,
            paciente: 'Sofía Martínez',
            profesionalId: 1,
            fecha: '2026-06-27',
            hora: '10:00',
            motivo: 'Control mensual de peso y plan nutricional',
            estado: 'Confirmada'
        },
        {
            id: 2,
            paciente: 'Luis Ramírez',
            profesionalId: 2,
            fecha: '2026-06-28',
            hora: '11:30',
            motivo: 'Seguimiento nutricional semanal',
            estado: 'Pendiente'
        },
        {
            id: 3,
            paciente: 'Ana Torres',
            profesionalId: 3,
            fecha: '2026-06-29',
            hora: '09:00',
            motivo: 'Chequeo médico general',
            estado: 'Confirmada'
        },
        {
            id: 4,
            paciente: 'Miguel Herrera',
            profesionalId: 4,
            fecha: '2026-07-02',
            hora: '14:00',
            motivo: 'Control endocrinológico',
            estado: 'Pendiente'
        },
        {
            id: 5,
            paciente: 'Sofía Martínez',
            profesionalId: 5,
            fecha: '2026-07-05',
            hora: '16:30',
            motivo: 'Evaluación física y rutina de ejercicios',
            estado: 'Pendiente'
        },
        {
            id: 6,
            paciente: 'Luis Ramírez',
            profesionalId: 1,
            fecha: '2026-07-08',
            hora: '08:30',
            motivo: 'Revisión de plan alimenticio',
            estado: 'Pendiente'
        },
        {
            id: 7,
            paciente: 'Ana Torres',
            profesionalId: 2,
            fecha: '2026-07-10',
            hora: '15:00',
            motivo: 'Ajuste de plan alimenticio',
            estado: 'Confirmada'
        },
        {
            id: 8,
            paciente: 'Miguel Herrera',
            profesionalId: 3,
            fecha: '2026-07-12',
            hora: '11:00',
            motivo: 'Control de salud general',
            estado: 'Pendiente'
        }
    ];
}

function convertirHoraTextoA24(horaTexto) {
    if (!horaTexto) return '';

    if (/^\d{2}:\d{2}$/.test(horaTexto)) {
        return horaTexto;
    }

    let partes = horaTexto.trim().split(' ');
    let horaParte = partes[0].split(':');
    let horas = parseInt(horaParte[0], 10);
    let minutos = horaParte[1] || '00';
    let periodo = (partes[1] || '').toUpperCase();

    if (periodo === 'PM' && horas < 12) {
        horas += 12;
    }

    if (periodo === 'AM' && horas === 12) {
        horas = 0;
    }

    return String(horas).padStart(2, '0') + ':' + minutos;
}

function formatearHoraParaPaciente(hora24) {
    if (!hora24) return '';

    let partes = hora24.split(':');
    let horas = parseInt(partes[0], 10);
    let minutos = partes[1] || '00';
    let periodo = horas >= 12 ? 'PM' : 'AM';

    if (horas > 12) {
        horas -= 12;
    }

    if (horas === 0) {
        horas = 12;
    }

    return horas + ':' + minutos + ' ' + periodo;
}

function normalizarEstadoProfesional(estado) {
    if (!estado) return 'Pendiente';

    let valor = estado.toLowerCase();

    if (valor === 'pendiente') return 'Pendiente';
    if (valor === 'confirmada') return 'Confirmada';
    if (valor === 'cancelada') return 'Cancelada';
    if (valor === 'asistida' || valor === 'completada') return 'Asistida';
    if (valor === 'no asistida') return 'No asistida';

    return estado;
}

function esEstadoPendientePaciente(estado) {
    let valor = normalizarEstadoProfesional(estado);
    return valor === 'Pendiente' || valor === 'Confirmada';
}

function esEstadoCompletadaPaciente(estado) {
    let valor = normalizarEstadoProfesional(estado);
    return valor === 'Asistida';
}

function normalizarCitaDesdePaciente(cita) {
    return {
        id: cita.id,
        paciente: cita.paciente || obtenerNombrePacienteActivo(),
        profesionalId: cita.profesionalId,
        fecha: cita.fecha,
        hora: convertirHoraTextoA24(cita.hora),
        motivo: cita.motivo || 'Consulta programada',
        estado: normalizarEstadoProfesional(cita.estado)
    };
}

function normalizarCitaDesdeGestion(cita) {
    return {
        id: cita.id,
        paciente: cita.paciente,
        profesionalId: cita.profesionalId,
        fecha: cita.fecha,
        hora: convertirHoraTextoA24(cita.hora),
        motivo: cita.motivo || 'Consulta programada',
        estado: normalizarEstadoProfesional(cita.estado)
    };
}

function fusionarCitas(listaBase, listaNueva) {
    let resultado = listaBase.slice();

    listaNueva.forEach(function (citaNueva) {
        let indice = resultado.findIndex(function (cita) {
            return cita.id === citaNueva.id;
        });

        if (indice === -1) {
            resultado.push(citaNueva);
        } else {
            resultado[indice] = citaNueva;
        }
    });

    return resultado;
}

function migrarCitasAntiguas() {
    let lista = obtenerCitasIniciales();

    let datosGestion = localStorage.getItem(CLAVE_CITAS_GESTION);
    if (datosGestion) {
        try {
            let citasGestion = JSON.parse(datosGestion).map(normalizarCitaDesdeGestion);
            lista = fusionarCitas(lista, citasGestion);
        } catch (error) {
        }
    }

    let datosPaciente = localStorage.getItem(CLAVE_CITAS_PACIENTE);
    if (datosPaciente) {
        try {
            let citasPaciente = JSON.parse(datosPaciente).map(normalizarCitaDesdePaciente);
            lista = fusionarCitas(lista, citasPaciente);
        } catch (error) {
        }
    }

    localStorage.removeItem(CLAVE_CITAS_GESTION);
    localStorage.removeItem(CLAVE_CITAS_PACIENTE);

    return lista;
}

function cargarCitas() {
    let lista = null;
    let datos = localStorage.getItem(CLAVE_CITAS);

    if (datos) {
        try {
            lista = JSON.parse(datos);

            if (lista.length > 0 && !lista[0].profesionalId) {
                lista = migrarCitasAntiguas();
            }
        } catch (error) {
            lista = migrarCitasAntiguas();
        }
    } else {
        lista = migrarCitasAntiguas();
    }

    let datosPaciente = localStorage.getItem(CLAVE_CITAS_PACIENTE);
    if (datosPaciente) {
        try {
            let citasPaciente = JSON.parse(datosPaciente).map(normalizarCitaDesdePaciente);
            lista = fusionarCitas(lista, citasPaciente);
            localStorage.removeItem(CLAVE_CITAS_PACIENTE);
        } catch (error) {
        }
    }

    let datosGestion = localStorage.getItem(CLAVE_CITAS_GESTION);
    if (datosGestion) {
        try {
            let citasGestion = JSON.parse(datosGestion).map(normalizarCitaDesdeGestion);
            lista = fusionarCitas(lista, citasGestion);
            localStorage.removeItem(CLAVE_CITAS_GESTION);
        } catch (error) {
        }
    }

    guardarCitas(lista);
    return lista;
}

function guardarCitas(listaCitas) {
    localStorage.setItem(CLAVE_CITAS, JSON.stringify(listaCitas));
}

function cargarCitasGestion() {
    return cargarCitas();
}

function guardarCitasGestion(listaCitas) {
    guardarCitas(listaCitas);
}

function obtenerSiguienteIdCita(listaCitas) {
    if (!listaCitas.length) return 1;

    return listaCitas.reduce(function (maximo, cita) {
        return cita.id > maximo ? cita.id : maximo;
    }, 0) + 1;
}

function obtenerNombrePacienteActivo() {
    if (typeof obtenerSesion === 'function') {
        let sesion = obtenerSesion();
        if (sesion && sesion.nombre) {
            return sesion.nombre;
        }
    }

    return 'Sofía Martínez';
}

function obtenerCitasDelPaciente(nombrePaciente) {
    let nombre = (nombrePaciente || obtenerNombrePacienteActivo()).toLowerCase();

    return cargarCitas().filter(function (cita) {
        return cita.paciente.toLowerCase() === nombre;
    });
}

function agregarCitaUnificada(datosCita) {
    let citasActuales = cargarCitas();
    let nuevaCita = {
        id: obtenerSiguienteIdCita(citasActuales),
        paciente: datosCita.paciente,
        profesionalId: datosCita.profesionalId,
        fecha: datosCita.fecha,
        hora: convertirHoraTextoA24(datosCita.hora),
        motivo: datosCita.motivo,
        estado: normalizarEstadoProfesional(datosCita.estado || 'Pendiente')
    };

    citasActuales.push(nuevaCita);
    guardarCitas(citasActuales);

    return nuevaCita;
}

function actualizarCitaUnificada(id, cambios) {
    let citasActuales = cargarCitas();
    let indice = citasActuales.findIndex(function (cita) {
        return cita.id === id;
    });

    if (indice === -1) return null;

    if (cambios.hora) {
        cambios.hora = convertirHoraTextoA24(cambios.hora);
    }

    if (cambios.estado) {
        cambios.estado = normalizarEstadoProfesional(cambios.estado);
    }

    citasActuales[indice] = Object.assign({}, citasActuales[indice], cambios);
    guardarCitas(citasActuales);

    return citasActuales[indice];
}

function cancelarCitaUnificada(id) {
    return actualizarCitaUnificada(id, { estado: 'Cancelada' });
}

function obtenerCitasGestionIniciales() {
    return obtenerCitasIniciales();
}

function obtenerProfesionalActivoId() {
    let guardado = sessionStorage.getItem(CLAVE_PROFESIONAL_ACTIVO);
    if (guardado) {
        return parseInt(guardado, 10);
    }

    if (typeof obtenerSesion === 'function') {
        let sesion = obtenerSesion();
        if (sesion && sesion.nombre) {
            let coincidencia = PROFESIONALES.find(function (prof) {
                return sesion.nombre.toLowerCase() === prof.nombre.toLowerCase();
            });
            if (coincidencia) {
                return coincidencia.id;
            }
        }
    }

    return 1;
}

function guardarProfesionalActivoId(id) {
    sessionStorage.setItem(CLAVE_PROFESIONAL_ACTIVO, id);
}

function llenarSelectProfesionales(selectId, incluirTodos) {
    let select = document.getElementById(selectId);
    if (!select) return;

    select.innerHTML = '';

    if (incluirTodos) {
        let opcionTodos = document.createElement('option');
        opcionTodos.value = '';
        opcionTodos.textContent = '-- Todos los profesionales --';
        select.appendChild(opcionTodos);
    } else {
        let opcionVacia = document.createElement('option');
        opcionVacia.value = '';
        opcionVacia.textContent = '-- Seleccionar profesional --';
        select.appendChild(opcionVacia);
    }

    PROFESIONALES.forEach(function (prof) {
        let opcion = document.createElement('option');
        opcion.value = String(prof.id);
        opcion.textContent = obtenerEtiquetaProfesional(prof);
        select.appendChild(opcion);
    });
}
