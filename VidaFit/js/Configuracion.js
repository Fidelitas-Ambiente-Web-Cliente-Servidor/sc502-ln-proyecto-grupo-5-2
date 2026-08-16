function togglePass(idCampo) {
    let input = document.getElementById(idCampo);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}