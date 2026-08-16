<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Página principal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
</head>


<body>



    <aside class="sidebar">
         <a class="navbar-brand" href="index.php?page=indexPaciente">
    <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
</a>

        <nav>
            <a class="activo"href="index.php?page=indexPaciente"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="index.php?page=PlanNutricional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Inicio" width="30"> <b>Mi Plan Nutricional</b></a>
            <a href="index.php?page=Rutinas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Inicio" width="30"> <b>Mi Rutina</b></a>
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
               <h1> <b>¡Hola, <span id="nombreUsuario">Usuario</span>!</b></h1>
                <p>Bienvenido(a) de nuevo a VidaFit</p>
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
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/peso.png" alt="Inicio"></div>
                <div>
                    <p>Peso actual</p>
                    <h2 id="pesoActualValor">-- <span>kg</span></h2>
                    <small class="verde" id="pesoTendencia"></small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/imc.png" alt="Inicio"></div>
                <div>
                    <p>IMC</p>
                    <h2 id="imcValor">--</h2>
                    <small class="estado" id="imcEstado"></small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Inicio"></div>
                <div>
                    <p>Próxima cita</p>
                    <h2 id="citaFecha">Sin citas</h2>
                    <small id="citaProfesional"></small>
                    <strong id="citaHora"></strong>
                </div>
            </div>
        </section>

        <section class="grid-principal">

            <div class="panel grafico">
                <div class="titulo-panel">
                    <h3>Progreso de peso</h3>
                    <button>Último mes⌄</button>
                </div>
                <canvas id="graficoPeso"></canvas>
            </div>


            <div class="panel plan">
                <div class="titulo-panel">
                    <h3>Plan nutricional</h3>
                    <a href="index.php?page=PlanNutricional">Ver plan completo</a>
                </div>

                <div id="listaComidas">
                    <p class="sin-datos">Cargando...</p>
                </div>
            </div>

            <div class="panel rutina">
                <div class="titulo-panel">
                    <h3>Mi rutina</h3>
                </div>

                <div id="rutinaResumen"></div>
                <div id="listaEjercicios">
                    <p class="sin-datos">Cargando...</p>
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