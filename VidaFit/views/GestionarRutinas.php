<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Gestionar Rutinas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/GestionarRutinas.css" />
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
            <a class="activo" href="index.php?page=GestionarRutinas">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutinas" width="30"> <b>Gestionar Rutinas</b>
            </a>
            <a href="index.php?page=GestionarPlanes">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="30"> <b>Gestionar Planes Alimenticios</b>
            </a>
            <a href="index.php?page=GestionPacientes">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Pacientes" width="30"> <b>Gestionar Pacientes</b>
            </a>
            <a href="index.php?page=ConfiguracionProfesional">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Configuración" width="30"> <b>Configuración</b>
            </a>
        </nav>

         <button class="logout" id="btnLogout" >Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Gestionar Rutinas</b></h1>
                <p>Administre rutinas, asigne ejercicios y gestione pacientes</p>
            </div>

            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b class="nombreCompletoUsuario"></b></h4>
                    <p id="rolUsuario"></p>
                </div>
            </div>
        </header>

        <section class="grid-gestion">

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Crear Nueva Rutina</h3>
                </div>
                <form id="formCrearRutina">
                    <div class="campo-asignar">
                        <label>Paciente</label>
                        <select id="idPacienteRutina" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                        </select>
                    </div>
                    <div class="campo-asignar">
                        <label>Frecuencia (días/semana)</label>
                        <input type="number" id="frecuenciaSemanal" class="form-control" min="1" max="7" required>
                    </div>
                    <div class="campo-asignar">
                        <label>Duración total (minutos)</label>
                        <input type="number" id="duracionTotal" class="form-control" min="1">
                    </div>
                    <button type="submit" class="btn-principal">Crear Rutina</button>
                    <div id="mensajeRutina" class="mensaje-exito"></div>
                </form>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Agregar Ejercicio al Catálogo</h3>
                </div>
                <form id="formCrearEjercicio">
                    <div class="campo-asignar">
                        <label>Nombre del ejercicio</label>
                        <input type="text" id="nuevoEjercicioNombre" class="form-control" required>
                    </div>
                    <div class="campo-asignar">
                        <label>Descripción</label>
                        <input type="text" id="nuevoEjercicioDescripcion" class="form-control">
                    </div>
                    <button type="submit" class="btn-principal">Agregar al Catálogo</button>
                    <div id="mensajeEjercicio" class="mensaje-exito"></div>
                </form>
            </div>

            <div class="panel" style="grid-column: span 3;">
                <div class="titulo-panel">
                    <h3>Rutinas Registradas</h3>
                </div>
                <div id="listaRutinas"></div>
            </div>

        </section>

   
        <div class="modal fade" id="modalEjercicios" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Gestionar Ejercicios de la Rutina</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idRutinaActual">
                        
                        <h6>Ejercicios asignados</h6>
                        <ul id="listaEjerciciosRutina" class="list-group mb-3"></ul>

                        <hr>
                        <h6>Agregar nuevo ejercicio</h6>
                        <form id="formAgregarEjercicio">
                            <div class="mb-2">
                                <label>Ejercicio</label>
                                <select id="selectEjercicio" class="form-select" required></select>
                            </div>
                            <div class="mb-2">
                                <label>Día / sesión (ej: Día 1, Cardio)</label>
                                <input type="text" id="ejercicioDia" class="form-control" placeholder="Día 1" required>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Series</label>
                                    <input type="number" id="ejercicioSeries" class="form-control" min="1" required>
                                </div>
                                <div class="col">
                                    <label>Repeticiones</label>
                                    <input type="number" id="ejercicioRepeticiones" class="form-control" min="1" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label>Descanso (segundos)</label>
                                    <input type="number" id="ejercicioDescanso" class="form-control" min="1">
                                </div>
                                <div class="col">
                                    <label>Nivel de dificultad</label>
                                    <select id="ejercicioNivel" class="form-select">
                                        <option value="">-- Sin especificar --</option>
                                        <option value="Principiante">Principiante</option>
                                        <option value="Intermedio">Intermedio</option>
                                        <option value="Avanzado">Avanzado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <label>Calorías quemadas (estimado)</label>
                                <input type="number" id="ejercicioCalorias" class="form-control" min="1">
                            </div>
                            <button type="submit" class="btn btn-success mt-2">Agregar ejercicio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/cuentas.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/gestionRutinas.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
</body>

</html>