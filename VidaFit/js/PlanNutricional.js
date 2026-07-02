
function completarPlan(boton) {
    boton.innerHTML = "✅ Plan completado";
    boton.setAttribute("onclick", "finalizarRutina(this)");
    boton.disabled = true;
}


const botonesDias = document.querySelectorAll(".btn-dias");
const planes = document.querySelectorAll(".plan");

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
    if (plan.dataset.dia !== "lunes") {
        plan.classList.add("oculto");
    }
});