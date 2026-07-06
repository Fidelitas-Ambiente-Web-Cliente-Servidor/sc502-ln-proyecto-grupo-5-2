let pacientes = [
    { id: 1, nombre: "Sofía Martínez", historial: "Antecedentes de hipertensión leve", condiciones: "Diabetes Tipo 2", alergias: "Glúten", discapacidades: "Ninguna", observaciones: "Requiere control estricto de carbohidratos" },
    { id: 2, nombre: "Luis Ramírez", historial: "Sedentarismo prolongado", condiciones: "Obesidad Grado I", alergias: "Ninguna", discapacidades: "Ninguna", observaciones: "Priorizar ejercicios de bajo impacto inicialmente" },
    { id: 3, nombre: "Ana Torres", historial: "Control nutricional preventivo", condiciones: "Ninguna", alergias: "Mariscos", discapacidades: "Ninguna", observaciones: "Atleta amateur, busca optimizar rendimiento" }
];

document.addEventListener("DOMContentLoaded", () => {
    renderizarTabla();

    document.getElementById("formExpediente").addEventListener("submit", (e) => {
        e.preventDefault();
        guardarExpediente();
    });
});

function renderizarTabla() {
    const tabla = document.getElementById("tablaPacientes");
    tabla.innerHTML = "";

    pacientes.forEach(p => {
        const fila = document.createElement("tr");
        fila.innerHTML = `
            <td><b>${p.nombre}</b><br><small class="text-muted">ID Expediente: #00${p.id}</small></td>
            <td><span class="badge bg-danger text-wrap">${p.condiciones}</span></td>
            <td><span class="badge bg-warning text-dark text-wrap">${p.alergias}</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editarPacientes(${p.id})">Editar</button>
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarPacientes(${p.id})">Eliminar</button>
            </td>
        `;
        tabla.appendChild(fila);
    });
}

function guardarExpediente() {
    const id = document.getElementById("expedienteId").value;
    const nombre = document.getElementById("nombrePaciente").value;
    const historial = document.getElementById("historialMedico").value;
    const condiciones = document.getElementById("condicionesMedicas").value;
    const alergias = document.getElementById("alergias").value;
    const discapacidades = document.getElementById("discapacidades").value;
    const observaciones = document.getElementById("observaciones").value;

    if (id) {
        let p = pacientes.find(item => item.id == id);
        if (p) {
            p.nombre = nombre;
            p.historial = historial;
            p.condiciones = condiciones;
            p.alergias = alergias;
            p.discapacidades = discapacidades;
            p.observaciones = observaciones;
        }
    } else {
        const nuevoId = pacientes.length > 0 ? Math.max(...pacientes.map(item => item.id)) + 1 : 1;
        pacientes.push({
            id: nuevoId,
            nombre,
            historial,
            condiciones,
            alergias,
            discapacidades,
            observaciones
        });
    }

    resetearFormulario();
    renderizarTabla();
}

function editarPacientes(id) {
    const p = pacientes.find(item => item.id == id);
    if (!p) return;

    document.getElementById("expedienteId").value = p.id;
    document.getElementById("nombrePaciente").value = p.nombre;
    document.getElementById("historialMedico").value = p.historial;
    document.getElementById("condicionesMedicas").value = p.condiciones;
    document.getElementById("alergias").value = p.alergias;
    document.getElementById("discapacidades").value = p.discapacidades;
    document.getElementById("observaciones").value = p.observaciones;

    document.getElementById("formTitulo").innerText = "Modificar Expediente";
    document.getElementById("btnGuardar").innerText = "Actualizar Cambios";
    document.getElementById("btnCancelar").classList.remove("oculto");
}

function eliminarPacientes(id) {
    if (confirm("¿Está seguro de que desea eliminar permanentemente este expediente clínico?")) {
        pacientes = pacientes.filter(item => item.id !== id);
        renderizarTabla();
        resetearFormulario();
    }
}

function resetearFormulario() {
    document.getElementById("formExpediente").reset();
    document.getElementById("expedienteId").value = "";
    document.getElementById("formTitulo").innerText = "Registrar Expediente";
    document.getElementById("btnGuardar").innerText = "Guardar Expediente";
    document.getElementById("btnCancelar").classList.add("oculto");
}