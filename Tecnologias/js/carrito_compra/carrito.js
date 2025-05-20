// ================== FUNCIÓN PARA AGREGAR PRODUCTOS AL CARRITO ==================
function agregarAlCarrito(nombre, precio, tipo) {
    fetch("../../php/verificar_usuario_pago/verificar_usuario.php")
        .then(response => response.json())
        .then(data => {
            let productosRecurrentes = ["Práctico", "Pack de 10 Clases Prácticas", "Pack de 20 Clases Prácticas", "Curso Intensivo"];
            let productosComprados = data.productos_comprados || [];

            if (!productosRecurrentes.includes(nombre) && productosComprados.includes(nombre)) {
                alert(`❌ Ya has comprado '${nombre}'. No puedes añadirlo nuevamente.`);
                return;
            }

            precio = parseFloat(precio);
            if (isNaN(precio)) {
                console.error(`⚠️ Error: Precio inválido para '${nombre}'. Valor recibido:`, precio);
                alert(`❌ Error: El precio de '${nombre}' es inválido.`);
                return;
            }

            let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            let itemExistente = carrito.find(item => item.nombre === nombre);

            if (itemExistente) {
                itemExistente.cantidad += 1;
            } else {
                carrito.push({ nombre, precio: Number(precio), tipo, cantidad: 1 });
            }

            localStorage.setItem("carrito", JSON.stringify(carrito));
            actualizarCarrito();
            alert(`✅ '${nombre}' ha sido añadido al carrito.`);
        })
        .catch(error => console.error("Error al verificar compras antes de añadir al carrito:", error));
}

// ================== FUNCIÓN PARA ELIMINAR UN PRODUCTO DEL CARRITO ==================
function eliminarDelCarrito(nombre) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    // Eliminar el producto por nombre
    carrito = carrito.filter(item => item.nombre !== nombre);
    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarCarrito();
}

// ================== FUNCIÓN PARA ACTUALIZAR LA VISUALIZACIÓN DEL CARRITO ==================
function actualizarCarrito() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    let carritoItems = document.getElementById("carrito-items");
    let totalElement = document.getElementById("total-carrito");
    let contadorCarrito = document.getElementById("carrito-count");
    let mensajeVacio = document.getElementById("carrito-vacio");

    if (!carritoItems || !totalElement || !contadorCarrito || !mensajeVacio) {
        console.error("⚠️ Error: Elementos del carrito no encontrados en el HTML. Verifica que los IDs existen.");
        return;
    }

    carritoItems.innerHTML = "";
    let total = 0;
    let cantidadTotal = 0;

    if (carrito.length === 0) {
        mensajeVacio.style.display = "block";
        carritoItems.style.display = "none";
        totalElement.textContent = "0.00€";
        contadorCarrito.textContent = "0";
        return;
    } else {
        mensajeVacio.style.display = "none";
        carritoItems.style.display = "block";
    }

    carrito.forEach(item => {
        let itemElement = document.createElement("div");
        itemElement.classList.add("carrito-item");
        itemElement.innerHTML = `
            <span>${item.nombre} - ${item.precio.toFixed(2)}€ x ${item.cantidad}</span>
            <button class="eliminar" onclick="eliminarDelCarrito('${item.nombre.replace(/'/g, "\\'")}')">🗑️</button>
        `;
        carritoItems.appendChild(itemElement);

        total += item.precio * item.cantidad;
        cantidadTotal += item.cantidad;
    });

    totalElement.textContent = `${total.toFixed(2)}€`;
    contadorCarrito.textContent = cantidadTotal;
}

// ================== VERIFICAR SESIÓN ANTES DE PAGAR ==================
function verificarSesionAntesDePagar() {
    fetch("../../php/verificar_usuario_pago/verificar_usuario.php")
        .then(response => response.json())
        .then(data => {
            console.log("Estado de sesión:", data.sesion_activa);

            if (data.sesion_activa) {
                let carrito = [];
                try {
                  const stored = localStorage.getItem("carrito");
                  carrito = stored ? JSON.parse(stored) : [];
                  } catch (e) {
                  carrito = [];
                  }

                if (!Array.isArray(carrito) || carrito.length === 0) {
    alert("❌ Tu carrito está vacío. Agrega productos antes de proceder al pago.");
    return;
}

                // 🔹 Procesar el carrito y calcular el total general
                let carritoProcesado = carrito.map(item => ({
                    nombre: item.nombre,
                    precioUnitario: item.precio,
                    cantidad: item.cantidad,
                    precioTotal: parseFloat((item.precio * item.cantidad).toFixed(2))
                }));

                let totalCarrito = carritoProcesado.reduce((sum, item) => sum + item.precioTotal, 0);
                totalCarrito = totalCarrito.toFixed(2);

                let datosPago = {
                    carrito: carritoProcesado,
                    total: totalCarrito
                };

                let datosEncoded = encodeURIComponent(JSON.stringify(datosPago));

                window.location.href = `http://localhost/Proyecto_Integrado_2025/Tecnologias/html/pasarela_pago/pasarela_pago.html?datos=${datosEncoded}`;
            } else {
                alert("Debes iniciar sesión para proceder con el pago.");
                window.location.href = "http://localhost/Proyecto_Integrado_2025/Tecnologias/html/login_usuario/login_usuario.html";
            }
        })
        .catch(error => console.error("Error verificando sesión:", error));
}

// ================== ASIGNAR EVENTOS AL CARGAR EL DOM ==================
document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("carrito-items")) {
        actualizarCarrito();
    }

    const btnPagar = document.querySelector(".btn-pago");
    if (btnPagar) {
        btnPagar.addEventListener("click", verificarSesionAntesDePagar);
    }
});

// ================== FUNCIÓN PARA MOSTRAR/OCULTAR EL MENÚ DEL CARRITO ==================
function toggleCarrito() {
    const menu = document.getElementById("carrito-menu");
    if (menu) {
        menu.classList.toggle("visible");
    } else {
        console.warn("⚠️ No se encontró el menú del carrito con ID 'carrito-menu'.");
    }
}
