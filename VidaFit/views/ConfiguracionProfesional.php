<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Configuración Profesional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/indexPaciente.css" />
    <link rel="stylesheet" href="../css/Configuracion.css" />
    <link rel="stylesheet" href="../css/ConfiguracionProfesional.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="indexProfesional.html">
            <img src="img/logo.png" alt="Vida Fit" width="230">
        </a>

        <nav>
            <a href="indexProfesional.html"><img src="../img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="GestionarRutinas.html"><img src="../img/ejercicio.png" alt="Rutinas" width="30"> <b>Gestionar Rutinas</b></a>
            <a><img src="../img/plan.png" alt="Planes" width="30"> <b>Gestionar Planes Alimenticios</b></a>
            <a><img src="../img/perfil.png" alt="Pacientes" width="30"> <b>Gestionar Pacientes</b></a>
            <a class="activo" href="ConfiguracionProfesional.html"><img src="../img/configuracion.png" alt="Configuración" width="30"> <b>Configuración</b></a>
        </nav>

        <button class="logout" onclick="cerrarSesion()">Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Configuración</b></h1>
                <p>Administre su perfil profesional en Vida Fit</p>
            </div>
            <div class="usuario">
                <img src="../img/usuario.png" alt="Usuario">
                <div>
                    <h4 id="nombreHeader"><b>Dr. Carlos Mendoza</b></h4>
                    <p>Profesional de la Salud</p>
                </div>
            </div>
        </header>

        <section class="grid-config-prof">

            <div class="panel panel-perfil-prof">
                <div class="titulo-panel">
                    <h3>Información personal</h3>
                    <button class="btn-editar-prof" id="btnEditar" onclick="toggleEdicion()">Editar perfil</button>
                </div>

                <div class="avatar-prof">
                    <img src="../img/usuario.png" alt="Profesional" width="90">
                </div>

                <div class="campo-config">
                    <label>Nombre completo</label>
                    <span class="error-config" id="errorNombre"></span>
                    <input type="text" id="campoNombre" value="Dr. Carlos Mendoza" disabled>
                </div>

                <div class="campo-config">
                    <label>Correo electrónico</label>
                    <span class="error-config" id="errorCorreo"></span>
                    <input type="email" id="campoCorreo" value="carlos.mendoza@vidafit.com" disabled>
                </div>

                <div class="campo-config">
                    <label>Teléfono</label>
                    <span class="error-config" id="errorTelefono"></span>
                    <input type="tel" id="campoTelefono" value="8888-4521" disabled>
                </div>

                <div class="campo-config">
                    <label>Especialidad</label>
                    <span class="error-config" id="errorEspecialidad"></span>
                    <select id="campoEspecialidad" disabled>
                        <option value="Nutricionista clínico" selected>Nutricionista clínico</option>
                        <option value="Médico general">Médico general</option>
                        <option value="Endocrinólogo">Endocrinólogo</option>
                        <option value="Fisioterapeuta">Fisioterapeuta</option>
                        <option value="Psicólogo de la salud">Psicólogo de la salud</option>
                    </select>
                </div>

                <div id="mensajePerfil" class="mensaje-exito"></div>

                <div id="botonesEdicion" class="botones-edicion oculto">
                    <button class="btn-principal" onclick="guardarPerfil()">Guardar cambios</button>
                    <button class="btn-secundario" onclick="cancelarEdicion()">Cancelar</button>
                </div>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Seguridad</h3>
                </div>

                <div class="subtitulo-seccion">Cambiar contraseña</div>

                <div class="campo-config">
                    <label>Contraseña actual</label>
                    <span class="error-config" id="errorActual"></span>
                    <div class="password-container">
                        <input type="password" id="passActual" placeholder="Tu contraseña actual">
                        <span class="eye-icon" onclick="togglePass('passActual')">👁️</span>
                    </div>
                </div>

                <div class="campo-config">
                    <label>Nueva contraseña</label>
                    <span class="error-config" id="errorNueva"></span>
                    <div class="password-container">
                        <input type="password" id="passNueva" placeholder="Mínimo 8 caracteres">
                        <span class="eye-icon" onclick="togglePass('passNueva')">👁️</span>
                    </div>
                </div>

                <div class="campo-config">
                    <label>Confirmar contraseña</label>
                    <span class="error-config" id="errorConfirmar"></span>
                    <div class="password-container">
                        <input type="password" id="passConfirmar" placeholder="Repite la nueva contraseña">
                        <span class="eye-icon" onclick="togglePass('passConfirmar')">👁️</span>
                    </div>
                </div>

                <div id="mensajePass" class="mensaje-exito"></div>
                <button class="btn-principal" onclick="cambiarContrasena()">Actualizar contraseña</button>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Preferencias</h3>
                </div>

                <div class="config-fila">
                    <div class="config-info">
                        <h4>Notificaciones de citas</h4>
                        <p>Recibir alertas de citas próximas con pacientes</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="notifCitas" checked onchange="guardarPreferencias()">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="config-fila">
                    <div class="config-info">
                        <h4>Alertas de pacientes</h4>
                        <p>Notificaciones cuando un paciente actualice su progreso</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="notifPacientes" checked onchange="guardarPreferencias()">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="config-fila">
                    <div class="config-info">
                        <h4>Recordatorios de rutinas</h4>
                        <p>Avisos de rutinas pendientes por asignar</p>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="notifRutinas" onchange="guardarPreferencias()">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="campo-config" style="margin-top: 18px;">
                    <label>Idioma</label>
                    <select id="idioma" onchange="guardarPreferencias()">
                        <option value="es" selected>Español</option>
                        <option value="en">English</option>
                    </select>
                </div>

                <div id="mensajeConfig" class="mensaje-exito"></div>

                <button class="btn-secundario" style="margin-top: 12px;" onclick="cerrarSesion()">Cerrar sesión</button>
            </div>

        </section>

        <footer>
            <div class="container text-center">
                <p><b>© 2026 Vida Fit | Todos los derechos reservados.</b></p>
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
                    <img src="../img/facebook.png" class="imagen-footer" alt="Facebook">
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
                    <img src="../img/instagram.png" class="imagen-footer" alt="Instagram">
                </a>
                <a href="https://x.com" target="_blank" rel="noopener noreferrer">
                    <img src="../img/x.png" class="imagen-footer" alt="X">
                </a>
                <a href="https://whatsapp.com" target="_blank" rel="noopener noreferrer">
                    <img src="../img/whatsapp.png" class="imagen-footer" alt="Whatsapp">
                </a>
            </div>
        </footer>

    </main>

    <script src="../js/cuentas.js"></script>
    <script src="../js/sesion.js"></script>
    <script src="../js/ConfiguracionProfesional.js"></script>
</body>

</html>
