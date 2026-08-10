$(function () {

    $("#btnLogout").on("click", function () {

        console.log("Click en cerrar sesión");

        $.ajax({
            url: "index.php",
            type: "POST",
            dataType: "json",

            data: {
                option: "logout"
            },

            success: function (data) {

                console.log("Respuesta logout:", data);

                if (data.response === "00") {

                    window.location.href =
                        "index.php?page=login";

                } else {

                    alert(data.message || "No se pudo cerrar la sesión.");
                }
            },

            error: function (xhr, status, error) {

                console.log("Error AJAX:", error);
                console.log("Estado:", status);
                console.log("Respuesta PHP:", xhr.responseText);

                alert("Ocurrió un error al cerrar sesión.");
            }
        });

    });

});





function mostrarProximamente(seccion) {
    let toast = document.getElementById('toastProximamente');
    toast.textContent = seccion + ' estará disponible próximamente.';
    toast.classList.add('visible');

    setTimeout(function () {
        toast.classList.remove('visible');
    }, 3000);
}
