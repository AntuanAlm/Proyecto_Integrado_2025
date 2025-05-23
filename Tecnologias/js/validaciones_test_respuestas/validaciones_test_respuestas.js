document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formularioTest").addEventListener("submit", function(event) {
        const respuestasMarcadas = document.querySelectorAll('input[type="radio"]:checked');

        if (respuestasMarcadas.length === 0) {
            event.preventDefault();

            alert("Oye, que no has respondido ninguna pregunta.");
            const confirmar = confirm("¿Estás seguro que quieres enviar el test?");
            if (confirmar) {
                this.submit();
            } else {
                return false;
            }
        }
    });
});
