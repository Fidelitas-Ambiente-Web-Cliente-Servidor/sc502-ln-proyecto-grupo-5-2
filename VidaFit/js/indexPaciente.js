

const canvas = document.getElementById("graficoPeso");
const ctx = canvas.getContext("2d");
let rutinaIniciada = false;

canvas.width = canvas.offsetWidth;
canvas.height = 260;

const datos = [72.1, 71.7, 71.0, 70.3, 69.9, 69.1, 68.6];
const etiquetas = ["20 May", "27 May", "3 Jun", "10 Jun", "17 Jun"];

function dibujarGrafico() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  const padding = 45;
  const ancho = canvas.width - padding * 2;
  const alto = canvas.height - padding * 2;

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
    let x = padding + i * (ancho / (datos.length - 1));
    let y = padding + ((74 - peso) / (74 - 66)) * alto;

    if (i === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }
  });

  ctx.stroke();

  datos.forEach((peso, i) => {
    let x = padding + i * (ancho / (datos.length - 1));
    let y = padding + ((74 - peso) / (74 - 66)) * alto;

    ctx.fillStyle = "#009688";
    ctx.beginPath();
    ctx.arc(x, y, 6, 0, Math.PI * 2);
    ctx.fill();
  });

  ctx.fillStyle = "#5d6880";
  ctx.font = "13px Segoe UI";

  etiquetas.forEach((texto, i) => {
    let x = padding + i * (ancho / (etiquetas.length - 1));
    ctx.fillText(texto, x - 20, canvas.height - 15);
  });
}

function completarPlan(boton) {
  boton.innerHTML = "✅ Plan completado";
  boton.setAttribute("onclick", "finalizarRutina(this)");
  boton.disabled = true;
}


function manejarRutina(boton) {
  if (!rutinaIniciada) {
    rutinaIniciada = true;
    boton.innerHTML = "⏹ Finalizar rutina";
    boton.classList.add("rutina-iniciada");
  } else {
    boton.innerHTML = "✅ Rutina finalizada";
    boton.classList.remove("rutina-iniciada");
    boton.disabled = true;
  }
}

dibujarGrafico();

window.addEventListener("resize", () => {
  canvas.width = canvas.offsetWidth;
  dibujarGrafico();
});

