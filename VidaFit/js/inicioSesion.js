
let nombre = document.getElementById('nombre');
let correo = document.getElementById('correo');
let fechaNacimiento = document.getElementById('fechaNacimiento');
let contraseña = document.getElementById('contraseña');

function validarFormulario() {
  let valido = true;

  document.getElementById('errorNombre').textContent = '';
  document.getElementById('errorContraseña').textContent = '';

  let regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
  let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (nombre.value.trim() === '') {
    document.getElementById('errorNombre').textContent = 'El nombre es obligatorio.';
    valido = false;
  } else if (nombre.value.trim().length < 5) {
    document.getElementById('errorNombre').textContent = 'El nombre debe tener mínimo 5 caracteres.';
    valido = false;
  } else if (!regexNombre.test(nombre.value.trim())) {
    document.getElementById('errorNombre').textContent = 'El nombre solo puede contener letras y espacios.';
    valido = false;
  }


  if (contraseña.value.trim() === '') {
    document.getElementById('errorContraseña').textContent = 'La contraseña es obligatoria.';
    valido = false;
  } else if (contraseña.value.trim().length < 8) {
    document.getElementById('errorContraseña').textContent = 'La contraseña debe tener mínimo 8 caracteres.';
    valido = false;
  }

  return valido;
}

function togglePassword(){
   if(contraseña.type === "password"){
      contraseña.type = "text";
   } else {
      contraseña.type = "password";
   }
}