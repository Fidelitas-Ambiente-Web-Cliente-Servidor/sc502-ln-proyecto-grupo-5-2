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
/*
function registrarPeso() {
    let inputPeso = document.getElementById('nuevoPeso');
    let inputFecha = document.getElementById('fechaPeso');
    let errorDiv = document.getElementById('errorPeso');

    errorDiv.textContent = '';

    let peso = parseFloat(inputPeso.value);
    let fecha = inputFecha.value;

    if (isNaN(peso) || peso < 30 || peso > 300) {
        errorDiv.textContent = 'Ingrese un peso válido entre 30 y 300 kg.';
        return;
    }

    if (fecha === '') {
        errorDiv.textContent = 'Seleccione una fecha.';
        return;
    }

    registrosPeso.push({ fecha: fecha, peso: peso });

    registrosPeso.sort(function (a, b) {
        if (a.fecha < b.fecha) return -1;
        if (a.fecha > b.fecha) return 1;
        return 0;
    });

    inputPeso.value = '';
    inputFecha.value = '';

    dibujarGrafico();
    renderListaRegistros();
}

function renderListaRegistros() {
    let lista = document.getElementById('listaRegistros');
    lista.innerHTML = '';

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
*/
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

    errorDiv.style.color = 'var(--primary)';
    errorDiv.textContent = '✓ Medida de ' + select.value + ' (' + valor + ' cm) registrada.';

    select.value = '';
    input.value = '';

    setTimeout(function () {
        errorDiv.style.color = '';
        errorDiv.textContent = '';
    }, 3000);
}


document.addEventListener('DOMContentLoaded', function () {
    dibujarGrafico();

});

window.addEventListener('resize', function () {
    dibujarGrafico();
});