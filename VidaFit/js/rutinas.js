$(function () {
    const urlBase = 'index.php';

    let detallesPorDia = {};
    let diaActivo = null;

    function cargarRutina() {
        $.get(urlBase + '?option=listarRutinas', function (res) {
            if (res.response !== '00' || !res.rutinas || res.rutinas.length === 0) {
                mostrarSinRutina();
                return;
            }
            const rutina = res.rutinas[0];

            $('#valDuracion').text(rutina.duracion_total ? rutina.duracion_total : 'Sin dato');
            $('#valFrecuencia').text(rutina.frecuencia_semanal);

            cargarDetalles(rutina.id_rutina);
        }, 'json').fail(function () {
            $('#diasRutina').html('<p class="text-muted">No se pudo cargar tu rutina. Intenta recargar la página.</p>');
        });
    }

    function mostrarSinRutina() {
        $('#valDuracion').text('--');
        $('#valFrecuencia').text('--');
        $('#valCalorias').text('--');
        $('#valNivel').text('--');
        $('#diasRutina').html('<p class="text-muted">Aún no tienes una rutina asignada.</p>');
        $('#panelRutina').empty();
    }

    function cargarDetalles(id_rutina) {
        $.get(urlBase + '?option=listarDetalles&id_rutina=' + id_rutina, function (res) {
            if (res.response !== '00' || !res.detalles || res.detalles.length === 0) {
                mostrarSinRutina();
                return;
            }

            // Agrupa los ejercicios por día/sesión (dia_rutina), en el orden
            // en que aparecen (que ya viene ordenado por id_detalle).
            detallesPorDia = {};
            res.detalles.forEach(function (detalle) {
                const dia = detalle.dia_rutina || 'Sin día asignado';
                if (!detallesPorDia[dia]) detallesPorDia[dia] = [];
                detallesPorDia[dia].push(detalle);
            });

            renderTabsDias();
        }, 'json').fail(function () {
            $('#diasRutina').html('<p class="text-muted">No se pudieron cargar los ejercicios de tu rutina.</p>');
        });
    }

    function renderTabsDias() {
        const $dias = $('#diasRutina').empty();
        const nombresDias = Object.keys(detallesPorDia);

        nombresDias.forEach(function (dia, i) {
            const $btn = $(`
                <button class="btn-dias${i === 0 ? ' activo-dia' : ''}" data-dia="${dia}">
                    <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/mancuerna.png" alt="Día"></div>
                    <div><h3>${dia}</h3></div>
                </button>
            `);

            $btn.on('click', function () {
                $('.btn-dias').removeClass('activo-dia');
                $btn.addClass('activo-dia');
                seleccionarDia(dia);
            });

            $dias.append($btn);
        });

        diaActivo = nombresDias[0];
        seleccionarDia(diaActivo);
    }

    function seleccionarDia(dia) {
        diaActivo = dia;
        const detalles = detallesPorDia[dia] || [];

        renderTabla(dia, detalles);
        renderResumen(detalles);
    }

    // Con nivel/calorías guardados por ejercicio (no por día completo), se
    // resume el día sumando las calorías y mostrando el nivel más frecuente
    // entre sus ejercicios.
    function renderResumen(detalles) {
        const totalCalorias = detalles.reduce(function (suma, d) {
            return suma + (parseInt(d.calorias_por_sesion) || 0);
        }, 0);

        $('#valCalorias').text(totalCalorias > 0 ? totalCalorias : '--');

        const conteoNiveles = {};
        detalles.forEach(function (d) {
            if (d.nivel_dificultad) {
                conteoNiveles[d.nivel_dificultad] = (conteoNiveles[d.nivel_dificultad] || 0) + 1;
            }
        });

        const niveles = Object.keys(conteoNiveles);
        if (niveles.length === 0) {
            $('#valNivel').text('--');
        } else if (niveles.length === 1) {
            $('#valNivel').text(niveles[0]);
        } else {
            niveles.sort(function (a, b) { return conteoNiveles[b] - conteoNiveles[a]; });
            $('#valNivel').text(niveles[0] + ' (variado)');
        }
    }

    function renderTabla(dia, detalles) {
        const $panel = $('#panelRutina').empty();

        const $bloque = $(`
            <div class="panel plan">
                <div class="titulo-panel">
                    <div><h3>${dia}</h3></div>
                </div>
                <div class="encabezado-rutina">
                    <strong>#</strong>
                    <strong>Ejercicio</strong>
                    <strong>Descripción</strong>
                    <strong>Series</strong>
                    <strong>Repeticiones</strong>
                    <strong>Descanso</strong>
                </div>
            </div>
        `);

        detalles.forEach(function (detalle, i) {
            const $fila = $(`
                <div class="fila-ejercicio">
                    <div class="numero">${i + 1}</div>
                    <div class="nombre-ejercicio"><h4>${detalle.nombre_ejercicio}</h4></div>
                    <p>${detalle.descripcion || ''}</p>
                    <div class="dato">${detalle.series}</div>
                    <div class="dato">${detalle.repeticiones}</div>
                    <div class="dato">${detalle.descanso_segundos ? detalle.descanso_segundos + ' s' : '--'}</div>
                </div>
            `);

            $bloque.append($fila);
        });

        $panel.append($bloque);
    }

    cargarRutina();
});