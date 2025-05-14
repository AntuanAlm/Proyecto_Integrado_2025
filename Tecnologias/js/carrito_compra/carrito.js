// Función para agregar un artículo al carrito
function agregarAlCarrito(nombre, precio, tipo) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    let itemExistente = carrito.find(item => item.nombre === nombre);
    if (itemExistente) {
        itemExistente.cantidad += 1;
    } else {
        carrito.push({ nombre, precio, tipo, cantidad: 1 });
    }

    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarCarrito();
}

// Función para eliminar un artículo del carrito
function eliminarDelCarrito(nombre) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito = carrito.filter(item => item.nombre !== nombre);
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarCarrito();
}

// Función para actualizar la visualización del carrito
function actualizarCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let carritoItems = document.getElementById('carrito-items');
    let totalElement = document.getElementById('total-carrito');
    let contadorCarrito = document.getElementById('carrito-count');

    // Limpiar contenido previo
    carritoItems.innerHTML = '';
    let total = 0;
    let cantidadTotal = 0;

    carrito.forEach(item => {
        let itemElement = document.createElement('div');
        itemElement.classList.add('carrito-item');
        itemElement.innerHTML = `
            <span>${item.nombre} - ${item.precio}€ x ${item.cantidad}</span>
            <button class="eliminar" onclick="eliminarDelCarrito('${item.nombre}')">🗑️</button>
        `;
        carritoItems.appendChild(itemElement);

        total += item.precio * item.cantidad;
        cantidadTotal += item.cantidad;
    });

    totalElement.textContent = `${total.toFixed(2)}€`;

    // Actualizar contador en el ícono del carrito
    contadorCarrito.textContent = cantidadTotal;

    // Mostrar/ocultar secciones según estado del carrito
    if (carrito.length > 0) {
        document.getElementById('carrito-vacio').style.display = 'none';
        document.getElementById('carrito-contenido').style.display = 'flex';
    } else {
        document.getElementById('carrito-vacio').style.display = 'block';
        document.getElementById('carrito-contenido').style.display = 'none';
    }
}

function verificarSesionAntesDePagar() {
    fetch("../../php/verificar_usuario_pago/verificar_usuario.php")  // Ajusta la ruta según la ubicación correcta

        .then(response => response.json())
        .then(data => {
            console.log("Estado de sesión:", data.sesion_activa); // Para depuración

            if (data.sesion_activa) {
                // ✅ Usuario autenticado → Redirigir a la pasarela de pago
                window.location.href = "http://localhost/Proyecto_Integrado_2025/Tecnologias/html/pasarela_pago/pasarela_pago.html";
            } else {
                // ❌ Usuario NO autenticado → Redirigir a login después de mostrar alerta
                alert("Debes iniciar sesión para proceder con el pago.");
                window.location.href = "http://localhost/Proyecto_Integrado_2025/Tecnologias/html/login_usuario/login_usuario.html";
            }
        })
        .catch(error => console.error("Error verificando sesión:", error));
}




// Asegurar que el evento del botón se asigne correctamente después de que el DOM se cargue
document.addEventListener('DOMContentLoaded', function () {
    actualizarCarrito(); // Asegurar que el carrito se carga correctamente al iniciar la página

    const btnPagar = document.querySelector(".btn-pago"); // Asegura que busca por clase
    if (btnPagar) {
        btnPagar.addEventListener("click", verificarSesionAntesDePagar);
    }
});

// Función para mostrar/ocultar el menú del carrito
function toggleCarrito() {
    const menu = document.getElementById("carrito-menu");
    menu.classList.toggle("visible");
}
