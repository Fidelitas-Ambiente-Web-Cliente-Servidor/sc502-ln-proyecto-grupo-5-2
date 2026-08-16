$(function () {

    const urlBase = "index.php";

    let datos = [];
    let etiquetas = [];

    const canvas = document.getElementById("graficoPeso");
    const ctx = canvas.getContext("2d");

    canvas.width = canvas.offsetWidth;
    canvas.height = 260;


    function formatearFecha(fechaIso) {

        if (!fechaIso) return '';

        const partes = fechaIso.split('-');
        const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        return `${parseInt(partes[2], 10)} ${meses[parseInt(partes[1], 10) - 1]}`;
    }


    function dibujarGrafico() {

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (datos.length === 0) {

            ctx.fillStyle = "#5d6880";
            ctx.font = "14px Segoe UI";
            ctx.fillText("Aún no tienes registros de progreso.", 20, canvas.height / 2);

            return;
        }

        const padding = 45;
        const ancho = canvas.width - padding * 2;
        const alto = canvas.height - padding * 2;

        const max = Math.max(...datos) + 2;
        const min = Math.min(...datos) - 2;

        ctx.strokeStyle = "#e1e5ea";
        ctx.lineWidth = 1;

        for (let i = 0; i <= 4; i++) {
            let y = padding + i * (alto / 4);
            ctx.beginPath();
            ctx.moveTo(padding, y);
            ctx.lineTo(canvas.width - padding, y);
            ctx.stroke();
        }

        ctx.strokeStyle = "#009688";
        ctx.lineWidth = 3;
        ctx.beginPath();

        datos.forEach((peso, i) => {
            let x = padding + i * (ancho / Math.max(datos.length - 1, 1));
            let y = padding + ((max - peso) / (max - min)) * alto;

            if (i === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });

        ctx.stroke();

        datos.forEach((peso, i) => {
            let x = padding + i * (ancho / Math.max(datos.length - 1, 1));
            let y = padding + ((max - peso) / (max - min)) * alto;

            ctx.fillStyle = "#009688";
            ctx.beginPath();
            ctx.arc(x, y, 6, 0, Math.PI * 2);
            ctx.fill();
        });

        ctx.fillStyle = "#5d6880";
        ctx.font = "13px Segoe UI";

        etiquetas.forEach((texto, i) => {
            let x = padding + i * (ancho / Math.max(etiquetas.length - 1, 1));
            ctx.fillText(texto, x - 20, canvas.height - 15);
        });
    }


    function cargarProgresoActual() {

        $.get(
            urlBase + '?option=obtenerProgresoActual',

            function (res) {

                if (res.response !== '00' || !res.registro) {

                    $('#pesoActualValor').html('-- <span>kg</span>');
                    $('#imcValor').text('--');
                    $('#imcEstado').text('Sin registros aún');

                    return;
                }

                const registro = res.registro;

                $('#pesoActualValor').html(
                    parseFloat(registro.peso_kg).toFixed(1) + ' <span>kg</span>'
                );

                $('#imcValor').text(
                    registro.imc !== null ? parseFloat(registro.imc).toFixed(1) : '--'
                );

                $('#imcEstado').text(
                    registro.estado_nutricional || ''
                );
            },

            'json'
        );
    }


    function cargarProximaCita() {

        $.get(
            urlBase + '?option=obtenerProximaCita',

            function (res) {

                if (res.response !== '00' || !res.cita) {

                    $('#citaFecha').text('Sin citas');
                    $('#citaProfesional').text('');
                    $('#citaHora').text('');

                    return;
                }

                const cita = res.cita;

                $('#citaFecha').text(formatearFecha(cita.fecha));
                $('#citaProfesional').text(cita.nombre_profesional || '');
                $('#citaHora').text(cita.hora ? cita.hora.substring(0, 5) : '');
            },

            'json'
        );
    }


    function cargarHistoricoProgreso() {

        $.get(
            urlBase + '?option=listarProgreso',

            function (res) {

                if (res.response !== '00' || !res.registros || res.registros.length === 0) {
                    dibujarGrafico();
                    return;
                }

                // Los registros vienen del más reciente al más antiguo; para el
                // gráfico los queremos del más antiguo al más reciente.
                const registros = res.registros.slice(0, 7).reverse();

                datos = registros.map(r => parseFloat(r.peso_kg));
                etiquetas = registros.map(r => formatearFecha(r.fecha_registro));

                dibujarGrafico();

                if (registros.length >= 2) {

                    const actual = parseFloat(registros[registros.length - 1].peso_kg);
                    const anterior = parseFloat(registros[registros.length - 2].peso_kg);
                    const diferencia = (actual - anterior).toFixed(1);

                    if (diferencia < 0) {
                        $('#pesoTendencia')
                            .removeClass('rojo').addClass('verde')
                            .text(`↓ ${Math.abs(diferencia)} kg desde tu último registro`);
                    } else if (diferencia > 0) {
                        $('#pesoTendencia')
                            .removeClass('verde').addClass('rojo')
                            .text(`↑ ${diferencia} kg desde tu último registro`);
                    } else {
                        $('#pesoTendencia').text('Sin cambios desde tu último registro');
                    }
                }
            },

            'json'
        );
    }


    function cargarPlanNutricional() {

        $.get(
            urlBase + '?option=listarPlanes',

            function (res) {

                const contenedor = $('#listaComidas');

                if (res.response !== '00' || !res.planes || res.planes.length === 0) {
                    contenedor.html('<p class="sin-datos">Aún no tienes un plan nutricional asignado.</p>');
                    return;
                }

                // elige el plan vigente

                const hoy = new Date().toISOString().slice(0, 10);

                let planActual = res.planes.find(function (p) {
                    return p.fecha_inicio <= hoy && (!p.fecha_fin || p.fecha_fin >= hoy);
                });

                if (!planActual) {
                    planActual = res.planes[0];
                }

                $.get(
                    urlBase + '?option=listarComidas&id_plan=' + planActual.id_plan,

                    function (resComidas) {

                        if (resComidas.response !== '00' || !resComidas.comidas || resComidas.comidas.length === 0) {
                            contenedor.html('<p class="sin-datos">Este plan todavía no tiene comidas registradas.</p>');
                            return;
                        }

                        contenedor.empty();

                        resComidas.comidas.forEach(function (comida) {

                            const bloque = $('<div class="comida"></div>');

                            const encabezado = $('<div></div>');
                            encabezado.append($('<h4></h4>').text(comida.nombre_comida));

                            if (comida.horario) {
                                encabezado.append($('<small></small>').text(comida.horario));
                            }

                            bloque.append(encabezado);
                            bloque.append($('<p></p>').text(comida.descripcion_alimentos));

                            contenedor.append(bloque);
                        });
                    },

                    'json'
                );
            },

            'json'
        );
    }


    function cargarRutina() {

        $.get(
            urlBase + '?option=listarRutinas',

            function (res) {

                const resumen = $('#rutinaResumen');
                const lista = $('#listaEjercicios');

                if (res.response !== '00' || !res.rutinas || res.rutinas.length === 0) {
                    resumen.empty();
                    lista.html('<p class="sin-datos">Aún no tienes una rutina asignada.</p>');
                    return;
                }

                // Se toma la rutina mas reciente asignada al paciente.
                const rutina = res.rutinas[0];

                resumen.html(
                    '<div class="rutina-header"><div><h4>Rutina asignada por ' +
                    (rutina.nombre_profesional || 'tu profesional') +
                    '</h4><small>' + rutina.frecuencia_semanal + ' veces por semana' +
                    (rutina.duracion_total ? ' • ' + rutina.duracion_total + ' min' : '') +
                    '</small></div></div>'
                );

                $.get(
                    urlBase + '?option=listarDetalles&id_rutina=' + rutina.id_rutina,

                    function (resDetalles) {

                        if (resDetalles.response !== '00' || !resDetalles.detalles || resDetalles.detalles.length === 0) {
                            lista.html('<p class="sin-datos">Esta rutina todavía no tiene ejercicios asignados.</p>');
                            return;
                        }

                        lista.empty();

                        resDetalles.detalles.forEach(function (detalle) {
                            const fila = $('<div class="ejercicio"></div>');
                            fila.text(detalle.nombre_ejercicio + ' ');
                            fila.append(
                                $('<small></small>').text(
                                    detalle.series + ' series • ' + detalle.repeticiones + ' repeticiones'
                                )
                            );
                            lista.append(fila);
                        });
                    },

                    'json'
                );
            },

            'json'
        );
    }


    window.addEventListener("resize", () => {
        canvas.width = canvas.offsetWidth;
        dibujarGrafico();
    });


    cargarProgresoActual();
    cargarProximaCita();
    cargarHistoricoProgreso();
    cargarPlanNutricional();
    cargarRutina();

});