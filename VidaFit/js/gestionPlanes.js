$(function () {
    const urlBase = "index.php";

    // Cargar lista de planes
    function cargarPlanes() {
        $.get(urlBase + '?option=listarPlanes', function (res) {
            const data = JSON.parse(res);
            const $contenedor = $('#listaPlanes').empty();

            if (!data.planes || data.planes.length === 0) {
                $contenedor.html('<p class="text-muted">No hay planes registrados.</p>');
                return;
            }

            data.planes.forEach(function (plan) {
                const card = `
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Plan #${plan.id_plan}</h5>
                            <p><strong>Paciente ID:</strong> ${plan.id_paciente}</p>
                            <p><strong>Calorías:</strong> ${plan.calorias_diarias} kcal</p>
                            <p><strong>Recomendaciones:</strong> ${plan.recomendaciones}</p>
                            <p><strong>Vigencia:</strong> ${plan.fecha_inicio} - ${plan.fecha_fin || 'Indefinido'}</p>
                            <button class="btn btn-sm btn-info ver-comidas" data-id="${plan.id_plan}">Ver Comidas</button>
                            <button class="btn btn-sm btn-danger eliminar-plan" data-id="${plan.id_plan}">Eliminar</button>
                        </div>
                    </div>
                `;
                $contenedor.append(card);
            });

            $('.ver-comidas').on('click', function () {
                const idPlan = $(this).data('id');
                $('#idPlanActual').val(idPlan);
                cargarComidas(idPlan);
                $('#modalComidas').modal('show');
            });

            $('.eliminar-plan').on('click', function () {
                if (confirm('¿Eliminar este plan?')) {
                    const idPlan = $(this).data('id');
                    $.post(urlBase, {
                        option: 'eliminarPlan',
                        id_plan: idPlan
                    }, function (res) {
                        if (res.response === '00') {
                            cargarPlanes();
                        } else {
                            alert('Error al eliminar.');
                        }
                    }, 'json');
                }
            });
        }, 'json');
    }

    // Crear plan
    $('#formCrearPlan').on('submit', function (e) {
        e.preventDefault();

        $.post(urlBase, {
            option: 'crearPlan',
            id_profesional: $('#idProfesional').val(),
            id_paciente: $('#idPaciente').val(),
            calorias_diarias: $('#calorias').val(),
            recomendaciones: $('#recomendaciones').val(),
            fecha_inicio: $('#fechaInicio').val(),
            fecha_fin: $('#fechaFin').val()
        }, function (res) {
            if (res.response === '00') {
                $('#planSuccess').removeClass('d-none').text('Plan creado exitosamente');
                $('#formCrearPlan')[0].reset();
                cargarPlanes();
            } else {
                $('#planError').removeClass('d-none').text(res.message);
            }
        }, 'json');
    });

    // Cargar comidas de un plan
    function cargarComidas(idPlan) {
        $.get(urlBase + '?option=listarComidas&id_plan=' + idPlan, function (res) {
            const data = JSON.parse(res);
            const $lista = $('#listaComidasModal').empty();

            if (!data.comidas || data.comidas.length === 0) {
                $lista.html('<li class="list-group-item text-muted">Sin comidas asignadas.</li>');
                return;
            }

            data.comidas.forEach(function (comida) {
                const item = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${comida.nombre_comida}</strong> (${comida.horario || 'Sin hora'})<br>
                            <small>${comida.descripcion_alimentos}</small>
                        </div>
                        <button class="btn btn-sm btn-danger eliminar-comida" data-id="${comida.id_comida}">✕</button>
                    </li>
                `;
                $lista.append(item);
            });

            $('.eliminar-comida').on('click', function () {
                if (confirm('Eliminar esta comida?')) {
                    const idComida = $(this).data('id');
                    $.post(urlBase, {
                        option: 'eliminarComida',
                        id_comida: idComida
                    }, function (res) {
                        if (res.response === '00') {
                            cargarComidas($('#idPlanActual').val());
                        } else {
                            alert('Error al eliminar.');
                        }
                    }, 'json');
                }
            });
        }, 'json');
    }

    // Crear comida
    $('#formAgregarComida').on('submit', function (e) {
        e.preventDefault();

        $.post(urlBase, {
            option: 'crearComida',
            id_plan: $('#idPlanActual').val(),
            nombre_comida: $('#nombreComida').val(),
            horario: $('#horarioComida').val(),
            descripcion_alimentos: $('#descripcionComida').val()
        }, function (res) {
            if (res.response === '00') {
                $('#formAgregarComida')[0].reset();
                cargarComidas($('#idPlanActual').val());
            } else {
                alert('Error al agregar comida: ' + res.message);
            }
        }, 'json');
    });

    // Cargar al inicio
    cargarPlanes();
});