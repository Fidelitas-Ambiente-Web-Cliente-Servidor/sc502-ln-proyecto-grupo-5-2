<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vida Fit | Mi plan nutricional</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/PlanNutricional.css" />
</head>

<body>

    <aside class="sidebar">
        <a class="navbar-brand" href="index.php?page=indexPaciente">
            <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png" alt="Vida Fit" width="230">
        </a>

        <nav>
            <a href="index.php?page=indexPaciente">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/inicio.png" alt="Inicio" width="30"><b>Inicio</b>
            </a>
            <a class="activo" href="index.php?page=PlanNutricional">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/plan.png" alt="Inicio" width="30"> <b>Mi Plan Nutricional</b>
            </a>
            <a href="index.php?page=rutinas">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/ejercicio.png" alt="Inicio" width="30"> <b>Mi Rutina</b>
            </a>
            <a href="index.php?page=Miprogreso">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/progreso.png" alt="Inicio" width="30"> <b>Mi Progreso</b>
            </a>
            <a href="index.php?page=Citas">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/citas.png" alt="Inicio" width="30"> <b>Citas</b>
            </a>
            <a href="index.php?page=perfil">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/perfil.png" alt="Inicio" width="30"><b>Perfil</b>
            </a>
            <a href="index.php?page=Configuracion">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/configuracion.png" alt="Inicio" width="30"> <b>Configuración</b>
            </a>
        </nav>

        <button class="logout" onclick="cerrarSesion()">Cerrar sesión</button>
    </aside>

    <main class="contenido">

        <header class="header">
            <div>
                <h1><b>Mi plan nutricional</b></h1>
                <p>Echa un vistazo a tu plan nutricional</p>
            </div>

            <div class="usuario">
                <img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/usuario.png" alt="Usuario">
                <div>
                    <h4><b>Sofía Martínez</b></h4>
                    <p>Paciente</p>
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
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/calorias.png" alt="Inicio"></div>
                <div>
                    <p><b>Calorías diarias</b></p>
                    <h2>1600 kcal</h2>
                    <small>recomendadas</small>
                </div>
            </div>

            <div class="card">
                <div class="icono naranja"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/proteina.png" alt="Inicio"></div>
                <div>
                    <p><b>Proteínas</b></p>
                    <h2>120g</h2>
                    <small>125g recomendados</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/carbohidrato.png" alt="Inicio"></div>
                <div>
                    <p><b>Carbohidratos</b></p>
                    <h2>200g</h2>
                    <small>200g recomendados</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/grasa.png" alt="Inicio"></div>
                <div>
                    <p><b>Grasas</b></p>
                    <h2>55g</h2>
                    <small>60g recomendados</small>
                </div>
            </div>

            <div class="card">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/agua.png" alt="Inicio"></div>
                <div>
                    <p><b>Agua</b></p>
                    <h2>2.0L / 2.5 L</h2>
                    <strong>¡Sigue así!</strong>
                </div>
            </div>
        </section>
        <br>
        <br>

        <h1 class="subtitulo"><b>Seleccionar día</b></h1>
        <br>

        <section class="dias">

            <button class="btn-dias activo-dia" data-dia="lunes">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/monday.png" alt="Inicio"></div>
                <div>
                    <h3>Lunes</h3>
                </div>
            </button>

            <button class="btn-dias" data-dia="martes">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/tuesday.png" alt="Inicio"></div>
                <div>
                    <h3>Martes</h3>
                </div>
            </button>

            <button class="btn-dias" data-dia="miercoles">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/wednesday.png" alt="Inicio"></div>
                <div>
                    <h3>Miercoles</h3>
                </div>
            </button>

            <button class="btn-dias" data-dia="jueves">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/thursday.png" alt="Inicio"></div>
                <div>
                    <h3>Jueves</h3>
                </div>
            </button>

            <button class="btn-dias" data-dia="viernes">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/friday.png" alt="Inicio"></div>
                <div>
                    <h3>Viernes</h3>
                </div>
            </button>

            <button class="btn-dias" data-dia="sabado">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/saturday.png" alt="Inicio"></div>
                <div>
                    <h3>Sábado</h3>
                </div>
            </button>

            <button class="btn-dias" data-dia="domingo">
                <div class="icono"><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/sunday.png" alt="Inicio"></div>
                <div>
                    <h3>Domingo</h3>
                </div>
            </button>

        </section>

        <section class="grid-principal">

            <div class="panel plan" data-dia="lunes">
                <div class="titulo-panel">
                    <h3>Lunes</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOsoNo2d-oU2e41WgW_zqlBzoCaLL9SuoxBj6B0WEPhU8-aDOYEOVVHReG&s=10" width="250"></div>
                    </div>
                    <ul>
                        <li>2 huevos revueltos</li>
                        <li>1 tortilla integral</li>
                        <li>1/2 aguacate</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcIUXXpDs-M7ytCmvwJZfCwPiXvy16ifo5pe04F9BbtgAiHndis4qD8bs&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>150g de pollo</li>
                        <li>1 taza de arroz integral</li>
                        <li>Ensalada mixta</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://cdn.avena.io/dall-e/stability-yogurt-con-manzana-1689613697825.png" id="fotoComida" width="150"></div>
                    </div>
                    <ul>
                        <li>1 manzana</li>
                        <li>1 taza de yogurt griego</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://recetasparathermomix.com/wp-content/uploads/un-plato-blanco-con-salm-n-rosado-perfectamente-co.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>150g de salmón</li>
                        <li>Verduras al vapor</li>
                        <li>1 camote pequeño</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
            </div>

            <div class="panel plan" data-dia="martes">
                <div class="titulo-panel">
                    <h3>Martes</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGCUSg5bNKEUvFN5jRD2qQPaCfObGJWVfjlNL_p1-cAcLUcKvqAJ2Oi18X&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>1/2 taza de gallo pinto</li>
                        <li>2 huevos fritos</li>
                        <li>30g de queso</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://cdn.avena.io/avena-recipes-v2/2025/07/dall-e-1753817905311.jpeg" width="150"></div>
                    </div>
                    <ul>
                        <li>150g de bistec de res</li>
                        <li>1/2 taza de arroz integral</li>
                        <li>1/2 taza de frijoles</li>
                        <li>Vegetales al vapor</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://recetasdecocina.elmundo.es/wp-content/uploads/2025/05/batido-de-papaya.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>1 batido de papaya con leche</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://i0.wp.com/lacocinademiyi.com/wp-content/uploads/2018/07/dsc_14182.jpg?fit=1200%2C1200&ssl=1" width="150"></div>
                    </div>
                    <ul>
                        <li>1 taza de picadillo de chayote</li>
                        <li>2 tortillas</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
            </div>

            <div class="panel plan" data-dia="miercoles">
                <div class="titulo-panel">
                    <h3>Miércoles</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://www.bmc.org/sites/default/files/Screen%20Shot%202023-03-09%20at%202.39.02%20PM.png" width="150"></div>
                    </div>
                    <ul>
                        <li>Avena cocida con leche descremada</li>
                        <li>½ banano en rodajas</li>
                        <li>Canela</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://tiaclara.com/wp-content/uploads/2023/02/pan-fried-pork-chops-ClaraGon5180.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>150 g carne chuleta ahumada</li>
                        <li>1 taza de puré de papa</li>
                        <li>Ensalada mixta</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQyQIJ8ojBXBdCTo3ATdizBmPOLvz7A-4fXCEFE-3XtX6_LYdAd_yDLiDE&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>1 taza de fresas</li>
                        <li>1 taza de yogurt griego</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5mg_LfDgC9X--FOCwM6Onr2SGmiAcKcFye8_NXCuPt10_UokBQrd8DEvk&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>Omelette de 2 huevos con espinaca</li>
                        <li>1 tostada integral</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
            </div>

            <div class="panel plan" data-dia="jueves">
                <div class="titulo-panel">
                    <h3>Jueves</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://buenprovecho.hn/wp-content/uploads/2019/07/Tostada-de-aguacate-y-huevo.png" width="150"></div>
                    </div>
                    <ul>
                        <li>2 tostadas integrales</li>
                        <li>Queso bajo en grasa</li>
                        <li>1 huevo</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://comedera.com/wp-content/uploads/sites/9/2022/11/ensalada-de-quinoa-con-salmon.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>150 g salmón o pescado</li>
                        <li>½ taza quinoa o arroz</li>
                        <li>Ensalada mixta</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://p2.piqsels.com/preview/474/246/387/plate-food-peanut-butter-nut-butter.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>1 pera</li>
                        <li>1 cucharada de mantequilla de maní</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://imag.bonviveur.com/presentacion-principal-del-wrap-de-pollo-y-verduras.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>Wrap integral de pollo con vegetales</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
            </div>

            <div class="panel plan" data-dia="viernes">
                <div class="titulo-panel">
                    <h3>Viernes</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://cdn.avena.io/avena-recipes-v2/2024/08/1723587839578.jpeg" width="150"></div>
                    </div>
                    <ul>
                        <li>1 taza de yogurt griego</li>
                        <li>Granola</li>
                        <li>Fruta picada</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRN3LkLGbXLzhdXV7wdbvEJxz70w-aHL2IRYlRSw3WhtxQLWgaqGXSMCeEN&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>150 g pollo a la plancha</li>
                        <li>1 taza de arroz integral</li>
                        <li>Pico de gallo</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://revistavisioncr.com/wp-content/uploads/2025/10/a1-14-1170x780.webp" width="150"></div>
                    </div>
                    <ul>
                        <li>1 cuadrito de chocolate 70% puro</li>
                        <li>1 fruta</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://www.lacocinasana.com/static/59bdd63adf529051381443d3480e28dd/a892d/pechuga_pavo_16043349ed.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>Crema de vegetales</li>
                        <li>Sandwich integral de pavo</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
            </div>

            <div class="panel plan" data-dia="sabado">
                <div class="titulo-panel">
                    <h3>Sábado</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://snapcalorie-webflow-website.s3.us-east-2.amazonaws.com/media/food_pics_v2/medium/cereal_with_milk_and_banana_slices.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>1 taza de cereal integral</li>
                        <li>1 vaso de leche</li>
                        <li>1 banano</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw-w7UnJL8fSgwVg4Pz7YaGaWZ8EVIQc2wm3rMZKT-NjW7SePZoR8pfpTa&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>Pasta integral con carne molida magra</li>
                        <li>Ensalada</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://thumbs.dreamstime.com/b/yogur-griego-espeso-con-miel-y-nueces-en-bol-de-madera-indultar-un-taz%C3%B3n-este-snack-natural-saludable-ofrece-una-deliciosa-mezcla-382352848.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>Mix de nueces</li>
                        <li> taza de yogurt griego</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://imag.bonviveur.com/ensalada-cesar-con-pollo.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>Ensalada César con pollo</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
            </div>

            <div class="panel plan" data-dia="domingo">
                <div class="titulo-panel">
                    <h3>Domingo</h3>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/desayuno.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Desayuno</h4>
                        <small>8:00 AM</small>
                        <div><img class="fotoComida" src="https://www.lagloriavegana.com/wp-content/uploads/2020/08/IMG_9813-1233x1280.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li> 3 Pancakes de avena pequeños con arándano</li>
                        <li>Miel de maple sin azúcar</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/almuerzo.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Almuerzo</h4>
                        <small>1:00 PM</small>
                        <div><img class="fotoComida" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoChB-aWpu8uKDwF74mJ8VziWzi9VOoE2hR4CZL3_V-0D012MVNCM07js&s=10" width="150"></div>
                    </div>
                    <ul>
                        <li>150g de carne asada</li>
                        <li>Papa asada</li>
                        <li>Vegetales salteados</li>
                    </ul>
                </div>
                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/snack.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Snack</h4>
                        <small>4:00 PM</small>
                        <div><img class="fotoComida" src="https://i.pinimg.com/736x/b3/8c/b3/b38cb33fedc4c9c5d5dc04aee8057ad0.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>Smoothie de frutas con proteína o leche</li>
                    </ul>
                </div>

                <div class="comida">
                    <span><img src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/cena.png" alt="Inicio" width="30"></span>
                    <div>
                        <h4>Cena</h4>
                        <small>7:00 PM</small>
                        <div><img class="fotoComida" src="https://jetextramar.com/wp-content/uploads/2021/09/receta-fideo-grueso-empresa-de-alimentos-700x525.jpg" width="150"></div>
                    </div>
                    <ul>
                        <li>Sopa de pollo con vegetales</li>
                        <li>2 galletas integrales</li>
                    </ul>
                </div>

                <button class="btn-secundario" onclick="completarPlan(this)"> ✓ Marcar día como completado</button>
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

    <script src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/PlanNutricional.js"></script>
</body>

</html>