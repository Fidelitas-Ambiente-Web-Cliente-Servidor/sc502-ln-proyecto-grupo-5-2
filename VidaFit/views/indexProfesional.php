<?php


if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php?page=login');
    exit;
}
$username = $_SESSION['username'] ?? 'Usuario';
$idRol = $_SESSION['id_rol'] ?? null;
$nombreCompleto = $_SESSION['nombre_completo'] ?? 'Usuario';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Profesional de la Salud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexProfesional.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="indexProfesional.html">
            <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
        </a>

        <nav>
            <a class="activo" href="indexProfesional.html"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b></a>
            <a href="GestionarRutinas.html"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutinas" width="30"> <b>Gestionar Rutinas</b></a>
            <a href="GestionarPlanes.html"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="30"> <b>Gestionar Planes Alimenticios</b></a>
            <a href="GestionPacientes.html"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Pacientes" width="30"> <b>Gestionar Pacientes</b></a>
            <a href="ConfiguracionProfesional.html"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Configuración" width="30"> <b>Configuración</b></a>
        </nav>

        <button class="logout" id="btnLogout" >Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>¡Hola, <?= htmlspecialchars($username) ?>!</b></h1>
                <p>Panel de gestión profesional — VidaFit</p>
            </div>

            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b><?= htmlspecialchars($nombreCompleto) ?></b></h4>
                    <p>Profesional de la Salud</p>
                </div>
            </div>
        </header>

        <section class="cards-superiores">
            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Pacientes" width="35"></div>
                <div>
                    <p>Pacientes activos</p>
                    <h2>12</h2>
                    <small class="verde">4 nuevos este mes</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Citas" width="35"></div>
                <div>
                    <p>Citas hoy</p>
                    <h2>3</h2>
                    <small>Próxima: 09:30 AM</small>
                </div>
            </div>

            <div class="card">
                <div class="icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutinas" width="35"></div>
                <div>
                    <p>Rutinas asignadas</p>
                    <h2>8</h2>
                    <small>En seguimiento</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="35"></div>
                <div>
                    <p>Planes alimenticios</p>
                    <h2>10</h2>
                    <small>Activos</small>
                </div>
            </div>
        </section>

        <section class="panel acciones-principales">
            <div class="titulo-panel">
                <h3>Acciones principales</h3>
                <p class="subtitulo-panel">Seleccione una opción para comenzar</p>
            </div>

            <div class="grid-acciones">
                <a href="GestionarRutinas.html" class="accion-card accion-activa">
                    <div class="accion-icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutinas" width="40"></div>
                    <h4>Gestionar Rutinas</h4>
                    <p>Administre pacientes, calcule IMC, asigne rutinas, planes alimenticios y gestione citas.</p>
                    <span class="badge-disponible">Disponible</span>
                </a>

                <a href="GestionarPlanes.html" class="accion-card accion-activa">
                    <div class="accion-icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="40"></div>
                    <h4>Gestionar Planes Alimenticios</h4>
                    <p>Cree y administre planes nutricionales personalizados para sus pacientes.</p>
                    <span class="badge-disponible">Disponible</span>
                </a>

                <a href="GestionPacientes.html" class="accion-card accion-activa">
                    <div class="accion-icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Pacientes" width="40"></div>
                    <h4>Gestionar Pacientes</h4>
                    <p>Consulte el historial clínico, progreso y datos generales de sus pacientes.</p>
                    <span class="badge-disponible">Disponible</span>
                </a>
            </div>
        </section>

        <section class="grid-resumen">
            <div class="panel">
                <div class="titulo-panel">
                    <h3>Próximas citas</h3>
                    <a href="GestionarRutinas.html#citas">Ver todas</a>
                </div>

                <div class="noti">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Cita" width="30"></span>
                    <p>Sofía Martínez<br><small>27 Jun • 10:00 AM • Confirmada</small></p>
                </div>

                <div class="noti">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Cita" width="30"></span>
                    <p>Luis Ramírez<br><small>28 Jun • 11:30 AM • Pendiente</small></p>
                </div>

                <div class="noti">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Cita" width="30"></span>
                    <p>Ana Torres<br><small>29 Jun • 09:00 AM • Confirmada</small></p>
                </div>
            </div>

            <div class="panel">
                <div class="titulo-panel">
                    <h3>Actividad reciente</h3>
                </div>

                <div class="noti">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Rutina" width="30"></span>
                    <p>Rutina asignada a Miguel Herrera<br><small>Hace 1 hora</small></p>
                </div>

                <div class="noti">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Plan" width="30"></span>
                    <p>Plan nutricional actualizado para Sofía Martínez<br><small>Hace 3 hours</small></p>
                </div>

                <div class="noti">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/imc.png" alt="IMC" width="30"></span>
                    <p>IMC calculado para Luis Ramírez<br><small>Ayer</small></p>
                </div>
            </div>
        </section>

        <div id="toastProximamente" class="toast-proximamente"></div>

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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/indexProfesional.js"></script>
</body>

</html>