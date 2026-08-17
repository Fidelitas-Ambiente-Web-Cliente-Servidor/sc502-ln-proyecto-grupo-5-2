<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Configuración</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/Configuracion.css" />
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
            <a href="index.php?page=Perfil"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Inicio" width="30"><b>Perfil</b></a>
            <a class="activo" href="index.php?page=Configuracion"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Inicio" width="30"> <b>Configuración</b></a>
        </nav>


        <button class="logout" id="btnLogout">Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Configuración</b></h1>
                <p>Administra la seguridad de tu cuenta</p>
            </div>
            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b class="nombreCompletoUsuario"></b></h4>
                    <p id="rolUsuario"></p>
                </div>
            </div>
        </header>

        <section class="grid-config">

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Cambiar contraseña</h3>
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
                            class="password-icon">
                        </span>
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/Configuracion.js"></script>
</body>

</html>