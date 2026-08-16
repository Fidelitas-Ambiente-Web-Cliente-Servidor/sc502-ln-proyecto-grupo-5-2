$(function () {
    const urlBase = 'index.php';

    const modalEjercicios = new bootstrap.Modal(document.getElementById('modalEjercicios'));

    // Carga los pacientes
    function cargarPacientes() {
        $.get(urlBase + '?option=listarPacientes', function (res) {
            const select = $('#idPacienteRutina');
            if (res.response !== '00') return;

            select.html('<option value="">-- Seleccionar --</option>');

            (res.pacientes || []).forEach(function (paciente) {
                select.append(
                    $('<option></option>')
                        .attr('value', paciente.id_usuario)
                        .text(paciente.nombre_completo)
                );
            });
        }, 'json');
    }

    // Carga el catalogo de ejercicios para el select del modal.
    function cargarEjerciciosCatalogo() {
        $.get(urlBase + '?option=listarEjercicios', function (res) {
            const select = $('#selectEjercicio');
            select.empty();

            if (res.response !== '00' || !res.ejercicios || res.ejercicios.length === 0) {
                select.append('<option value="">No hay ejercicios en el catálogo</option>');
                return;
            }

            res.ejercicios.forEach(function (ejercicio) {
                select.append(
                    $('<option></option>')
                        .attr('value', ejercicio.id_ejercicio)
                        .text(ejercicio.nombre_ejercicio)
                );
            });
        }, 'json');
    }

    // Carga y pinta las rutinas creadas por este profesional.
    function cargarRutinas() {
        $.get(urlBase + '?option=listarRutinas', function (res) {
            const $lista = $('#listaRutinas');
            $lista.empty();

            if (res.response !== '00' || !res.rutinas || res.rutinas.length === 0) {
                $lista.html('<p class="text-muted">No hay rutinas registradas.</p>');
                return;
            }

            res.rutinas.forEach(function (rutina) {
                const $card = $(`
                    <div class="rutina-card mb-3 p-3" style="border:1px solid #e1e5ea; border-radius:10px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <b>${rutina.nombre_paciente}</b>
                                <br>
                                <small class="text-muted">
                                    ${rutina.frecuencia_semanal} días/semana
                                    ${rutina.duracion_total ? ' · ' + rutina.duracion_total + ' min totales' : ''}
                                </small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary btn-gestionar-ejercicios" data-id="${rutina.id_rutina}">Gestionar ejercicios</button>
                                <button class="btn btn-sm btn-outline-danger btn-eliminar-rutina" data-id="${rutina.id_rutina}">Eliminar</button>
                            </div>
                        </div>
                    </div>
                `);

                $card.find('.btn-gestionar-ejercicios').on('click', function () {
                    abrirGestionEjercicios(rutina.id_rutina);
                });

                $card.find('.btn-eliminar-rutina').on('click', function () {
                    if (confirm('¿Está seguro de eliminar esta rutina?')) {
                        eliminarRutina(rutina.id_rutina);
                    }
                });

                $lista.append($card);
            });
        }, 'json');
    }

    function eliminarRutina(id_rutina) {
        $.post(urlBase, { option: 'eliminarRutina', id_rutina: id_rutina }, function (res) {
            if (res.response === '00') {
                cargarRutinas();
            } else {
                alert('Error al eliminar: ' + (res.message || ''));
            }
        }, 'json');
    }

    function abrirGestionEjercicios(id_rutina) {
        $('#idRutinaActual').val(id_rutina);
        $('#formAgregarEjercicio')[0].reset();
        cargarDetalles(id_rutina);
        modalEjercicios.show();
    }

    // Carga los ejercicios ya asignados a la rutina abierta en el modal.
    function cargarDetalles(id_rutina) {
        $.get(urlBase + '?option=listarDetalles&id_rutina=' + id_rutina, function (res) {
            const $lista = $('#listaEjerciciosRutina');
            $lista.empty();

            if (res.response !== '00' || !res.detalles || res.detalles.length === 0) {
                $lista.append('<li class="list-group-item text-muted">Aún no hay ejercicios asignados.</li>');
                return;
            }

            res.detalles.forEach(function (detalle) {
                const extras = [];
                if (detalle.descanso_segundos) extras.push(detalle.descanso_segundos + 's descanso');
                if (detalle.nivel_dificultad) extras.push(detalle.nivel_dificultad);
                if (detalle.calorias_por_sesion) extras.push(detalle.calorias_por_sesion + ' kcal');

                const $item = $(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <b>${detalle.dia_rutina || 'Sin día asignado'}</b> — ${detalle.nombre_ejercicio}
                            <br>
                            <small class="text-muted">${detalle.series} series x ${detalle.repeticiones} repeticiones${extras.length ? ' · ' + extras.join(' · ') : ''}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-detalle" data-id="${detalle.id_detalle}">Quitar</button>
                    </li>
                `);

                $item.find('.btn-eliminar-detalle').on('click', function () {
                    eliminarDetalle(detalle.id_detalle, id_rutina);
                });

                $lista.append($item);
            });
        }, 'json');
    }

    function eliminarDetalle(id_detalle, id_rutina) {
        $.post(urlBase, { option: 'eliminarDetalle', id_detalle: id_detalle }, function (res) {
            if (res.response === '00') {
                cargarDetalles(id_rutina);
            } else {
                alert('Error al quitar el ejercicio: ' + (res.message || ''));
            }
        }, 'json');
    }

    // Crea una rutina
    $('#formCrearRutina').on('submit', function (e) {
        e.preventDefault();
        $('#mensajeRutina').removeClass('text-danger').text('');

        const id_paciente = $('#idPacienteRutina').val();

        if (!id_paciente) {
            $('#mensajeRutina').addClass('text-danger').text('Seleccione un paciente.');
            return;
        }

        $.post(urlBase, {
            option: 'crearRutina',
            id_paciente: id_paciente,
            frecuencia_semanal: $('#frecuenciaSemanal').val(),
            duracion_total: $('#duracionTotal').val()
        }, function (res) {
            if (res.response === '00') {
                $('#mensajeRutina').removeClass('text-danger').text('✅ Rutina creada correctamente.');
                $('#formCrearRutina')[0].reset();
                cargarRutinas();
            } else {
                $('#mensajeRutina').addClass('text-danger').text(res.message || 'No se pudo crear la rutina.');
            }
        }, 'json');
    });

    // Agrega un ejercicio nuevo al catalogo

    $('#formCrearEjercicio').on('submit', function (e) {
        e.preventDefault();
        $('#mensajeEjercicio').removeClass('text-danger').text('');

        $.post(urlBase, {
            option: 'crearEjercicio',
            nombre_ejercicio: $('#nuevoEjercicioNombre').val(),
            descripcion: $('#nuevoEjercicioDescripcion').val(),
            video_url: $('#nuevoEjercicioVideo').val()
        }, function (res) {
            if (res.response === '00') {
                $('#mensajeEjercicio').removeClass('text-danger').text('✅ Ejercicio agregado al catálogo.');
                $('#formCrearEjercicio')[0].reset();
                cargarEjerciciosCatalogo();
            } else {
                $('#mensajeEjercicio').addClass('text-danger').text(res.message || 'No se pudo agregar el ejercicio.');
            }
        }, 'json');
    });

    // Agrega ejercicio a la rutina abierta en el modal
    
    $('#formAgregarEjercicio').on('submit', function (e) {
        e.preventDefault();

        const id_rutina = $('#idRutinaActual').val();

        $.post(urlBase, {
            option: 'crearDetalle',
            id_rutina: id_rutina,
            id_ejercicio: $('#selectEjercicio').val(),
            dia_rutina: $('#ejercicioDia').val(),
            series: $('#ejercicioSeries').val(),
            repeticiones: $('#ejercicioRepeticiones').val(),
            descanso_segundos: $('#ejercicioDescanso').val(),
            nivel_dificultad: $('#ejercicioNivel').val(),
            calorias_por_sesion: $('#ejercicioCalorias').val()
        }, function (res) {
            if (res.response === '00') {
                $('#formAgregarEjercicio')[0].reset();
                cargarDetalles(id_rutina);
            } else {
                alert(res.message || 'No se pudo agregar el ejercicio.');
            }
        }, 'json');
    });

    cargarPacientes();
    cargarEjerciciosCatalogo();
    cargarRutinas();
});