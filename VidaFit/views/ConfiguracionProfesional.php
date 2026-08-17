<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Configuración Profesional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/Configuracion.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/ConfiguracionProfesional.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="index.php?page=indexProfesional">
            <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
        </a>

        <nav>
            <a href="index.php?page=indexProfesional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="index.php?page=GestionarRutinas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutinas" width="30"> <b>Gestionar Rutinas</b></a>
            <a href="index.php?page=GestionarPlanes"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="30"> <b>Gestionar Planes Alimenticios</b></a>
            <a href="index.php?page=GestionPacientes"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Pacientes" width="30"> <b>Gestionar Pacientes</b></a>
            <a class="activo" href="index.php?page=ConfiguracionProfesional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Configuración" width="30"> <b>Configuración</b></a>
        </nav>

        <button class="logout" id="btnLogout">Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Configuración</b></h1>
                <p>Administre su perfil profesional en Vida Fit</p>
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

            <div class="panel panel-perfil-prof">
                <div class="titulo-panel">
                    <h3>Información personal</h3>
                    <button class="btn-editar-prof" id="btnEditar" onclick="toggleEdicion()">Editar perfil</button>
                </div>

                <div class="avatar-prof">
                    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Profesional" width="90">
                </div>

                <div class="campo-config">
                    <label>Nombre completo</label>
                    <span class="error-config" id="errorNombre"></span>
                    <input type="text" id="nombreCompletoInput" value="">
                </div>

                <div class="campo-config">
                    <label>Correo electrónico</label>
                    <span class="error-config" id="errorCorreo"></span>
                    <input type="email" id="correoUsuarioInput" value="">
                </div>

                <div class="campo-config">
                    <label>Especialidad</label>
                    <input type="text" value="Nutricionista" disabled>
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

                <div class="subtitulo-seccion">Cambiar contraseña
            </div>

            <div class="campo-config">
                <label>Contraseña actual</label>
                <span class="error-config" id="errorActual"></span>

                <div class="password-container">
                    <input type="password" id="passActual" placeholder="Tu contraseña actual">
                    <span class="eye-icon" onclick="togglePass('passActual')"> 
                        <img
                            src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/view.png"
                            alt="Mostrar contraseña"
                            class="password-icon">
                    </span>
                </div>
            </div>


            <div class="campo-config">
                <label>Nueva contraseña</label>
                <span class="error-config" id="errorNueva"></span>

                <div class="password-container">
                    <input type="password" id="nuevaContrasenna" placeholder="Mínimo 8 caracteres">
                    <span class="eye-icon" onclick="togglePass('nuevaContrasenna')">
                        <img
                            src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/view.png"
                            alt="Mostrar contraseña"
                            class="password-icon"> </span>
                </div>
            </div>


            <div class="campo-config">
                <label>Confirmar contraseña</label>
                <span class="error-config" id="errorConfirmar"></span>

                <div class="password-container">
                    <input type="password" id="confirmarContrasenna" placeholder="Repite la nueva contraseña">
                    <span class="eye-icon" onclick="togglePass('confirmarContrasenna')"> 
                        <img
                            src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/view.png"
                            alt="Mostrar contraseña"
                            class="password-icon"> </span>
                </div>
            </div>

            <div id="mensajePass" class="mensaje-exito"></div>

            <button type="button" class="btn-principal" onclick="cambiarContrasena()"> Actualizar contraseña</button>
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/ConfiguracionProfesional.js"></script>
</body>

</html>