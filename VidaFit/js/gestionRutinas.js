$(function () {
    const urlBase = "index.php";

    // Carga la lista de rutinas
    function cargarRutinas() {
        $.get(urlBase + '?option=listarRutinas', function (res) {
            const data = JSON.parse(res);
            const $contenedor = $('#listaRutinas').empty();

            if (!data.rutinas || data.rutinas.length === 0) {
                $contenedor.html('<p class="text-muted">No hay rutinas registradas.</p>');
                return;
            }

            data.rutinas.forEach(function (rutina) {
                const card = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Rutina #${rutina.id_rutina}</h5>
                            <p><strong>Paciente:</strong> ${rutina.nombre_completo}</p>
                            <p><strong>Frecuencia:</strong> ${rutina.frecuencia_semanal} días/semana</p>
                            <p><strong>Duración:</strong> ${rutina.duracion_total || 'No especificada'} min</p>
                            <button class="btn btn-sm btn-info ver-ejercicios" data-id="${rutina.id_rutina}">Ver / Gestionar Ejercicios</button>
                            <button class="btn btn-sm btn-danger eliminar-rutina" data-id="${rutina.id_rutina}">Eliminar</button>
                        </div>
                    </div>
                `;
                $contenedor.append(card);
            });

            $('.ver-ejercicios').on('click', function () {
                const idRutina = $(this).data('id');
                $('#idRutinaActual').val(idRutina);
                cargarEjerciciosDisponibles();
                cargarDetallesRutina(idRutina);
                $('#modalEjercicios').modal('show');
            });

            $('.eliminar-rutina').on('click', function () {
                if (confirm('¿Eliminar esta rutina? (se eliminarán sus ejercicios)')) {
                    const idRutina = $(this).data('id');
                    $.post(urlBase, {
                        option: 'eliminarRutina',
                        id_rutina: idRutina
                    }, function (res) {
                        if (res.response === '00') {
                            cargarRutinas();
                        } else {
                            alert('Error al eliminar.');
                        }
                    }, 'json');
                }
            });
        }, 'json');
    }

    // Crea una rutina
    $('#formCrearRutina').on('submit', function (e) {
        e.preventDefault();

        $.post(urlBase, {
            option: 'crearRutina',
            id_profesional: 1, // Temporal (Dr. Carlos Mendoza)
            id_paciente: $('#idPacienteRutina').val(),
            frecuencia_semanal: $('#frecuenciaSemanal').val(),
            duracion_total: $('#duracionTotal').val()
        }, function (res) {
            if (res.response === '00') {
                $('#mensajeRutina').text('✅ Rutina #' + res.id_rutina + ' creada.');
                $('#formCrearRutina')[0].reset();
                cargarRutinas();
            } else {
                $('#mensajeRutina').text('❌ ' + res.message).css('color', 'red');
            }
        }, 'json');
    });

    // Carga ejercicios disponibles
    function cargarEjerciciosDisponibles() {
        $.get(urlBase + '?option=listarEjercicios', function (res) {
            const data = JSON.parse(res);
            const $select = $('#selectEjercicio').empty().append('<option value="">-- Seleccionar --</option>');

            if (data.ejercicios) {
                data.ejercicios.forEach(function (ej) {
                    $select.append(`<option value="${ej.id_ejercicio}">${ej.nombre_ejercicio}</option>`);
                });
            }
        }, 'json');
    }

    // Carga detalles de una rutina
    function cargarDetallesRutina(idRutina) {
        $.get(urlBase + '?option=listarDetalles&id_rutina=' + idRutina, function (res) {
            const data = JSON.parse(res);
            const $lista = $('#listaEjerciciosRutina').empty();

            if (!data.detalles || data.detalles.length === 0) {
                $lista.html('<li class="list-group-item text-muted">Sin ejercicios asignados.</li>');
                return;
            }

            data.detalles.forEach(function (det) {
                const item = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${det.nombre_ejercicio}</strong><br>
                            <small>${det.series} series × ${det.repeticiones} repeticiones</small>
                        </div>
                        <button class="btn btn-sm btn-danger eliminar-detalle" data-id="${det.id_detalle}">✕</button>
                    </li>
                `;
                $lista.append(item);
            });

            $('.eliminar-detalle').on('click', function () {
                if (confirm('Eliminar este ejercicio de la rutina?')) {
                    const idDetalle = $(this).data('id');
                    $.post(urlBase, {
                        option: 'eliminarDetalle',
                        id_detalle: idDetalle
                    }, function (res) {
                        if (res.response === '00') {
                            cargarDetallesRutina($('#idRutinaActual').val());
                        } else {
                            alert('Error al eliminar.');
                        }
                    }, 'json');
                }
            });
        }, 'json');
    }

    // Agrega un ejercicio a la rutina
    $('#formAgregarEjercicio').on('submit', function (e) {
        e.preventDefault();

        $.post(urlBase, {
            option: 'crearDetalle',
            id_rutina: $('#idRutinaActual').val(),
            id_ejercicio: $('#selectEjercicio').val(),
            series: $('#ejercicioSeries').val(),
            repeticiones: $('#ejercicioRepeticiones').val()
        }, function (res) {
            if (res.response === '00') {
                $('#formAgregarEjercicio')[0].reset();
                cargarDetallesRutina($('#idRutinaActual').val());
            } else {
                alert('Error al agregar: ' + res.message);
            }
        }, 'json');
    });

    // Carga al inicio
    cargarRutinas();
});