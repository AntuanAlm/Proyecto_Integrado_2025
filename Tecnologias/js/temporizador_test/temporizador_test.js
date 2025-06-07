// Espera a que todo el contenido del DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function() {

    // Inicializa el tiempo total en segundos (30 minutos = 1800 segundos)
    let tiempoRestante = 1800;

    // Inicia el temporizador que se ejecuta cada 1 segundo o 1000 milisegundos
    // Utiliza setInterval para llamar a la función actualizarTemporizador cada segundo
    let intervalo = setInterval(actualizarTemporizador, 1000);

    // Función que actualiza el temporizador cada segundo
    function actualizarTemporizador() {
        // Calcula los minutos dividiendo los segundos totales entre 60
        let minutos = Math.floor(tiempoRestante / 60);

        // Calcula los segundos restantes que no forman un minuto completo
        let segundos = tiempoRestante % 60;

        // Coge el id="tiempo" y actualiza su contenido
        // Formatea los minutos y segundos para que siempre tengan 2 dígitos (como un reloj normal 09:05)
        const elementoTiempo = document.getElementById("tiempo");
        elementoTiempo.textContent = `${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;

        // Si el tiempo restante es de 60 segundos o menos, cambia el color del texto a rojo para advertir al usuario
        if (tiempoRestante <= 60) {
            elementoTiempo.style.color = "red";
        }

        // Si aún queda tiempo, lo baja a 1 segundo
        if (tiempoRestante > 0) {
            tiempoRestante--;
        } else {
            // Si el tiempo ha llegado a cero, detiene el intervalo
            clearInterval(intervalo);

            // Muestra una alerta indicando que se agotó el tiempo
            alert("¡Tiempo agotado! Enviando el test...");

            // Envía automáticamente el formulario con id="formularioTest"
            document.getElementById("formularioTest").submit();
        }
    }
});
