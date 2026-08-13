<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Planes Nutricionales</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    
    
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexPaciente.css" />
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/indexProfesional.css" />
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
            <a class="activo"  href="index.php?page=GestionarPlanes"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Planes" width="30"> <b>Gestionar Planes Alimenticios</b></a>
            <a href="index.php?page=GestionPacientes"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Pacientes" width="30"> <b>Gestionar Pacientes</b></a>
            <a href="index.php?page=ConfiguracionProfesional"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Configuración" width="30"> <b>Configuración</b></a>
        </nav>

       <button class="logout" id="btnLogout" >Cerrar sesión</button>
    </aside>

    <main class="contenido">

   
        <header class="header">
            <div>
                <h1><b>Asignación de Planes Nutricionales</b></h1>
                <p>Diseño de pautas alimenticias y distribución de comidas macro-objetivos</p>
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
            
            <div class="panel panel-perfil-prof" style="grid-column: span 2;">
                <div class="titulo-panel mb-3">
                    <h3>Historial de Planes Nutricionales</h3>
                    <p class="subtitulo-panel">Planes de alimentación activos asignados a pacientes</p>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle" style="font-family: var(--fuente);">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Calorías</th>
                                <th>Vigencia</th>
                                <th>Distribución (Comidas)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPlanes">
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="panel">
                <div class="titulo-panel mb-3">
                    <h3 id="formPlanTitulo">Crear Plan Nutricional</h3>
                    <p class="subtitulo-panel">Defina las metas y desglose de alimentos</p>
                </div>
                
                <form id="formPlanNutricional">
                    <input type="hidden" id="planId" value="">
                    
                    <div class="mb-3">
                        <label class="form-label"><b>Seleccionar Paciente:</b></label>
                        <select id="selectPacientePlan" class="form-select" required style="border-radius: 10px;">
                            <option value="">-- Seleccionar --</option>
                            <option value="Sofía Martínez">Sofía Martínez</option>
                            <option value="Luis Ramírez">Luis Ramírez</option>
                            <option value="Ana Torres">Ana Torres</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Calorías Diarias (kcal):</b></label>
                        <input type="number" id="caloriasDiarias" class="form-control" placeholder="Ej. 2000" required style="border-radius: 10px;">
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><b>Fecha Inicio:</b></label>
                            <input type="date" id="fechaInicio" class="form-control" required style="border-radius: 10px;">
                        </div>
                        <div class="col">
                            <label class="form-label"><b>Fecha Fin:</b></label>
                            <input type="date" id="fechaFin" class="form-control" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><b>Recomendaciones Generales:</b></label>
                        <textarea id="recomendaciones" class="form-control" rows="2" placeholder="Ej. Tomar 2L de agua, evitar sodio..." style="border-radius: 10px;"></textarea>
                    </div>

                    <hr>
                    <p class="text-muted mb-2"><b>Estructura de Comidas Base:</b></p>
                    
                    <div class="mb-2 p-2 border style-dashed" style="border-radius: 8px; background: #fafafa;">
                        <small><b>Desayuno:</b></small>
                        <input type="text" id="comidaDesayuno" class="form-control form-control-sm" placeholder="Ej. 3 huevos, 100g avena..." required>
                    </div>

                    <div class="mb-2 p-2 border style-dashed" style="border-radius: 8px; background: #fafafa;">
                        <small><b>Almuerzo:</b></small>
                        <input type="text" id="comidaAlmuerzo" class="form-control form-control-sm" placeholder="Ej. 200g pechuga, 150g arroz..." required>
                    </div>

                    <div class="mb-3 p-2 border style-dashed" style="border-radius: 8px; background: #fafafa;">
                        <small><b>Cena:</b></small>
                        <input type="text" id="comidaCena" class="form-control form-control-sm" placeholder="Ej. 150g salmón, ensalada verde..." required>
                    </div>

                    <div class="botones-edicion">
                        <button type="submit" id="btnGuardarPlan" class="btn-editar-prof" style="background-color: var(--primary); color: white; border: none; height: 45px; width: 100%;">Guardar Plan</button>
                        <button type="button" id="btnCancelarPlan" class="btn-editar-prof oculto" onclick="resetearFormularioPlan()" style="height: 45px; width: 100%;">Cancelar Edición</button>
                    </div>
                </form>
            </div>

        </section>

        <!-- FOOTER -->
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
    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/gestionPlanes.js"></script>
     <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/GestionUsuarios.js"></script>
</body>

</html>