// miProgreso.js — Pagina Mi Progreso

// Datos iniciales de ejemplo para el grafico de peso
let registrosPeso = [
    { fecha: '2025-05-20', peso: 72.1 },
    { fecha: '2025-05-27', peso: 71.7 },
    { fecha: '2025-06-03', peso: 71.0 },
    { fecha: '2025-06-10', peso: 70.3 },
    { fecha: '2025-06-17', peso: 69.9 },
    { fecha: '2025-06-24', peso: 69.1 },
    { fecha: '2025-06-28', peso: 69.0 }
];

// Logros
let logros = [
    { icono: '🥇', titulo: 'Primera semana', descripcion: 'Completaste tu primera semana en Vida Fit', desbloqueado: true },
    { icono: '⚖️', titulo: 'Primer kilo', descripcion: 'Perdiste tu primer kilogramo', desbloqueado: true },
    { icono: '💪', titulo: '5 rutinas', descripcion: 'Completaste 5 rutinas de ejercicio', desbloqueado: true },
    { icono: '🥗', titulo: 'Plan completo', descripcion: 'Marcaste un plan nutricional como completado', desbloqueado: true },
    { icono: '🏆', titulo: 'Meta a la mitad', descripcion: 'Alcanzaste el 50% de tu meta de peso', desbloqueado: false },
    { icono: '🎯', titulo: 'Meta lograda', descripcion: 'Alcanzaste tu peso objetivo', desbloqueado: false }
];

let periodoActual = 'mes';

// Dibuja el grafico de peso en el cuadro
function dibujarGrafico() {
    const canvas = document.getElementById('graficoPeso');
    const ctx = canvas.getContext('2d');

    canvas.width = canvas.offsetWidth;
    canvas.height = 260;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Decide que datos mostrar segun el periodo
    let datos = registrosPeso;
    if (periodoActual === 'mes') {
        datos = registrosPeso.slice(-7);
    }

    if (datos.length === 0) return;

    const padding = 45;
    const ancho = canvas.width - padding * 2;
    const alto = canvas.height - padding * 2;

    // Encuentra el min y max para escalar el eje Y
    let pesoMax = datos[0].peso;
    let pesoMin = datos[0].peso;
    datos.forEach(function (r) {
        if (r.peso > pesoMax) pesoMax = r.peso;
        if (r.peso < pesoMin) pesoMin = r.peso;
    });
    // Agrega un margen para que la linea no quede pegada a los bordes
    pesoMax = pesoMax + 1;
    pesoMin = pesoMin - 1;

    // Dibuja lineas de cuadrícula
    ctx.strokeStyle = '#e1e5ea';
    ctx.lineWidth = 1;
    for (let i = 0; i <= 4; i++) {
        let y = padding + i * (alto / 4);
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(canvas.width - padding, y);
        ctx.stroke();
    }

    // Dibuja la linea de progreso
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

    // Dibuja los puntos sobre la línea
    datos.forEach(function (registro, i) {
        let x = padding + i * (ancho / (datos.length - 1));
        let y = padding + ((pesoMax - registro.peso) / (pesoMax - pesoMin)) * alto;

        ctx.fillStyle = '#009688';
        ctx.beginPath();
        ctx.arc(x, y, 6, 0, Math.PI * 2);
        ctx.fill();

        // Etiqueta con el peso encima del punto
        ctx.fillStyle = '#1F2937';
        ctx.font = '12px Arial';
        ctx.fillText(registro.peso + ' kg', x - 18, y - 12);
    });

    ctx.fillStyle = '#5d6880';
    ctx.font = '11px Arial';
    datos.forEach(function (registro, i) {
        let x = padding + i * (ancho / (datos.length - 1));
        // Formatea la fecha de yyyy-mm-dd a dd/mm
        let partes = registro.fecha.split('-');
        let etiqueta = partes[2] + '/' + partes[1];
        ctx.fillText(etiqueta, x - 14, canvas.height - 10);
    });
}

// Cambia el periodo mostrado en el grafico
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

// Registra un nuevo peso
function registrarPeso() {
    let inputPeso = document.getElementById('nuevoPeso');
    let inputFecha = document.getElementById('fechaPeso');
    let errorDiv = document.getElementById('errorPeso');

    errorDiv.textContent = '';

    let peso = parseFloat(inputPeso.value);
    let fecha = inputFecha.value;

    // Validaciones
    if (isNaN(peso) || peso < 30 || peso > 300) {
        errorDiv.textContent = 'Ingrese un peso válido entre 30 y 300 kg.';
        return;
    }

    if (fecha === '') {
        errorDiv.textContent = 'Seleccione una fecha.';
        return;
    }

    // Agrega el registro al array
    registrosPeso.push({ fecha: fecha, peso: peso });

    // Ordena el array por fecha (usando comparacion de strings, que funciona con formato yyyy-mm-dd)
    registrosPeso.sort(function (a, b) {
        if (a.fecha < b.fecha) return -1;
        if (a.fecha > b.fecha) return 1;
        return 0;
    });

    // Limpia los inputs
    inputPeso.value = '';
    inputFecha.value = '';

    // Redibuja el grafico y la lista
    dibujarGrafico();
    renderListaRegistros();
}

// Genera la lista de registros recientes
function renderListaRegistros() {
    let lista = document.getElementById('listaRegistros');
    lista.innerHTML = '';

    // Muestra los ultimos 5 registros, del mas reciente al mas antiguo
    let recientes = registrosPeso.slice(-5).reverse();

    recientes.forEach(function (r) {
        let div = document.createElement('div');
        div.className = 'registro-peso';

        let partes = r.fecha.split('-');
        let fechaLegible = partes[2] + '/' + partes[1] + '/' + partes[0];

        let spanFecha = document.createElement('span');
        spanFecha.className = 'reg-fecha';
        spanFecha.textContent = fechaLegible;

        let spanValor = document.createElement('span');
        spanValor.className = 'reg-valor';
        spanValor.textContent = r.peso + ' kg';

        div.appendChild(spanFecha);
        div.appendChild(spanValor);
        lista.appendChild(div);
    });
}

// Registra una nueva medida
function registrarMedida() {
    let select = document.getElementById('selectMedida');
    let input = document.getElementById('valorMedida');
    let errorDiv = document.getElementById('errorMedida');

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

    // Confirmacion visual en el mismo div de error (positivo)
    errorDiv.style.color = 'var(--primary)';
    errorDiv.textContent = '✓ Medida de ' + select.value + ' (' + valor + ' cm) registrada.';

    select.value = '';
    input.value = '';

    // Restaura el color de error despues de 3 segundos
    setTimeout(function () {
        errorDiv.style.color = '';
        errorDiv.textContent = '';
    }, 3000);
}

// Genera la lista de logros
function renderLogros() {
    let lista = document.getElementById('listaLogros');
    lista.innerHTML = '';

    logros.forEach(function (logro) {
        let div = document.createElement('div');
        div.className = 'logro-item';

        let iconoDiv = document.createElement('div');
        iconoDiv.className = 'logro-icono';
        if (!logro.desbloqueado) {
            iconoDiv.classList.add('bloqueado');
        }
        iconoDiv.textContent = logro.icono;

        let textoDiv = document.createElement('div');
        textoDiv.className = 'logro-texto';

        let h4 = document.createElement('h4');
        h4.textContent = logro.titulo;
        if (!logro.desbloqueado) {
            h4.textContent = '🔒 ' + logro.titulo;
        }

        let p = document.createElement('p');
        p.textContent = logro.descripcion;

        textoDiv.appendChild(h4);
        textoDiv.appendChild(p);

        div.appendChild(iconoDiv);
        div.appendChild(textoDiv);
        lista.appendChild(div);
    });
}

// Inicializacion cuando el DOM carga
document.addEventListener('DOMContentLoaded', function () {
    dibujarGrafico();
    renderListaRegistros();
    renderLogros();
});

// Redibuja el grafico si cambia el tamanno de la ventana
window.addEventListener('resize', function () {
    dibujarGrafico();
});