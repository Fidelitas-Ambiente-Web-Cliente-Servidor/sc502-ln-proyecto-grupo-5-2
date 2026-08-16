$(function () {

    const urlBase = "index.php";

    function cargarProgreso() {

        $.get(
            urlBase + '?option=listarProgreso',

            function (res) {

                console.log(res);

                if (res.response !== '00') {
                    console.log('Error al cargar progreso:', res.message);
                    return;
                }


                const registros = res.registros;


               
                if (!registros || registros.length === 0) {

                    $('#pesoInicial').text('0.0');
                    $('#pesoActual').text('0.0');
                    $('#pesoIdeal').text('0.0');
                    $('#imcActual').text('0.0');

                    $('#estadoNutricional').text('Sin registros');

                    $('#pesoPerdido').text('');
                    $('#pesoRestante').text('');

                    $('#listaRegistros').html(
                        '<p class="text-muted">No hay registros de peso.</p>'
                    );

                   
                    establecerRegistrosPeso([]);

                    return;
                }

                const actual = registros[0];

        
                const inicial = registros[registros.length - 1];


                cargarTarjetas(actual, inicial);

                cargarListaRegistros(registros);

                cargarGrafico(registros);
            },

            'json'
        );
    }



    function cargarTarjetas(actual, inicial) {

        const pesoActual = parseFloat(actual.peso_kg);
        const pesoInicial = parseFloat(inicial.peso_kg);
        const pesoIdeal = parseFloat(actual.peso_ideal);
        const imc = parseFloat(actual.imc);


  
        $('#pesoInicial').text(
            pesoInicial.toFixed(1)
        );


        
        $('#pesoActual').text(
            pesoActual.toFixed(1)
        );


   
        $('#pesoIdeal').text(
            pesoIdeal.toFixed(1)
        );


        $('#imcActual').text(
            imc.toFixed(1)
        );


       
        $('#estadoNutricional').text(
            actual.estado_nutricional || 'Sin información'
        );




        const diferencia = pesoInicial - pesoActual;


        if (diferencia > 0) {

            $('#pesoPerdido').text(
                '↓ ' + diferencia.toFixed(1) + ' kg perdidos'
            );

        } else if (diferencia < 0) {

            $('#pesoPerdido').text(
                '↑ ' + Math.abs(diferencia).toFixed(1) + ' kg aumentados'
            );

        } else {

            $('#pesoPerdido').text(
                'Sin cambios'
            );
        }


        const restante = pesoActual - pesoIdeal;


        if (restante > 0) {

            $('#pesoRestante').text(
                restante.toFixed(1) + ' kg restantes'
            );

        } else {

            $('#pesoRestante').text(
                'Meta alcanzada'
            );
        }

        if (inicial.fecha_registro) {

            const fecha = inicial.fecha_registro.substring(0, 10);

            const partes = fecha.split('-');

            $('#fechaPesoInicial').text(
                partes[2] + '/' + partes[1] + '/' + partes[0]
            );
        }
    }


    function cargarListaRegistros(registros) {

        const $lista = $('#listaRegistros');

        $lista.empty();


        const recientes = registros.slice(0, 5);


        recientes.forEach(function (registro) {

            const fecha = registro.fecha_registro.substring(0, 10);

            const partes = fecha.split('-');

            const fechaLegible =
                partes[2] + '/' +
                partes[1] + '/' +
                partes[0];


            const item = `
                <div class="registro-peso">

                    <span class="reg-fecha">
                        ${fechaLegible}
                    </span>

                    <span class="reg-valor">
                        ${parseFloat(registro.peso_kg).toFixed(1)} kg
                    </span>

                </div>
            `;


            $lista.append(item);
        });
    }

    function cargarGrafico(registros) {

        const datosGrafico = registros.map(function (registro) {

            return {

                fecha: registro.fecha_registro.substring(0, 10),

                peso: parseFloat(registro.peso_kg)

            };

        });


        datosGrafico.reverse();


        establecerRegistrosPeso(datosGrafico);
    }

    window.registrarPeso = function () {

        const inputPeso = $('#nuevoPeso');

        const inputAltura = $('#alturaPeso');

        const inputFecha = $('#fechaPeso');

        const errorDiv = $('#errorPeso');


        errorDiv.text('');


        const peso = parseFloat(inputPeso.val()); // Toma el peso

        const alturaTexto = inputAltura.val(); // Toma la altura

        const altura = alturaTexto === '' ? null : parseFloat(alturaTexto);

        const fecha = inputFecha.val();


        if (isNaN(peso) || peso < 30 || peso > 300) {

            errorDiv.text(
                'Ingrese un peso válido entre 30 y 300 kg.'
            );

            return;
        }

        if (altura !== null && (isNaN(altura) || altura < 1 || altura > 2.5)) {

            errorDiv.text(
                'Ingrese una altura válida en metros (entre 1.00 y 2.50).'
            );

            return;
        }


        if (fecha === '') {

            errorDiv.text(
                'Seleccione una fecha.'
            );

            return;
        }

        const datosPost = {
            option: 'crearProgreso',
            peso_kg: peso,
            fecha_registro: fecha
        };

        if (altura !== null) {
            datosPost.altura_m = altura;
        }

        $.post(

            urlBase,

            datosPost,

            function (res) {

                console.log(res);


                if (res.response === '00') {

                    inputPeso.val('');
                    inputAltura.val('');
                    inputFecha.val('');

                    cargarProgreso();

                } else {

                    errorDiv.text(
                        res.message || 'Error al registrar el peso.'
                    );
                }
            },

            'json'
        );
    };


    cargarProgreso();

});