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
            <div id="cardMes" class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/calendario.png" alt="Inicio"></div>
                <div>
                    <h3> <B>Junio</B></h3>
                    <small>Mes actual</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/reloj.png" alt="Inicio"></div>
                <div>
                    <p><b>Duración de la rutina</b></p>
                    <h2>2 </h2>
                    <small>meses</small>
                </div>
            </div>

            <div class="card">
                <div class="icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/frecuencia.png" alt="Inicio"></div>
                <div>
                    <p><b>Frecuencia</b></p>
                    <h2>4</h2>
                    <small>días semanales</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/calorias.png" alt="Inicio"></div>
                <div>
                    <p><b>Calorias quemadas</b></p>
                    <h2>500</h2>
                    <small>por sesión</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/intensidad.png" alt="Inicio"></div>
                <div>
                    <p><b>Nivel</b></p>
                    <h2>Intermedio</h2>
                    <small>de dificultad</small>
                </div>
            </div>
        </section>

        <br>
        <br>
        <h1 class="subtitulo"><b>Seleccionar día</b></h1>
        <br>

        <section class="dias">
            <button class="btn-dias activo-dia" data-dia="dia1">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/mancuerna.png" alt="Inicio"></div>
                <div>
                    <h3>Dia 1: Pierna y glúteo</h3>
                </div>
            </button>
            <button class="btn-dias" data-dia="dia2">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/mancuerna.png" alt="Inicio"></div>
                <div>
                    <h3>Día 2: Pecho y tríceps</h3>
                </div>
            </button>
            <button class="btn-dias" data-dia="dia3">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/mancuerna.png" alt="Inicio"></div>
                <div>
                    <h3>Día 3: Abdomen</h3>
                </div>
            </button>
            <button class="btn-dias" data-dia="dia4">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/mancuerna.png" alt="Inicio"></div>
                <div>
                    <h3>Día 4: Espalda, hombro y bícep</h3>
                </div>
            </button>
            <button class="btn-dias" data-dia="cardio">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cardio.png" alt="Inicio"></div>
                <div>
                    <h3>Sesiones de cardio</h3>
                </div>
            </button>
        </section>

        <section class="grid-principal">

            <div class="panel plan" data-dia="dia1">
                <div class="titulo-panel">
                    <div>
                        <h3>Día 1 - Pierna y glúteo</h3>
                        <p>Rutina enfocada en fuerza y desarrollo de tren inferior.</p>
                    </div>
                </div>
                <div class="encabezado-rutina">
                    <strong>#</strong>
                    <strong>Ejercicio</strong>
                    <strong>Descripción</strong>
                    <strong>Series</strong>
                    <strong>Repeticiones</strong>
                    <strong>Descanso</strong>
                    <strong>Video del ejercicio</strong>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">1</div>
                    <div class="nombre-ejercicio">
                        <h4>Sentadilla Smith</h4>
                    </div>
                    <p>Ejercicio compuesto para cuádriceps y glúteos.</p>
                    <div class="dato">4</div>
                    <div class="dato">10</div>
                    <div class="dato">90 s</div>
                    <video class="videoEjercicio" controls muted title="Sentadilla Smith">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/26171201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">2</div>
                    <div class="nombre-ejercicio">
                        <h4>Hip Thrust</h4>
                    </div>
                    <p>Enfocado en glúteos e isquiotibiales.</p>
                    <div class="dato">4</div>
                    <div class="dato">12</div>
                    <div class="dato">90 s</div>
                    <video class="videoEjercicio" controls muted title="Hip Thrust">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/10601201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">3</div>
                    <div class="nombre-ejercicio">
                        <h4>Extensión de cuádriceps</h4>
                    </div>
                    <p>Aísla y fortalece principalmente los cuádriceps.</p>
                    <div class="dato">3</div>
                    <div class="dato">12</div>
                    <div class="dato">75 s</div>
                    <video class="videoEjercicio" controls muted title="Extensión de cuádriceps">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/05851201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">4</div>
                    <div class="nombre-ejercicio">
                        <h4>Abductores</h4>
                    </div>
                    <p>Trabaja glúteo medio, glúteo mayor y estabilidad de cadera.</p>
                    <div class="dato">3</div>
                    <div class="dato">12</div>
                    <div class="dato">75 s</div>
                    <video class="videoEjercicio" controls muted title="Abductores">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/36111201.mp4" type="video/mp4">
                    </video>
                </div>
                <button class="btn-secundario" onclick="manejarRutina(this)">▶ Comenzar rutina</button>
            </div>

            <div class="panel plan" data-dia="dia2">
                <div class="titulo-panel">
                    <div>
                        <h3>Día 2 - Pecho y tríceps</h3>
                        <p>Rutina enfocada en empuje, pecho y estabilidad del hombro.</p>
                    </div>
                </div>
                <div class="encabezado-rutina">
                    <strong>#</strong>
                    <strong>Ejercicio</strong>
                    <strong>Descripción</strong>
                    <strong>Series</strong>
                    <strong>Repeticiones</strong>
                    <strong>Descanso</strong>
                    <strong>Video del ejercicio</strong>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">1</div>
                    <div class="nombre-ejercicio">
                        <h4>Press de pecho inclinado</h4>
                    </div>
                    <p>Trabaja pecho superior, hombros y tríceps.</p>
                    <div class="dato">4</div>
                    <div class="dato">10</div>
                    <div class="dato">90 s</div>
                    <video class="videoEjercicio" controls muted title="Press de pecho inclinado">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/00471201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">2</div>
                    <div class="nombre-ejercicio">
                        <h4>Pec deck</h4>
                    </div>
                    <p>Aísla el pecho y mejora la contracción muscular.</p>
                    <div class="dato">3</div>
                    <div class="dato">12</div>
                    <div class="dato">75 s</div>
                    <video class="videoEjercicio" controls muted title="Pec deck">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/24271201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">3</div>
                    <div class="nombre-ejercicio">
                        <h4>Elevaciones laterales</h4>
                    </div>
                    <p>Trabaja principalmente el deltoide lateral.</p>
                    <div class="dato">3</div>
                    <div class="dato">15</div>
                    <div class="dato">60 s</div>
                    <video class="videoEjercicio" controls muted title="Elevaciones laterales">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/03341201.mp4" type="video/mp4">
                    </video>
                </div>
                <button class="btn-secundario" onclick="manejarRutina(this)">▶ Comenzar rutina</button>
            </div>

            <div class="panel plan" data-dia="dia3">
                <div class="titulo-panel">
                    <div>
                        <h3>Día 3 - Abdomen</h3>
                        <p>Rutina enfocada en core, abdomen y estabilidad.</p>
                    </div>
                </div>
                <div class="encabezado-rutina">
                    <strong>#</strong>
                    <strong>Ejercicio</strong>
                    <strong>Descripción</strong>
                    <strong>Series</strong>
                    <strong>Repeticiones</strong>
                    <strong>Descanso</strong>
                    <strong>Video del ejercicio</strong>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">1</div>
                    <div class="nombre-ejercicio">
                        <h4>Crunch abdominal</h4>
                    </div>
                    <p>Trabaja la zona superior del abdomen.</p>
                    <div class="dato">4</div>
                    <div class="dato">15</div>
                    <div class="dato">45 s</div>
                    <video class="videoEjercicio" controls muted title="Crunch abdominal">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/02741201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">2</div>
                    <div class="nombre-ejercicio">
                        <h4>Plancha</h4>
                    </div>
                    <p>Fortalece abdomen, zona lumbar y estabilidad general.</p>
                    <div class="dato">3</div>
                    <div class="dato">40 s</div>
                    <div class="dato">45 s</div>
                    <video class="videoEjercicio" controls muted title="Crunch abdominal">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/04651201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">3</div>
                    <div class="nombre-ejercicio">
                        <h4>Elevación de piernas</h4>
                    </div>
                    <p>Enfocado en abdomen inferior y control del core.</p>
                    <div class="dato">3</div>
                    <div class="dato">12</div>
                    <div class="dato">60 s</div>
                    <video class="videoEjercicio" controls muted title="Elevación de piernas">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/11631201.mp4" type="video/mp4">
                    </video>
                </div>
                <button class="btn-secundario" onclick="manejarRutina(this)">▶ Comenzar rutina</button>
            </div>

            <div class="panel plan" data-dia="dia4">
                <div class="titulo-panel">
                    <div>
                        <h3>Día 4 - Espalda, hombro y bíceps</h3>
                        <p>Rutina enfocada en jalones, espalda alta y brazos.</p>
                    </div>
                </div>
                <div class="encabezado-rutina">
                    <strong>#</strong>
                    <strong>Ejercicio</strong>
                    <strong>Descripción</strong>
                    <strong>Series</strong>
                    <strong>Repeticiones</strong>
                    <strong>Descanso</strong>
                    <strong>Imagen</strong>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">1</div>
                    <div class="nombre-ejercicio">
                        <h4>Jalón al pecho</h4>
                    </div>
                    <p>Trabaja dorsales y espalda alta.</p>
                    <div class="dato">4</div>
                    <div class="dato">10</div>
                    <div class="dato">90 s</div>
                    <video class="videoEjercicio" controls muted title="Jalón al pecho">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/22911201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">2</div>
                    <div class="nombre-ejercicio">
                        <h4>Remo sentado</h4>
                    </div>
                    <p>Fortalece espalda media y mejora la postura.</p>
                    <div class="dato">4</div>
                    <div class="dato">12</div>
                    <div class="dato">90 s</div>
                    <video class="videoEjercicio" controls muted title="Jalón al pecho">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/13501201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">3</div>
                    <div class="nombre-ejercicio">
                        <h4>Press militar</h4>
                    </div>
                    <p>Trabaja hombros y estabilidad del core.</p>
                    <div class="dato">3</div>
                    <div class="dato">10</div>
                    <div class="dato">75 s</div>
                    <video class="videoEjercicio" controls muted title="Press militar">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/04041201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-ejercicio">
                    <div class="numero">4</div>
                    <div class="nombre-ejercicio">
                        <h4>Curl de bíceps</h4>
                    </div>
                    <p>Aísla y fortalece los bíceps.</p>
                    <div class="dato">3</div>
                    <div class="dato">12</div>
                    <div class="dato">60 s</div>
                    <video class="videoEjercicio" controls muted title="Curl de bíceps">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/24831201.mp4" type="video/mp4">
                    </video>
                </div>
                <button class="btn-secundario" onclick="manejarRutina(this)">▶ Comenzar rutina</button>
            </div>

            <div class="panel plan" data-dia="cardio">
                <div class="titulo-panel">
                    <div>
                        <h3>Sesión de cardio</h3>
                        <p>Enfocado en la quema de grasa después de la rutina de fuerza.</p>
                    </div>
                </div>
                <div class="encabezado-cardio">
                    <strong>#</strong>
                    <strong>Día</strong>
                    <strong>Ejercicio</strong>
                    <strong>Tiempo de ejecución</strong>
                    <strong>Video del ejercicio</strong>
                </div>
                <div class="fila-cardio">
                    <div class="numero">1</div>
                    <div class="nombre-ejercicio">
                        <h4>Día 1</h4>
                    </div>
                    <p>Caminadora con 12% de inclinación y velocidad 4.2 km/h</p>
                    <div class="dato">15 minutos</div>
                    <video class="videoCardio" controls muted title="Caminadora">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/36661201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-cardio">
                    <div class="numero">2</div>
                    <div class="nombre-ejercicio">
                        <h4>Día 2</h4>
                    </div>
                    <p>Salto en cuerda</p>
                    <div class="dato">20 minutos</div>
                    <video class="videoCardio" controls muted title="Salto en cuerda">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/05111201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-cardio">
                    <div class="numero">3</div>
                    <div class="nombre-ejercicio">
                        <h4>Día 3</h4>
                    </div>
                    <p>Spinning a velocidad intermedia</p>
                    <div class="dato">15 minutos</div>
                    <video class="videoCardio" controls muted title="Spinning">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/22641201.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="fila-cardio">
                    <div class="numero">4</div>
                    <div class="nombre-ejercicio">
                        <h4>Día 4</h4>
                    </div>
                    <p>Maquina elíptica velocidad HIIT </p>
                    <div class="dato">10 minutos</div>
                    <video class="videoCardio" controls muted title="Elíptica">
                        <source src="https://lyftaweb.s3.us-east-2.amazonaws.com/GymvisualMP4/21921201.mp4" type="video/mp4">
                    </video>
                </div>
                <button class="btn-secundario" onclick="manejarRutina(this)">Comenzar rutina</button>
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/rutinas.js"></script>
</body>

</html>