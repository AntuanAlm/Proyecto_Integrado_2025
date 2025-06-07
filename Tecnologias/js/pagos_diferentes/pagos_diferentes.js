function mostrarFormulario(tipo) {
    localStorage.setItem("metodoPago", tipo); // Guardamos el método de pago
    const formularioPago = document.getElementById("formulario-pago");
    const finalizarPago = document.getElementById("finalizarPago");

    formularioPago.innerHTML = "";
    formularioPago.style.display = "block";
    finalizarPago.style.display = "block";

    if (tipo === "Bizum") {
        formularioPago.innerHTML = `
            <h2>Pago con Bizum</h2>
            <label for="telefono">Número de Teléfono:</label>
            <input type="text" id="telefono" maxlength="9" placeholder="Introduce tu móvil">
        `;
    } else if (tipo === "Tarjeta") {
        formularioPago.innerHTML = `
            <h2>Pago con Tarjeta</h2>
            <label for="numero">Número de Tarjeta:</label>
            <input type="text" id="numero" maxlength="19" placeholder="1234 5678 9012 3456">
            <label for="fecha">Expiración:</label>
            <input type="text" id="fecha" placeholder="MM/AA">
            <label for="cvv">CVV:</label>
            <div style="display: flex; align-items: center;">
          <input type="password" id="cvv" maxlength="3" placeholder="123" style="margin-right:5px;">
          <button type="button" id="toggle-cvv" tabindex="-1" style="padding:2px 8px;">👁️</button>
            </div>
        `;

        // Agrega el evento para mostrar/ocultar el CVV
        setTimeout(() => {
            const cvvInput = document.getElementById("cvv");
            const toggleBtn = document.getElementById("toggle-cvv");
            if (cvvInput && toggleBtn) {
          toggleBtn.addEventListener("click", function() {
              if (cvvInput.type === "password") {
            cvvInput.type = "text";
            toggleBtn.textContent = "👁️‍🗨️";
              } else {
            cvvInput.type = "password";
            toggleBtn.textContent = "👁️";
              }
          });
            }
        }, 0);
    } else if (tipo === "PayPal") {
        formularioPago.innerHTML = `
            <h2>Pago con PayPal</h2>
            <label for="paypal-email">Correo electrónico de PayPal:</label>
            <input type="email" id="paypal-email" placeholder="usuario@ejemplo.com">
            <label for="paypal-password">Contraseña:</label>
            <input type="password" id="paypal-password" placeholder="Contraseña">
        `;
    }
}


document.addEventListener("input", function(event) {
    if (event.target.id === "telefono" || event.target.id === "numero" || event.target.id === "cvv") {
        event.target.value = event.target.value.replace(/\D/g, ""); // Solo números
    }
});
