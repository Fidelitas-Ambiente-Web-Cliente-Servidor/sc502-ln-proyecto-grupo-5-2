<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vida Fit | Registrarme</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"href="/sc502-ln-proyecto-grupo-5-2/VidaFit/css/registro&inicioSesion.css"
    >
</head>


<body>

    <main class="registro-page">



        <section class="lado-imagen">

            <div class="contenido-izquierdo">


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

                    Planes nutricionales personalizados,
                    rutinas de ejercicio y seguimiento
                    profesional para lograr tus objetivos.

                </p>


                <div class="beneficio">

                    <div class="icono">
                        🌿
                    </div>

                    <div>
                        <h3>Alimentación saludable</h3>

                        <p>
                            Planes nutricionales adaptados a ti.
                        </p>
                    </div>

                </div>


                <div class="beneficio">

                    <div class="icono">
                        🏋️
                    </div>

                    <div>
                        <h3>Rutinas efectivas</h3>

                        <p>
                            Ejercicios diseñados para tus metas.
                        </p>
                    </div>

                </div>


                <div class="beneficio">

                    <div class="icono naranja">
                        📈
                    </div>

                    <div>
                        <h3>Seguimiento de progreso</h3>

                        <p>
                            Monitorea tu avance y mejora día a día.
                        </p>
                    </div>

                </div>

            </div>

        </section>



        <section class="lado-formulario">

            <form
                id="formRegister"
                class="formulario-registro"
                method="POST"
                action="index.php"
                novalidate
            >


                <h2>
                    <b>Crear cuenta</b>
                </h2>

                <div
                    id="errorNombre"
                    class="error-campo"
                ></div>

                <input
                    type="text"
                    id="nombre"
                    name="nombre_completo"
                    placeholder="Nombre completo"
                >

                <div
                    id="errorUser"
                    class="error-campo"
                ></div>

                <input
                    type="text"
                    id="usernameRegistro"
                    name="username"
                    placeholder="Usuario"
                >


                <div
                    id="errorCorreo"
                    class="error-campo"
                ></div>

                <input
                    type="email"
                    id="correo"
                    name="correo"
                    placeholder="Correo electrónico"
                >

                <div
                    id="errorContraseña"
                    class="error-campo"
                ></div>


                <div class="password-container">

                    <input
                        type="password"
                        id="contraseña"
                        name="password"
                        placeholder="Contraseña"
                        autocomplete="new-password"
                    >

                    <span
                        class="eye-icon"
                        onclick="togglePassword('contraseña')"
                    >
                        👁️
                    </span>

                </div>

                <div class="password-container">

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Confirmar contraseña"
                        autocomplete="new-password"
                    >

                    <span
                        class="eye-icon"
                        onclick="togglePassword('confirm_password')"
                    >
                        👁️
                    </span>

                </div>


                <label class="label-rol">
                    Rol
                </label>


                <div
                    id="errorRol"
                    class="error-campo"
                ></div>


                <div class="roles">


                    <!-- PACIENTE -->

                    <label class="rol-card">

                        <input
                            type="radio"
                            name="id_rol"
                            value="1"
                        >

                        <div>

                            <span class="rol-icono">
                                👤
                            </span>

                            <h3>
                                Paciente
                            </h3>

                            <p>
                                Busco mejorar mi salud
                            </p>

                        </div>

                    </label>



                    <!-- PROFESIONAL -->

                    <label class="rol-card">

                        <input
                            type="radio"
                            name="id_rol"
                            value="2"
                        >

                        <div>

                            <span class="rol-icono">
                                🩺
                            </span>

                            <h3>
                                Profesional
                            </h3>

                            <p>
                                Soy profesional de la salud
                            </p>

                        </div>

                    </label>

                </div>


                <div
                    id="errorRegistro"
                    class="error-campo"
                ></div>

                <button
                    type="submit"
                    class="btn-registro"
                >
                    Registrarte
                </button>


                <div class="separador">

                    <span></span>

                    <p>
                        o
                    </p>

                    <span></span>

                </div>


                <a
                    href="index.php?page=login"
                    class="btn-login"
                >
                    ¿Ya tienes cuenta? Iniciar sesión
                </a>



                <footer class="terminos">

                    Al registrarme, acepto los

                    <a href="#">
                        Términos
                    </a>,

                    la

                    <a href="#">
                        Política de privacidad
                    </a>

                    y la

                    <a href="#">
                        Política de cookies
                    </a>.

                </footer>


            </form>

        </section>

    </main>





    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
    ></script>

    <script
        src="/sc502-ln-proyecto-grupo-5-2/VidaFit/js/auth.js"
    ></script>


</body>

</html>