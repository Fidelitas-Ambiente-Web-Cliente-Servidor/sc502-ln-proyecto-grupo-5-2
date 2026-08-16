$(function () {
    const urlBase = "index.php";

    function cargarPacientes() {
        $.get(
            urlBase + '?option=listarPacientes',

            function (res) {
                const select = $('#selectPacientePlan');
                if (res.response !== '00') return;

                select.html('<option value="">-- Seleccionar --</option>');

                (res.pacientes || []).forEach(function (paciente) {
                    select.append(
                        $('<option></option>')
                            .attr('value', paciente.id_usuario)
                            .text(paciente.nombre_completo)
                    );
                });
            },

            'json'
        );
    }

    // Carga lista de planes

    function cargarPlanes() {
        $.get(urlBase + '?option=listarPlanes', function (res) {

            const $tabla = $('#tablaPlanes').empty();

            if (res.response !== '00' || !res.planes || res.planes.length === 0) {
                $tabla.html('<tr><td colspan="5" class="text-muted">No hay planes registrados.</td></tr>');
                return;
            }

            res.planes.forEach(function (plan) {

                const paciente = plan.nombre_completo || ('Paciente #' + plan.id_paciente);
                const vigencia = plan.fecha_inicio + ' — ' + (plan.fecha_fin || 'Indefinido');

                const $fila = $(`
                    <tr>
                        <td>${paciente}</td>
                        <td>${plan.calorias_diarias || '--'} kcal</td>
                        <td>${vigencia}</td>
                        <td id="comidas-plan-${plan.id_plan}" class="text-muted">Cargando...</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary agregar-comida" data-id="${plan.id_plan}">+ Comida</button>
                            <button class="btn btn-sm btn-danger eliminar-plan" data-id="${plan.id_plan}">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="fila-agregar-comida oculto" data-id-plan="${plan.id_plan}">
                        <td colspan="5">
                            <div class="d-flex gap-2 flex-wrap align-items-end p-2">
                                <div>
                                    <label class="form-label mb-0"><small>Día</small></label>
                                    <select class="form-select form-select-sm nueva-comida-dia">
                                        <option value="">Todos los días</option>
                                        <option value="Lunes">Lunes</option>
                                        <option value="Martes">Martes</option>
                                        <option value="Miércoles">Miércoles</option>
                                        <option value="Jueves">Jueves</option>
                                        <option value="Viernes">Viernes</option>
                                        <option value="Sábado">Sábado</option>
                                        <option value="Domingo">Domingo</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label mb-0"><small>Nombre</small></label>
                                    <input type="text" class="form-control form-control-sm nueva-comida-nombre" placeholder="Ej. Merienda">
                                </div>
                                <div>
                                    <label class="form-label mb-0"><small>Horario</small></label>
                                    <input type="time" class="form-control form-control-sm nueva-comida-horario">
                                </div>
                                <div style="min-width: 200px;">
                                    <label class="form-label mb-0"><small>Descripción</small></label>
                                    <input type="text" class="form-control form-control-sm nueva-comida-descripcion" placeholder="Alimentos...">
                                </div>
                                <button class="btn btn-sm btn-success guardar-comida" data-id="${plan.id_plan}">Guardar</button>
                            </div>
                            <div class="nueva-comida-mensaje text-danger px-2"></div>
                        </td>
                    </tr>
                `);

                $tabla.append($fila);
                cargarComidasDePlan(plan.id_plan);
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
                            alert('Error al eliminar: ' + (res.message || ''));
                        }
                    }, 'json');
                }
            });

            $('.agregar-comida').on('click', function () {
                const idPlan = $(this).data('id');
                $('.fila-agregar-comida[data-id-plan="' + idPlan + '"]').toggleClass('oculto');
            });

            $('.guardar-comida').on('click', function () {
                const idPlan = $(this).data('id');
                const $fila = $(this).closest('tr');

                $.post(urlBase, {
                    option: 'crearComida',
                    id_plan: idPlan,
                    dia_semana: $fila.find('.nueva-comida-dia').val(),
                    nombre_comida: $fila.find('.nueva-comida-nombre').val(),
                    horario: $fila.find('.nueva-comida-horario').val(),
                    descripcion_alimentos: $fila.find('.nueva-comida-descripcion').val()
                }, function (res) {
                    if (res.response === '00') {
                        $fila.addClass('oculto');
                        $fila.find('input').val('');
                        $fila.find('.nueva-comida-mensaje').text('');
                        cargarComidasDePlan(idPlan);
                    } else {
                        $fila.find('.nueva-comida-mensaje').text(res.message || 'No se pudo agregar la comida.');
                    }
                }, 'json');
            });

        }, 'json');
    }

    function cargarComidasDePlan(idPlan) {
        $.get(urlBase + '?option=listarComidas&id_plan=' + idPlan, function (res) {
            const $celda = $('#comidas-plan-' + idPlan);

            if (res.response !== '00' || !res.comidas || res.comidas.length === 0) {
                $celda.text('Sin comidas registradas');
                return;
            }

            const resumen = res.comidas.map(function (c) {
                return (c.dia_semana ? c.dia_semana + ': ' : '') + c.nombre_comida;
            }).join(', ');

            $celda.text(resumen);
        }, 'json');
    }

    function crearComidaBase(idPlan, dia, nombre, horario, descripcion) {
        return $.post(urlBase, {
            option: 'crearComida',
            id_plan: idPlan,
            dia_semana: dia,
            nombre_comida: nombre,
            horario: horario,
            descripcion_alimentos: descripcion
        }, null, 'json');
    }

    // Crea un plan nutricional

    $('#formPlanNutricional').on('submit', function (e) {
        e.preventDefault();

        $('#planMensaje').removeClass('text-danger').text('');

        const idPaciente = $('#selectPacientePlan').val();
        const calorias = $('#caloriasDiarias').val();
        const proteinas = $('#proteinasG').val();
        const carbohidratos = $('#carbohidratosG').val();
        const grasas = $('#grasasG').val();
        const agua = $('#aguaLitros').val();
        const fechaInicio = $('#fechaInicio').val();
        const fechaFin = $('#fechaFin').val();
        const recomendaciones = $('#recomendaciones').val();
        const dia = $('#comidaDia').val();
        const desayuno = $('#comidaDesayuno').val();
        const almuerzo = $('#comidaAlmuerzo').val();
        const cena = $('#comidaCena').val();

        if (!idPaciente) {
            $('#planMensaje').addClass('text-danger').text('Seleccione un paciente.');
            return;
        }

        $.post(urlBase, {
            option: 'crearPlan',
            id_paciente: idPaciente,
            calorias_diarias: calorias,
            proteinas_g: proteinas,
            carbohidratos_g: carbohidratos,
            grasas_g: grasas,
            agua_litros: agua,
            recomendaciones: recomendaciones,
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin
        }, function (res) {

            if (res.response !== '00') {
                $('#planMensaje').addClass('text-danger').text(res.message || 'No se pudo crear el plan.');
                return;
            }

            const idPlan = res.id_plan;

            if (!idPlan) {
                $('#planMensaje').addClass('text-danger').text(
                    'El plan se creó, pero no se pudieron agregar las comidas base (falta id_plan en la respuesta).'
                );
                cargarPlanes();
                return;
            }

            $.when(
                crearComidaBase(idPlan, dia, 'Desayuno', '08:00', desayuno),
                crearComidaBase(idPlan, dia, 'Almuerzo', '13:00', almuerzo),
                crearComidaBase(idPlan, dia, 'Cena', '19:00', cena)
            ).always(function () {
                $('#planMensaje').removeClass('text-danger').text('✅ Plan creado exitosamente.');
                $('#formPlanNutricional')[0].reset();
                cargarPlanes();
            });

        }, 'json');
    });

    cargarPacientes();
    cargarPlanes();
});