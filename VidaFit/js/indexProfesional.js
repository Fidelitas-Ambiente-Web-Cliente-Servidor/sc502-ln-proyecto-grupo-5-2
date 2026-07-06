function mostrarProximamente(seccion) {
    let toast = document.getElementById('toastProximamente');
    toast.textContent = seccion + ' estará disponible próximamente.';
    toast.classList.add('visible');

    setTimeout(function () {
        toast.classList.remove('visible');
    }, 3000);
}
