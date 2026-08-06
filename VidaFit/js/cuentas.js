const CLAVE_CUENTAS = 'vidafit_cuentas';
const CLAVE_SESION = 'vidafit_sesion';
const CLAVE_RECORDAR_LOGIN = 'vidafit_recordar_login';

function obtenerCuentas() {
    let datos = localStorage.getItem(CLAVE_CUENTAS);
    if (!datos) return [];
    try {
        return JSON.parse(datos);
    } catch (error) {
        return [];
    }
}

function guardarCuentas(cuentas) {
    localStorage.setItem(CLAVE_CUENTAS, JSON.stringify(cuentas));
}

function normalizarIdentificador(texto) {
    return texto.trim().toLowerCase().replace(/\s+/g, ' ');
}

function coincideIdentificadorCuenta(cuenta, identificador) {
    let identificadorNormalizado = normalizarIdentificador(identificador);
    let nombreNormalizado = normalizarIdentificador(cuenta.nombre);
    let correoNormalizado = cuenta.correo.trim().toLowerCase();

    return nombreNormalizado === identificadorNormalizado ||
        correoNormalizado === identificadorNormalizado;
}

function registrarCuenta(datos) {
    let cuentas = obtenerCuentas();
    let correoExiste = cuentas.some(function (cuenta) {
        return cuenta.correo.toLowerCase() === datos.correo.toLowerCase();
    });

    if (correoExiste) {
        return {
            ok: false,
            mensaje: 'Este correo ya está registrado. Inicie sesión o use otro correo.'
        };
    }

    cuentas.push({
        nombre: datos.nombre.trim(),
        correo: datos.correo.trim().toLowerCase(),
        contraseña: datos.contraseña,
        rol: datos.rol
    });
    guardarCuentas(cuentas);

    return { ok: true };
}

function iniciarSesion(identificador, contraseña, rol) {
    let cuentas = obtenerCuentas();

    if (cuentas.length === 0) {
        return {
            ok: false,
            mensaje: 'Debe crear una cuenta antes de ingresar al sistema.'
        };
    }

    let cuenta = cuentas.find(function (item) {
        return coincideIdentificadorCuenta(item, identificador) &&
            item.contraseña === contraseña &&
            item.rol === rol;
    });

    if (!cuenta) {
        return {
            ok: false,
            mensaje: 'No se encontró una cuenta con esos datos. Puede ingresar con su correo o nombre completo.'
        };
    }

    localStorage.setItem(CLAVE_SESION, JSON.stringify({
        nombre: cuenta.nombre,
        correo: cuenta.correo,
        rol: cuenta.rol
    }));

    return { ok: true, cuenta: cuenta };
}

function obtenerSesion() {
    let datos = localStorage.getItem(CLAVE_SESION);
    if (!datos) return null;

    try {
        return JSON.parse(datos);
    } catch (error) {
        return null;
    }
}

function cerrarSesionUsuario() {
    localStorage.removeItem(CLAVE_SESION);
    eliminarDatosLogin();
    window.location.href = '/sc502-ln-proyecto-grupo-5-2/VidaFit/views/inicioSesion.html';
}

function guardarDatosLogin(identificador, contraseña, rol) {
    localStorage.setItem(CLAVE_RECORDAR_LOGIN, JSON.stringify({
        identificador: identificador,
        contraseña: contraseña,
        rol: rol
    }));
}

function cargarDatosLogin() {
    let datos = localStorage.getItem(CLAVE_RECORDAR_LOGIN);

    if (!datos) {
        return null;
    }

    try {
        return JSON.parse(datos);
    } catch (error) {
        return null;
    }
}

function eliminarDatosLogin() {
    localStorage.removeItem(CLAVE_RECORDAR_LOGIN);
}

function paginaEsPublica() {
    let ruta = window.location.pathname.split('/').pop();

    if (!ruta || ruta === '') return true;

    return ruta === 'inicioSesion.html' || ruta === 'registro.html';
}

function protegerPagina() {
    if (paginaEsPublica()) return;

    let sesion = obtenerSesion();
    if (!sesion) {
        window.location.href = '/sc502-ln-proyecto-grupo-5-2/VidaFit/views/inicioSesion.html';
        return;
    }

    let ruta = window.location.pathname.split('/').pop();
    let paginasPaciente = [
        'indexPaciente.html',
        'perfil.html',
        'PlanNutricional.html',
        'Miprogreso.html',
        'Citas.html',
        'Configuracion.html'
    ];
    let paginasProfesional = [
        'indexProfesional.html',
        'GestionarRutinas.html',
        'ConfiguracionProfesional.html',
        'GestionarPlanes.php'
    ];

    if (sesion.rol === 'paciente' && paginasProfesional.indexOf(ruta) !== -1) {
        window.location.href = '/sc502-ln-proyecto-grupo-5-2/VidaFit/indexPaciente.html';
        return;
    }

    if (sesion.rol === 'profesional' && paginasPaciente.indexOf(ruta) !== -1) {
        window.location.href = '/sc502-ln-proyecto-grupo-5-2/VidaFit/indexProfesional.html';
    }
}