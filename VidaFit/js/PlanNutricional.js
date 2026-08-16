$(function () {
    const urlBase = 'index.php';

    let comidasPorDia = {};

    function cargarPlan() {
        $.get(urlBase + '?option=obtenerPlanActual', function (res) {
            if (res.response !== '00' || !res.plan) {
                mostrarSinPlan();
                return;
            }

            renderTarjetas(res.plan);
            cargarComidas(res.plan.id_plan);
        }, 'json').fail(function () {
            $('#diasPlan').html('<p class="text-muted">No se pudo cargar tu plan nutricional. Intenta recargar la página.</p>');
        });
    }

    function mostrarSinPlan() {
        $('#valCalorias, #valProteinas, #valCarbohidratos, #valGrasas, #valAgua').text('--');
        $('#textoRecomendaciones').text('Aún no tienes un plan nutricional asignado.');
        $('#diasPlan').html('<p class="text-muted">Aún no tienes un plan nutricional asignado.</p>');
        $('#panelPlan').empty();
    }

    function renderTarjetas(plan) {
        $('#valCalorias').text(plan.calorias_diarias ? plan.calorias_diarias + ' kcal' : '--');
        $('#valProteinas').text(plan.proteinas_g ? plan.proteinas_g + 'g' : '--');
        $('#valCarbohidratos').text(plan.carbohidratos_g ? plan.carbohidratos_g + 'g' : '--');
        $('#valGrasas').text(plan.grasas_g ? plan.grasas_g + 'g' : '--');
        $('#valAgua').text(plan.agua_litros ? plan.agua_litros + ' L' : '--');
        $('#textoRecomendaciones').text(plan.recomendaciones || 'Sin recomendaciones registradas.');
    }

    function cargarComidas(id_plan) {
        $.get(urlBase + '?option=listarComidas&id_plan=' + id_plan, function (res) {
            if (res.response !== '00' || !res.comidas || res.comidas.length === 0) {
                $('#diasPlan').html('<p class="text-muted">Tu profesional aún no ha registrado comidas en este plan.</p>');
                $('#panelPlan').empty();
                return;
            }

            comidasPorDia = {};
            res.comidas.forEach(function (comida) {
                const dia = comida.dia_semana || 'Todos los días';
                if (!comidasPorDia[dia]) comidasPorDia[dia] = [];
                comidasPorDia[dia].push(comida);
            });

            renderTabsDias();
        }, 'json').fail(function () {
            $('#diasPlan').html('<p class="text-muted">No se pudieron cargar las comidas de tu plan.</p>');
        });
    }

    function renderTabsDias() {
        const $dias = $('#diasPlan').empty();
        const nombresDias = Object.keys(comidasPorDia);

        nombresDias.forEach(function (dia, i) {
            const $btn = $(`
                <button class="btn-dias${i === 0 ? ' activo-dia' : ''}" data-dia="${dia}">
                    <div><h3>${dia}</h3></div>
                </button>
            `);

            $btn.on('click', function () {
                $('.btn-dias').removeClass('activo-dia');
                $btn.addClass('activo-dia');
                renderComidasDia(dia);
            });

            $dias.append($btn);
        });

        renderComidasDia(nombresDias[0]);
    }

    function renderComidasDia(dia) {
        const $panel = $('#panelPlan').empty();
        const comidas = comidasPorDia[dia] || [];

        const $bloque = $(`
            <div class="panel plan" style="display: block;">
                <div class="titulo-panel"><h3>${dia}</h3></div>
            </div>
        `);

        if (comidas.length === 0) {
            $bloque.append('<p class="text-muted" style="padding: 0 16px 16px;">No hay comidas registradas para este día.</p>');
        }

        comidas.forEach(function (comida) {
            const $item = $(`
                <div class="comida" style="display: block; padding: 14px 16px; margin: 0 16px 12px; border: 1px solid #e2e2e2; border-radius: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 6px;">
                        <h4 style="margin: 0;">${comida.nombre_comida}</h4>
                        ${comida.horario ? '<small style="color: #888;">' + comida.horario + '</small>' : ''}
                    </div>
                    <p style="margin: 8px 0 0;">${comida.descripcion_alimentos || ''}</p>
                </div>
            `);
            $bloque.append($item);
        });

        $panel.append($bloque);
    }

    cargarPlan();
});