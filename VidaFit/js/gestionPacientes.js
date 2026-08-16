$(function () {
    const urlBase = "index.php";

    function cargarPacientes() {
        $.get(
            urlBase + '?option=listarPacientes',

            function (res) {
                const select = $('#idPaciente');
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

    // Carga la lista

    function cargarExpedientes() {
        $.get(urlBase + '?option=listarExpedientes', function (res) {
            const $tbody = $('#tablaPacientes').empty();

            if (res.response !== '00' || !res.expedientes || res.expedientes.length === 0) {
                $tbody.html('<tr><td colspan="4" class="text-center text-muted">No hay expedientes registrados.</td></tr>');
                return;
            }

            res.expedientes.forEach(function (exp) {
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
        $('#expedienteMensaje').removeClass('text-danger').text('');

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
                $('#expedienteMensaje').removeClass('text-danger').text(
                    id ? '✅ Expediente actualizado.' : '✅ Expediente creado.'
                );
                resetearFormulario();
                cargarExpedientes();
            } else {
                $('#expedienteMensaje').addClass('text-danger').text(res.message || 'No se pudo guardar el expediente.');
            }
        }, 'json');
    });

    function editarExpediente(id) {
        $.get(urlBase + '?option=obtenerExpediente&id=' + id, function (res) {
            if (res.response !== '00' || !res.expediente) {
                alert('Error al cargar el expediente.');
                return;
            }
            const exp = res.expediente;
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
                alert('Error al eliminar: ' + (res.message || ''));
            }
        }, 'json');
    }

    // Resetea el formulario
    window.resetearFormulario = function () {
        $('#formExpediente')[0].reset();
        $('#expedienteId').val('');
        $('#formTitulo').text('Registrar Expediente');
        $('#btnGuardar').text('Guardar Expediente');
        $('#btnCancelar').addClass('oculto');
        $('#expedienteMensaje').removeClass('text-danger').text('');
    };

    cargarPacientes();
    cargarExpedientes();
});