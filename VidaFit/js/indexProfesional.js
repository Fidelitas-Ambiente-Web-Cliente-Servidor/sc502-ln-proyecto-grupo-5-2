$(function () {

    const urlBase = "index.php";

    function cargarEstadisticas() {
        $.get(urlBase + '?option=estadisticasProfesional', function (res) {

            if (res.response !== '00') {
                console.log('Error al cargar estadísticas:', res.message);
                return;
            }

            $('#valPacientesActivos').text(res.pacientesActivos);
            $('#valCitasHoy').text(res.citasHoy);
            $('#valRutinasAsignadas').text(res.rutinasAsignadas);
            $('#valPlanesActivos').text(res.planesActivos);

        }, 'json').fail(function () {
            $('#valPacientesActivos, #valCitasHoy, #valRutinasAsignadas, #valPlanesActivos').text('--');
        });
    }

    function cargarCitasProximas() {
        $.get(urlBase + '?option=listarCitasProfesional', function (res) {
            const $lista = $('#listaCitasProximas').empty();

            if (res.response !== '00' || !res.citas || res.citas.length === 0) {
                $lista.html('<p class="text-muted">No tiene citas registradas.</p>');
                return;
            }

            const hoy = new Date().toISOString().substring(0, 10);

            const proximas = res.citas
                .filter(function (cita) {
                    return cita.estado !== 'Cancelada' && cita.fecha >= hoy;
                })
                .sort(function (a, b) {
                    if (a.fecha !== b.fecha) return a.fecha < b.fecha ? -1 : 1;
                    if (a.hora !== b.hora) return a.hora < b.hora ? -1 : 1;
                    return 0;
                })
                .slice(0, 5);

            if (proximas.length === 0) {
                $lista.html('<p class="text-muted">No tiene citas próximas.</p>');
                return;
            }

            proximas.forEach(function (cita) {
                const partes = cita.fecha.substring(0, 10).split('-');
                const fechaLegible = partes[2] + '/' + partes[1] + '/' + partes[0];

                const $item = $(`
                    <div class="noti">
                        <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Cita" width="30"></span>
                        <p>${cita.nombre_paciente}<br><small>${fechaLegible} • ${cita.hora} • ${cita.estado}</small></p>
                    </div>
                `);

                $lista.append($item);
            });

        }, 'json').fail(function () {
            $('#listaCitasProximas').html('<p class="text-muted">No se pudieron cargar las citas.</p>');
        });
    }

    cargarEstadisticas();
    cargarCitasProximas();

});