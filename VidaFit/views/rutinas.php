<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Mi rutina</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/rutinas.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="index.php?page=indexPaciente">
            <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
        </a>

        <nav>
            <a href="index.php?page=indexPaciente"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="index.php?page=PlanNutricional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Inicio" width="30"> <b>Mi Plan Nutricional</b></a>
            <a class="activo" href="index.php?page=Rutinas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Inicio" width="30"> <b>Mi Rutina</b></a>
            <a href="index.php?page=Miprogreso"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/progreso.png" alt="Inicio" width="30"> <b>Mi Progreso</b></a>
            <a href="index.php?page=Citas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Inicio" width="30"> <b>Citas</b></a>
            <a href="index.php?page=Perfil"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Inicio" width="30"><b>Perfil</b></a>
            <a href="index.php?page=Configuracion"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Inicio" width="30"> <b>Configuración</b></a>
        </nav>

        <button class="logout" id="btnLogout" >Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Mi rutina</b></h1>
                <p>¡Mira tu rutina asignada!</p>
            </div>

            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
               <div>
                    <h4><b class="nombreCompletoUsuario"></b></h4>
                    <p id="rolUsuario"></p>
                </div>
            </div>
        </header>

        <section class="cards-macros">
            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/reloj.png" alt="Inicio"></div>
                <div>
                    <p><b>Duración total</b></p>
                    <h2 id="valDuracion">--</h2>
                    <small>minutos</small>
                </div>
            </div>

            <div class="card">
                <div class="icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/frecuencia.png" alt="Inicio"></div>
                <div>
                    <p><b>Frecuencia</b></p>
                    <h2 id="valFrecuencia">--</h2>
                    <small>días semanales</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/calorias.png" alt="Inicio"></div>
                <div>
                    <p><b>Calorías quemadas</b></p>
                    <h2 id="valCalorias">--</h2>
                    <small>del día seleccionado</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/intensidad.png" alt="Inicio"></div>
                <div>
                    <p><b>Nivel</b></p>
                    <h2 id="valNivel">--</h2>
                    <small>de dificultad</small>
                </div>
            </div>
        </section>

        <br>
        <br>
        <h1 class="subtitulo"><b>Seleccionar día</b></h1>
        <br>

        <section class="dias" id="diasRutina">
            <p class="text-muted">Cargando rutina...</p>
        </section>

        <section class="grid-principal" id="panelRutina">
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/rutinas.js"></script>
</body>

</html>