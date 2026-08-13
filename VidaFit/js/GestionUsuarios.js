$(function () {

    const urlBase = "index.php";


    function cargarUsuario() {

        $.get(
            urlBase + '?option=obtenerUsuarioActual',

            function (res) {

                console.log(res);

                if (res.response !== '00') {

                    console.log(
                        'Error al cargar usuario:',
                        res.message
                    );

                    return;
                }

                const usuario = res.usuario;


                $('#nombreUsuario').text(
                    usuario.username
                );


                $('.nombreCompletoUsuario').text(
                    usuario.nombre_completo
                );


                $('#nombreCompletoInput').val(
                    usuario.nombre_completo
                );


                $('#correoUsuarioInput').val(
                    usuario.correo
                );


                if (parseInt(usuario.id_rol) === 1) {

                    $('#rolUsuario').text(
                        'Paciente'
                    );

                } else if (parseInt(usuario.id_rol) === 2) {

                    $('#rolUsuario').text(
                        'Profesional'
                    );

                } else {

                    $('#rolUsuario').text(
                        'Usuario'
                    );
                }
            },

            'json'
        );
    }


    window.cambiarContrasena = function () {

        const actual = $('#passActual').val();
        const nueva = $('#nuevaContrasenna').val();
        const confirmar = $('#confirmarContrasenna').val();


       
        $('#errorActual').text('');
        $('#errorNueva').text('');
        $('#errorConfirmar').text('');
        $('#mensajePass').text('');


  
        if (actual.trim() === '') {

            $('#errorActual').text(
                'Ingrese su contraseña actual.'
            );

            return;
        }


        if (nueva.length < 8) {

            $('#errorNueva').text(
                'La contraseña debe tener mínimo 8 caracteres.'
            );

            return;
        }


        if (nueva !== confirmar) {

            $('#errorConfirmar').text(
                'Las contraseñas no coinciden.'
            );

            return;
        }


       
        $.post(
            urlBase,

            {
                option: 'cambiarContrasenna',
                contrasenna_actual: actual,
                nueva_contrasenna: nueva,
                confirmar_contrasenna: confirmar
            },

            function (res) {

                console.log(res);


                if (res.response === '00') {

                    $('#mensajePass').text(
                        res.message
                    );


                    // Limpiar campos
                    $('#passActual').val('');
                    $('#nuevaContrasenna').val('');
                    $('#confirmarContrasenna').val('');

                } else {

                    $('#errorActual').text(
                        res.message
                    );
                }
            },

            'json'
        );
    };



    $('#btnLogout').on('click', function () {

        $.post(
            urlBase,

            {
                option: 'logout'
            },

            function (res) {

                if (res.response === '00') {

                    window.location.href =
                        'index.php?page=login';

                } else {

                    alert(
                        res.message ||
                        'No se pudo cerrar la sesión.'
                    );
                }
            },

            'json'
        );
    });


    cargarUsuario();

});