<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vida Fit | Iniciar sesión</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/registro&inicioSesion.css"
    >
</head>

<body>

    <main class="registro-page">

        <section class="lado-imagen">

            <div class="contenido-izquierdo">

                <div class="logo">
                    <img
                        src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/logo.png"
                        alt="Logo VidaFit"
                    >
                </div>

                <h2>
                    Tu salud,<br>
                    <span>tu mejor versión</span>
                </h2>

                <p class="descripcion">
                    Planes nutricionales personalizados, rutinas de ejercicio
                    y seguimiento profesional para lograr tus objetivos.
                </p>

                <div class="beneficio">

                    <div class="icono">
                        🌿
                    </div>

                    <div>
                        <h3>Alimentación saludable</h3>
                        <p>Planes nutricionales adaptados a ti.</p>
                    </div>

                </div>

                <div class="beneficio">

                    <div class="icono">
                        🏋️
                    </div>

                    <div>
                        <h3>Rutinas efectivas</h3>
                        <p>Ejercicios diseñados para tus metas.</p>
                    </div>

                </div>

                <div class="beneficio">

                    <div class="icono naranja">
                        📈
                    </div>

                    <div>
                        <h3>Seguimiento de progreso</h3>
                        <p>Monitorea tu avance y mejora día a día.</p>
                    </div>

                </div>

            </div>

        </section>


        <section class="lado-formulario">

            <form
                id="formLogin"
                class="formulario-registro"
                method="POST"
                action="index.php"
                novalidate
            >

                <h2>
                    <b>Iniciar sesión</b>
                </h2>

                <div
                    id="errorLoginUser" class="error-campo"
                ></div>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Usuario"
                >
                <div
                    id="errorLoginPassword"
                    class="error-campo"
                ></div>

                <div class="password-container">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Contraseña"
                    >

                    <span
                        class="eye-icon"
                        onclick="togglePassword('password')"
                    >
                        <img
                            src="/sc502-ln-proyecto-grupo-5-2/VidaFit/img/view.png"
                            alt="Mostrar contraseña"
                            class="password-icon">
                    </span>

                </div>


                <div
                    id="errorLogin"
                    class="error-campo"
                ></div>
                
                <p style="text-align: center; margin: 14px 0; font-size: 14px; color: #5d6880;">
                    ¿No tienes cuenta? Crea una aquí:
                    <a href="index.php?page=register" style="color: #009688; font-weight: 600; text-decoration: none;">Regístrate</a>
                </p>

                <button
                    type="submit"
                    class="btn-registro"
                >
                    Iniciar sesión
                </button>


                <div class="separador"></div>


                <footer class="terminos">
                    © 2026 VidaFit | Todos los derechos reservados
                </footer>

            </form>

        </section>

    </main>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <script
        src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/auth.js"
    ></script>

</body>

</html>