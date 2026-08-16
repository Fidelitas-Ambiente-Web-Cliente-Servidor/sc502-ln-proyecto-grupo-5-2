let registrosPeso = [];
let periodoActual = 'mes';

function establecerRegistrosPeso(registros) {

    registrosPeso = registros;

    dibujarGrafico();
}


function dibujarGrafico() {
    const canvas = document.getElementById('graficoPeso');
    const ctx = canvas.getContext('2d');

    canvas.width = canvas.offsetWidth;
    canvas.height = 260;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    let datos = registrosPeso;
    if (periodoActual === 'mes') {
        datos = registrosPeso.slice(-7);
    }

    if (datos.length === 0) return;

    const padding = 45;
    const ancho = canvas.width - padding * 2;
    const alto = canvas.height - padding * 2;

    let pesoMax = datos[0].peso;
    let pesoMin = datos[0].peso;
    datos.forEach(function (r) {
        if (r.peso > pesoMax) pesoMax = r.peso;
        if (r.peso < pesoMin) pesoMin = r.peso;
    });
    pesoMax = pesoMax + 1;
    pesoMin = pesoMin - 1;

    ctx.strokeStyle = '#e1e5ea';
    ctx.lineWidth = 1;
    for (let i = 0; i <= 4; i++) {
        let y = padding + i * (alto / 4);
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(canvas.width - padding, y);
        ctx.stroke();
    }

    ctx.strokeStyle = '#009688';
    ctx.lineWidth = 3;
    ctx.beginPath();

    datos.forEach(function (registro, i) {
        let x = padding + i * (ancho / (datos.length - 1));
        let y = padding + ((pesoMax - registro.peso) / (pesoMax - pesoMin)) * alto;
        if (i === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
    });
    ctx.stroke();

    datos.forEach(function (registro, i) {
        let x = padding + i * (ancho / (datos.length - 1));
        let y = padding + ((pesoMax - registro.peso) / (pesoMax - pesoMin)) * alto;

        ctx.fillStyle = '#009688';
        ctx.beginPath();
        ctx.arc(x, y, 6, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = '#1F2937';
        ctx.font = '12px Arial';
        ctx.fillText(registro.peso + ' kg', x - 18, y - 12);
    });

    ctx.fillStyle = '#5d6880';
    ctx.font = '11px Arial';
    datos.forEach(function (registro, i) {
        let x = padding + i * (ancho / (datos.length - 1));
        let partes = registro.fecha.split('-');
        let etiqueta = partes[2] + '/' + partes[1];
        ctx.fillText(etiqueta, x - 14, canvas.height - 10);
    });
}

function cambiarPeriodo() {
    let btn = document.getElementById('btnPeriodo');
    if (periodoActual === 'mes') {
        periodoActual = 'todo';
        btn.textContent = 'Todo el historial ⌄';
    } else {
        periodoActual = 'mes';
        btn.textContent = 'Último mes ⌄';
    }
    dibujarGrafico();
}
// Nombre de cada medida en el orden en que se muestran en el panel.

const ORDEN_MEDIDAS = ['Cintura', 'Cadera', 'Brazo', 'Muslo', 'Pecho'];

// Guarda y parsea medidas corporales

function parsearMedidas(texto) {
    let medidas = {};
    if (!texto) return medidas;

    texto.split(',').forEach(function (par) {
        let partes = par.split(':');
        if (partes.length === 2) {
            let tipo = partes[0].trim();
            let valor = parseFloat(partes[1]);
            if (tipo !== '' && !isNaN(valor)) {
                medidas[tipo] = valor;
            }
        }
    });

    return medidas;
}

// Dibuja el panel "Mis medidas" con los valores reales del paciente

function renderMedidas(medidas) {
    let contenedor = document.getElementById('listaMedidas');
    contenedor.innerHTML = '';

    let tipos = ORDEN_MEDIDAS.filter(function (tipo) {
        return medidas[tipo] !== undefined;
    });

    if (tipos.length === 0) {
        contenedor.innerHTML = '<p class="text-muted">Aún no hay medidas registradas.</p>';
        return;
    }

    tipos.forEach(function (tipo) {
        let valor = medidas[tipo];

        let ancho = Math.max(0, Math.min(100, (valor / 150) * 100));

        let fila = document.createElement('div');
        fila.className = 'medida-fila';
        fila.innerHTML =
            '<span class="medida-nombre">' + tipo + '</span>' +
            '<div class="medida-barra-wrap">' +
            '<div class="medida-barra">' +
            '<div class="medida-relleno" style="width: ' + ancho + '%"></div>' +
            '</div>' +
            '</div>' +
            '<span class="medida-valor">' + valor + ' cm</span>';

        contenedor.appendChild(fila);
    });
}

// Carga las medidas guardadas en el registro de progreso

function cargarMedidas() {
    $.get('index.php?option=obtenerProgresoActual', function (res) {
        if (res.response !== '00' || !res.registro) {
            renderMedidas({});
            return;
        }

        renderMedidas(parsearMedidas(res.registro.medidas_corporales));
    }, 'json');
}

// Envia la medida al backend (endpoint actualizarMedida)

function registrarMedida() {
    let select = document.getElementById('selectMedida');
    let input = document.getElementById('valorMedida');
    let errorDiv = document.getElementById('errorMedida');

    errorDiv.style.color = '';
    errorDiv.textContent = '';

    if (select.value === '') {
        errorDiv.textContent = 'Seleccione una medida.';
        return;
    }

    let valor = parseFloat(input.value);
    if (isNaN(valor) || valor < 1 || valor > 300) {
        errorDiv.textContent = 'Ingrese un valor válido en cm (entre 1 y 300).';
        return;
    }

    $.post('index.php', {
        option: 'actualizarMedida',
        tipo_medida: select.value,
        valor_cm: valor
    }, function (res) {
        if (res.response === '00') {
            errorDiv.style.color = 'var(--primary)';
            errorDiv.textContent = '✓ Medida de ' + select.value + ' (' + valor + ' cm) registrada.';

            select.value = '';
            input.value = '';

            renderMedidas(res.medidas || {});

            setTimeout(function () {
                errorDiv.style.color = '';
                errorDiv.textContent = '';
            }, 3000);
        } else {
            errorDiv.textContent = res.message || 'Error al registrar la medida.';
        }
    }, 'json');
}


document.addEventListener('DOMContentLoaded', function () {
    dibujarGrafico();
    cargarMedidas();
});

window.addEventListener('resize', function () {
    dibujarGrafico();
});