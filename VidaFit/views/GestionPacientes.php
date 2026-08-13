<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Gestión de Pacientes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexProfesional.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="index.php?page=indexProfesional">
            <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
        </a>

        <nav>
            <a href="index.php?page=indexProfesional">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b>
            </a>
            <a href="index.php?page=GestionarRutinas">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutinas" width="30"> <b>Gestionar Rutinas</b>
            </a>
            <a href="index.php?page=GestionarPlanes">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="30"> <b>Gestionar Planes Alimenticios</b>
            </a>
            <a class="activo" href="index.php?page=GestionPacientes">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Pacientes" width="30"> <b>Gestionar Pacientes</b>
            </a>
            <a href="index.php?page=ConfiguracionProfesional">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Configuración" width="30"> <b>Configuración</b>
            </a>
        </nav>

        <button class="logout" onclick="cerrarSesion()">Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Gestión de Pacientes</b></h1>
                <p>Administración de expedientes clínicos y consultas generales</p>
            </div>

            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b class="nombreCompletoUsuario"></b></h4>
                    <p id="rolUsuario"></p>
                </div>
            </div>
        </header>

        <section class="grid-config-prof">
            
            <div class="panel panel-perfil-prof" style="grid-column: span 2;">
                <div class="titulo-panel d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h3>Listado de Pacientes</h3>
                        <p class="subtitulo-panel">Expedientes registrados en el sistema</p>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle" style="font-family: var(--fuente);">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Condiciones Médicas</th>
                                <th>Alergias</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPacientes">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="titulo-panel mb-3">
                    <h3 id="formTitulo">Registrar Expediente</h3>
                    <p class="subtitulo-panel">Complete los datos clínicos obligatorios</p>
                </div>
                
                <form id="formExpediente">
                    <input type="hidden" id="expedienteId" value="">
                    
                    <div class="mb-3">
                        <label class="form-label"><b>ID del Paciente:</b></label>
                        <input type="number" id="idPaciente" class="form-control" placeholder="Ej. 4 (ID en BD)" required style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Historial Médico:</b></label>
                        <textarea id="historialMedico" class="form-control" rows="2" placeholder="Antecedentes familiares, cirugías..." style="border-radius: 10px;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Condiciones Médicas:</b></label>
                        <input type="text" id="condicionesMedicas" class="form-control" placeholder="Ej. Diabetes Tipo 2, Obesidad" required style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Alergias:</b></label>
                        <input type="text" id="alergias" class="form-control" placeholder="Ej. Glúten, Mariscos, Ninguna" style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Discapacidades:</b></label>
                        <input type="text" id="discapacidades" class="form-control" placeholder="Ej. Ninguna" style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Observaciones Adicionales:</b></label>
                        <textarea id="observaciones" class="form-control" rows="2" placeholder="Notas sobre el seguimiento..." style="border-radius: 10px;"></textarea>
                    </div>

                    <div class="botones-edicion">
                        <button type="submit" id="btnGuardar" class="btn-editar-prof" style="background-color: var(--primary); color: white; border: none; height: 45px; width: 100%;">Guardar Expediente</button>
                        <button type="button" id="btnCancelar" class="btn-editar-prof oculto" onclick="resetearFormulario()" style="height: 45px; width: 100%;">Cancelar Edición</button>
                    </div>
                </form>
            </div>

        </section>

        <footer>
            <div class="container text-center">
                <p><b>© 2026 Vida Fit | Todos los derechos reservados.</b></p>
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
                    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/facebook.png" class="imagen-footer" alt="Facebook">
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
                    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/instagram.png" class="imagen-footer" alt="Instagram">
                </a>
                <a href="https://x.com" target="_blank" rel="noopener noreferrer">
                    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/x.png" class="imagen-footer" alt="X">
                </a>
                <a href="https://whatsapp.com" target="_blank" rel="noopener noreferrer">
                    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/whatsapp.png" class="imagen-footer" alt="Whatsapp">
                </a>
            </div>
        </footer>

    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/cuentas.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/gestionPacientes.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
</body>

</html>