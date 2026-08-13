<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Mi Progreso</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/miProgreso.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="index.php?page=indexPaciente">
            <img src="img/logo.png" alt="Vida Fit" width="230">
        </a>
        <nav>
            <a href="index.php?page=indexPaciente"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="index.php?page=PlanNutricional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Inicio" width="30"> <b>Mi Plan Nutricional</b></a>
            <a href="index.php?page=Rutinas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Inicio" width="30"> <b>Mi Rutina</b></a>
            <a class="activo" href="index.php?page=Miprogreso"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/progreso.png" alt="Inicio" width="30"> <b>Mi Progreso</b></a>
            <a href="index.php?page=Citas"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Inicio" width="30"> <b>Citas</b></a>
            <a href="index.php?page=Perfil"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Inicio" width="30"><b>Perfil</b></a>
            <a href="index.php?page=Configuracion"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Inicio" width="30"> <b>Configuración</b></a>
        </nav>

        <button class="logout" id="btnLogout">Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Mi Progreso</b></h1>
                <p>Seguimiento de tus avances y resultados</p>
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
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/peso.png" alt="Peso" width="35"></div>
                <div>
                    <p>Peso inicial</p>
                    <h2><span id="pesoInicial">0.0</span> <span>kg</span></h2>
                    <small id="fechaPesoInicial">Sin registros</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/peso.png" alt="Peso" width="35"></div>
                <div>
                    <p>Peso actual</p>
                    <h2><span id="pesoActual">0.0</span> <span>kg</span></h2>
                    <small class="verde" id="pesoPerdido"></small>
                </div>
            </div>

            <div class="card">
                <div class="icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/objetivo.png" alt="Objetivo" width="35"></div>
                <div>
                    <p>Meta de peso</p>
                    <h2><span id="pesoIdeal">0.0</span> <span>kg</span></h2>
                    <small id="pesoRestante"></small>

                    <div class="barra">
                        <div id="barraProgreso" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/imc.png" alt="IMC" width="35"></div>
                <div>
                    <p>IMC actual</p>
                    <h2 id="imcActual">0.0</h2>
                    <small class="estado" id="estadoNutricional">Sin datos</small>
                </div>
            </div>
        </section>

        <section class="grid-progreso">

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Historial de peso</h3>
                    <button id="btnPeriodo" onclick="cambiarPeriodo()">Último mes ⌄</button>
                </div>
                <canvas id="graficoPeso"></canvas>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Mis medidas</h3>
                </div>

                <div class="medida-fila">
                    <span class="medida-nombre">Cintura</span>
                    <div class="medida-barra-wrap">
                        <div class="medida-barra">
                            <div class="medida-relleno" style="width: 68%"></div>
                        </div>
                    </div>
                    <span class="medida-valor">72 cm</span>
                </div>

                <div class="medida-fila">
                    <span class="medida-nombre">Cadera</span>
                    <div class="medida-barra-wrap">
                        <div class="medida-barra">
                            <div class="medida-relleno" style="width: 80%"></div>
                        </div>
                    </div>
                    <span class="medida-valor">95 cm</span>
                </div>

                <div class="medida-fila">
                    <span class="medida-nombre">Brazo</span>
                    <div class="medida-barra-wrap">
                        <div class="medida-barra">
                            <div class="medida-relleno" style="width: 40%"></div>
                        </div>
                    </div>
                    <span class="medida-valor">30 cm</span>
                </div>

                <div class="medida-fila">
                    <span class="medida-nombre">Muslo</span>
                    <div class="medida-barra-wrap">
                        <div class="medida-barra">
                            <div class="medida-relleno" style="width: 60%"></div>
                        </div>
                    </div>
                    <span class="medida-valor">55 cm</span>
                </div>

                <div class="form-medida">
                    <h4>Registrar nueva medida</h4>
                    <div id="errorMedida" class="error-progreso"></div>
                    <select id="selectMedida">
                        <option value="">-- Seleccionar medida --</option>
                        <option value="Cintura">Cintura</option>
                        <option value="Cadera">Cadera</option>
                        <option value="Brazo">Brazo</option>
                        <option value="Muslo">Muslo</option>
                        <option value="Pecho">Pecho</option>
                    </select>
                    <input type="number" id="valorMedida" placeholder="Valor en cm" min="1" max="300" />
                    <button class="btn-principal" onclick="registrarMedida()">+ Registrar</button>
                </div>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Registrar peso</h3>
                </div>
                <div id="errorPeso" class="error-progreso"></div>
                <input type="number" id="nuevoPeso" placeholder="Peso en kg (ej: 68.5)" step="0.1" min="30" max="300" />
                <input type="date" id="fechaPeso" />
                <button class="btn-principal" style="margin-top: 12px;" onclick="registrarPeso()">+ Agregar registro</button>

                <h4 style="margin-top: 24px; margin-bottom: 12px;">Últimos registros</h4>
                <div id="listaRegistros" class="lista-registros"></div>
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/Miprogreso.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionProgreso.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/indexPaciente.js"></script>
</body>

</html>