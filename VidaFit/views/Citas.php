<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Citas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/Citas.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="index.php?page=indexPaciente">
    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
</a>

        <nav>
            <a href="index.php?page=indexPaciente"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="index.php?page=PlanNutricional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Inicio" width="30"> <b>Mi Plan Nutricional</b></a>
            <a href="index.php?page=Rutinas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Inicio" width="30"> <b>Mi Rutina</b></a>
            <a href="index.php?page=Miprogreso"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/progreso.png" alt="Inicio" width="30"> <b>Mi Progreso</b></a>
            <a class="activo" href="index.php?page=Citas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Inicio" width="30"> <b>Citas</b></a>
            <a href="index.php?page=Perfil"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Inicio" width="30"><b>Perfil</b></a>
            <a href="index.php?page=Configuracion"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Inicio" width="30"> <b>Configuración</b></a>
        </nav>

        <button class="logout" id="btnLogout" >Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Mis Citas</b></h1>
                <p>Gestiona tus citas con profesionales de la salud</p>
            </div>
            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b class="nombreCompletoUsuario"></b></h4>
                    <p id="rolUsuario"></p>
                </div>
            </div>
        </header>

        <section class="cards-superiores">
            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Citas" width="35"></div>
                <div>
                    <p>Próxima cita</p>
                    <h2 id="proximaCitaFecha">Sin citas</h2>
                    <small id="proximaCitaHora"></small>
                </div>
            </div>

            <div class="card">
                <div class="icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Citas" width="35"></div>
                <div>
                    <p>Citas pendientes</p>
                    <h2 id="totalPendientes">0</h2>
                    <small>Este mes</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Citas" width="35"></div>
                <div>
                    <p>Citas completadas</p>
                    <h2 id="totalCompletadas">0</h2>
                    <small>En total</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario" width="35"></div>
                <div>
                    <p>Profesionales</p>
                    <h2 id="totalProfesionales">0</h2>
                    <small>Asignados</small>
                </div>
            </div>
        </section>

        <section class="grid-citas">

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Agendar nueva cita</h3>
                </div>

                <div class="campo-cita">
                    <label>Profesional</label>
                    <select id="profesional">
                        <option value="">-- Seleccionar profesional --</option>
                    </select>
                    <span class="error-cita" id="errorProfesional"></span>
                </div>

                <div class="campo-cita">
                    <label>Fecha</label>
                    <input type="date" id="fechaCita" />
                    <span class="error-cita" id="errorFecha"></span>
                </div>

                <div class="campo-cita">
                    <label>Hora</label>
                    <select id="horaCita">
                        <option value="">-- Seleccionar hora --</option>
                        <option value="08:00">8:00 AM</option>
                        <option value="09:00">9:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="14:00">2:00 PM</option>
                        <option value="15:00">3:00 PM</option>
                        <option value="16:00">4:00 PM</option>
                    </select>
                    <span class="error-cita" id="errorHora"></span>
                </div>

                <div class="campo-cita">
                    <label>Motivo de consulta</label>
                    <textarea id="motivoCita" rows="3" placeholder="Describe brevemente el motivo de tu cita..."></textarea>
                    <span class="error-cita" id="errorMotivo"></span>
                </div>

                <button class="btn-principal" onclick="agendarCita()">Agendar cita</button>
                <div id="mensajeCita" class="mensaje-exito"></div>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Mis citas</h3>
                    <div class="filtros-cita">
                        <button class="filtro-cita activo-cita" onclick="filtrarCitas('todas', this)">Todas</button>
                        <button class="filtro-cita" onclick="filtrarCitas('pendiente', this)">Pendientes</button>
                        <button class="filtro-cita" onclick="filtrarCitas('completada', this)">Completadas</button>
                    </div>
                </div>
                <div id="listaCitas"></div>
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/Citas.js"></script>
</body>

</html>