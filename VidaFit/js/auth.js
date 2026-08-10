$(function () {

    const urlBase = "index.php";

    //Para inicio de sesion

$("#formLogin").on("submit", function (event) {

    event.preventDefault();

    let username = $("#username").val().trim();
    let password = $("#password").val();

    let valido = true;

    $("#errorLoginUser").text("");
    $("#errorLoginPassword").text("");
    $("#errorLogin").text("");


    if (username === "") {

        $("#errorLoginUser").text( "El usuario es obligatorio." );

        valido = false;
    }


    if (password === "") {

        $("#errorLoginPassword").text("La contraseña es obligatoria." );

        valido = false;

    } else if (password.length < 8) {

        $("#errorLoginPassword").text(
            "La contraseña debe tener mínimo 8 caracteres."
        );

        valido = false;
    }
    if (!valido) {
        return;
    }


    $.post(
        urlBase,
        {
            username: username,
            password: password,
            option: "login"
        },

        function (data) {

            if (data.response === "00") {

                if (parseInt(data.id_rol) === 1) {

                    // Paciente
                    window.location.href ="index.php?page=indexPaciente";

                } else if (parseInt(data.id_rol) === 2) {

                    // Profesional
                    window.location.href ="index.php?page=indexProfesional";

                } else {

                    $("#errorLogin").text("El usuario tiene un rol no válido."  );
                }

            } else {

                $("#errorLogin").text(  data.message);
            }

        },

        "json"
    );

});

//Para registro

    $("#formRegister").on("submit", function (event) {

        event.preventDefault();

        let nombre = $("#nombre").val().trim();
        let username = $("#usernameRegistro").val().trim();
        let correo = $("#correo").val().trim();
        let password = $("#contraseña").val();
        let confirmPassword = $("#confirm_password").val();
        let idRol = $('input[name="id_rol"]:checked').val();

        let valido = true;

      
        $("#errorNombre").text("");
        $("#errorUser").text("");
        $("#errorCorreo").text("");
        $("#errorContraseña").text("");
        $("#errorRol").text("");
        $("#errorRegistro").text("");


        if (nombre === "") {
            $("#errorNombre").text("El nombre es obligatorio.");
            valido = false;
        } else if (nombre.length < 5) {
            $("#errorNombre").text("El nombre debe tener mínimo 5 caracteres.");
            valido = false;
        }

        if (username === "") {
            $("#errorUser").text("El usuario es obligatorio.");
            valido = false;
        } else if (username.length < 4) {
            $("#errorUser").text("El usuario debe tener mínimo 4 caracteres.");
            valido = false;
        }


        if (correo === "") {
            $("#errorCorreo").text("El correo es obligatorio.");
            valido = false;
        }


     
        if (password === "") {
            $("#errorContraseña").text("La contraseña es obligatoria.");
            valido = false;
        } else if (password.length < 8) {
            $("#errorContraseña").text(
                "La contraseña debe tener mínimo 8 caracteres."
            );
            valido = false;
        } else if (password !== confirmPassword) {
            $("#errorContraseña").text(
                "Las contraseñas no coinciden."
            );
            valido = false;
        }


        if (!idRol) {
            $("#errorRol").text("Debe seleccionar un rol.");
            valido = false;
        }


   
        if (!valido) {
            return;
        }
       
        $.post(
            urlBase,
            {
                nombre_completo: nombre,
                username: username,
                correo: correo,
                password: password,
                confirm_password: confirmPassword,
                id_rol: idRol,
                option: "register"
            },
            function (data) {

                if (data.response === "00") {

                    window.location.href = "index.php?page=login"; } else {

                    $("#errorRegistro").text(data.message);
                }

            },
            "json"
        );

    });

window.togglePassword = function (idCampo) {

    let campo = document.getElementById(idCampo);

    if (!campo) {
        return;
    }

    if (campo.type === "password") {
        campo.type = "text";
    } else {
        campo.type = "password";
    }
};


});