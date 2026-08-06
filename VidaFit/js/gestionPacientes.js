$(function () {
    const urlBase = "index.php";

    // Carga la lista
    function cargarExpedientes() {
        $.get(urlBase + '?option=listarExpedientes', function (res) {
            const data = JSON.parse(res);
            const $tbody = $('#tablaPacientes').empty();

            if (!data.expedientes || data.expedientes.length === 0) {
                $tbody.html('<tr><td colspan="4" class="text-center text-muted">No hay expedientes registrados.</td></tr>');
                return;
            }

            data.expedientes.forEach(function (exp) {
                const fila = `
                    <tr>
                        <td><b>${exp.nombre_completo}</b><br><small class="text-muted">ID Expediente: #00${exp.id_expediente}</small></td>
                        <td><span class="badge bg-danger text-wrap">${exp.condiciones_medicas}</span></td>
                        <td><span class="badge bg-warning text-dark text-wrap">${exp.alergias}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1 editar-exp" data-id="${exp.id_expediente}">Editar</button>
                            <button class="btn btn-sm btn-outline-danger eliminar-exp" data-id="${exp.id_expediente}">Eliminar</button>
                        </td>
                    </tr>
                `;
                $tbody.append(fila);
            });

            $('.editar-exp').on('click', function () {
                const id = $(this).data('id');
                editarExpediente(id);
            });

            $('.eliminar-exp').on('click', function () {
                const id = $(this).data('id');
                if (confirm('¿Está seguro de eliminar este expediente?')) {
                    eliminarExpediente(id);
                }
            });
        }, 'json');
    }

    // Crea o actualiza el expediente
    $('#formExpediente').on('submit', function (e) {
        e.preventDefault();
        const id = $('#expedienteId').val();
        const option = id ? 'actualizarExpediente' : 'crearExpediente';

        $.post(urlBase, {
            option: option,
            expedienteId: id,
            id_paciente: $('#idPaciente').val(),
            historial_medico: $('#historialMedico').val(),
            condiciones_medicas: $('#condicionesMedicas').val(),
            alergias: $('#alergias').val(),
            discapacidades: $('#discapacidades').val(),
            observaciones: $('#observaciones').val()
        }, function (res) {
            if (res.response === '00') {
                alert(id ? 'Expediente actualizado.' : 'Expediente creado.');
                resetearFormulario();
                cargarExpedientes();
            } else {
                alert('Error: ' + res.message);
            }
        }, 'json');
    });

    // Edita el expediente
    function editarExpediente(id) {
        $.get(urlBase + '?option=obtenerExpediente&id=' + id, function (res) {
            const data = JSON.parse(res);
            if (data.response !== '00' || !data.expediente) {
                alert('Error al cargar el expediente.');
                return;
            }
            const exp = data.expediente;
            $('#expedienteId').val(exp.id_expediente);
            $('#idPaciente').val(exp.id_paciente);
            $('#historialMedico').val(exp.historial_medico);
            $('#condicionesMedicas').val(exp.condiciones_medicas);
            $('#alergias').val(exp.alergias);
            $('#discapacidades').val(exp.discapacidades);
            $('#observaciones').val(exp.observaciones);

            $('#formTitulo').text('Modificar Expediente');
            $('#btnGuardar').text('Actualizar Cambios');
            $('#btnCancelar').removeClass('oculto');
        }, 'json');
    }

    // Elimina el expediente
    function eliminarExpediente(id) {
        $.post(urlBase, {
            option: 'eliminarExpediente',
            id_expediente: id
        }, function (res) {
            if (res.response === '00') {
                cargarExpedientes();
            } else {
                alert('Error al eliminar.');
            }
        }, 'json');
    }

    // Resetea el formulario
    function resetearFormulario() {
        $('#formExpediente')[0].reset();
        $('#expedienteId').val('');
        $('#formTitulo').text('Registrar Expediente');
        $('#btnGuardar').text('Guardar Expediente');
        $('#btnCancelar').addClass('oculto');
    }

    cargarExpedientes();
});