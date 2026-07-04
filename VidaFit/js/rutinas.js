const botonesDias = document.querySelectorAll(".btn-dias");
const planes = document.querySelectorAll(".plan");
let rutinaIniciada = false;

botonesDias.forEach((boton) => {
    boton.addEventListener("click", () => {
        const diaSeleccionado = boton.dataset.dia;

        planes.forEach((plan) => {
            if (plan.dataset.dia === diaSeleccionado) {
                plan.classList.remove("oculto");
            } else {
                plan.classList.add("oculto");
            }
        });

        botonesDias.forEach((btn) => {
            btn.classList.remove("activo-dia");
        });

        boton.classList.add("activo-dia");
    });
});

planes.forEach((plan) => {
    if (plan.dataset.dia !== "dia1") {
        plan.classList.add("oculto");
    }
});

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