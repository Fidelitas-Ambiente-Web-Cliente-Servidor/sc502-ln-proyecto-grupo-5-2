<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Perfil de Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/perfil.css" />
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
            <a href="index.php?page=Citas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Inicio" width="30"> <b>Citas</b></a>
            <a class="activo" href="index.php?page=Perfil"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Inicio" width="30"><b>Perfil</b></a>
            <a href="index.php?page=Configuracion"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Inicio" width="30"> <b>Configuración</b></a>
        </nav>


        <button class="logout" id="btnLogout" >Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Mi Perfil</b></h1>
                <p>Administra tu información personal</p>
            </div>
            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b class="nombreCompletoUsuario"></b></h4>
                    <p id="rolUsuario"></p>
                </div>
            </div>
        </header>

        <section class="grid-perfil">

            <div class="panel perfil-avatar-panel">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Avatar" class="perfil-foto">
                <h2 class="nombreCompletoUsuario"></h2>
                <p class="perfil-rol">Paciente</p>

                <div class="perfil-stats">
                    <div class="stat">
                        <h3>12</h3>
                        <small>Reservas</small>
                    </div>
                    <div class="stat">
                        <h3>69kg</h3>
                        <small>Peso</small>
                    </div>
                    <div class="stat">
                        <h3>23.8</h3>
                        <small>IMC</small>
                    </div>
                </div>

                <div class="perfil-estado">
                    <p><strong>Estado:</strong> <span class="estado">Activo</span></p>
                </div>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Información personal</h3>
                    <button class="btn-editar" id="btnEditar" onclick="toggleEdicion()">Editar</button>
                </div>

                <div id="mensajePerfil" class="mensaje-exito"></div>

                <div class="campo-perfil">
                    <label>Nombre completo</label>
                    <span class="error-perfil" id="errorNombre"></span>
                    <input type="text" id="nombreCompletoInput">
                </div>

                <div class="campo-perfil">
                    <label>Correo electrónico</label>
                    <span class="error-perfil" id="errorCorreo"></span>
                    <input type="email" id="correoUsuarioInput">
                </div>

                

                <div class="fila-dos-campos">
                    <div class="campo-perfil">
                        <label>Peso (kg)</label>
                        <input type="number" id="peso" value="69.0" disabled>
                    </div>
                    <div class="campo-perfil">
                        <label>Talla (cm)</label>
                        <input type="number" id="talla" value="168" disabled>
                    </div>
                </div>

                <div class="campo-perfil">
                    <label>Objetivo</label>
                    <select id="objetivo" disabled>
                        <option value="Perder peso" selected>Perder peso</option>
                        <option value="Mantener peso">Mantener peso</option>
                        <option value="Aumentar masa muscular">Aumentar masa muscular</option>
                    </select>
                </div>

                <div class="campo-perfil">
                    <label>Condiciones médicas</label>
                    <textarea id="condiciones" rows="2" disabled>Ninguna</textarea>
                </div>

                <div id="botonesEdicion" style="display: none;">
                    <div class="botones-edicion">
                        <button class="btn-principal" onclick="guardarPerfil()">Guardar cambios</button>
                        <button class="btn-secundario" onclick="cancelarEdicion()">Cancelar</button>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Mi equipo de salud</h3>
                </div>

                <div class="profesional-card">
                    <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Profesional" width="35"></div>
                    <div>
                        <h4>Dra. Laura Sánchez</h4>
                        <p>Nutricionista</p>
                        <small>Próxima cita: 27 Jun, 10:00 AM</small>
                    </div>
                </div>

                <div class="profesional-card">
                    <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Profesional" width="35"></div>
                    <div>
                        <h4>Lic. Carlos Mora</h4>
                        <p>Entrenador</p>
                        <small>Próxima cita: 04 Jul, 8:00 AM</small>
                    </div>
                </div>
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/indexPaciente.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
</body>

</html>