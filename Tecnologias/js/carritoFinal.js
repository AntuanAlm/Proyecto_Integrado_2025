// ================== AGREGAR PRODUCTO AL CARRITO ==================
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
                alert(`❌ Precio inválido para '${nombre}'.`);
                return;
            }

            let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            let existente = carrito.find(item => item.nombre === nombre);

            if (existente) {
                existente.cantidad += 1;
            } else {
                carrito.push({ nombre, precio: Number(precio), tipo, cantidad: 1 });
            }

            localStorage.setItem("carrito", JSON.stringify(carrito));
            actualizarCarrito();
            alert(`✅ '${nombre}' añadido al carrito.`);
        })
        .catch(error => console.error("❌ Error al verificar usuario:", error));
}

// ================== ELIMINAR PRODUCTO DEL CARRITO ==================
function eliminarDelCarrito(nombre) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    carrito = carrito.filter(item => item.nombre !== nombre);
    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarCarrito();
}

// ================== ACTUALIZAR VISUAL DEL CARRITO ==================
function actualizarCarrito() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    let carritoItems = document.getElementById("carrito-items");
    let totalElement = document.getElementById("total-carrito");
    let contadorCarrito = document.getElementById("carrito-count");
    let mensajeVacio = document.getElementById("carrito-vacio");

    if (!carritoItems || !totalElement || !contadorCarrito || !mensajeVacio) return;

    carritoItems.innerHTML = "";
    let total = 0, cantidadTotal = 0;

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

// ================== VERIFICAR Y PROCEDER CON EL PAGO ==================
function verificarSesionYPagar() {
    fetch("../../php/verificar_usuario_pago/verificar_usuario.php")
        .then(response => response.json())
        .then(data => {
            if (!data.sesion_activa) {
                alert("⚠️ Debes iniciar sesión para realizar la compra.");
                window.location.href = "../../html/login_usuario/login_usuario.html";
                return;
            }

            let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

            if (carrito.length === 0) {
                alert("⚠️ El carrito está vacío.");
                window.location.href = "../../html/precio/precio.html";
                return;
            }

            // 🔹 Guardamos el carrito antes de redirigir
            localStorage.setItem("carrito", JSON.stringify(carrito));

            // 🔹 Redirigir a la pasarela de pago
            window.location.href = "../../html/pasarela_pago/pasarela_pago.html";
        })
        .catch(error => console.error("❌ Error al verificar sesión:", error));
}


// ================== REGISTRAR LA COMPRA EN PHP ==================
function registrarCompra(carrito) {
    let carritoProcesado = carrito.map(item => ({
        nombre: item.nombre,
        precioUnitario: item.precio,
        cantidad: item.cantidad,
        precioTotal: item.precio * item.cantidad
    }));

    fetch("../../php/registrar_compra/registrar_comprar.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ carrito: carritoProcesado })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("✅ Compra registrada correctamente.");
            localStorage.removeItem("carrito");
            window.location.href = "../../html/agradecimiento_pago/agradecimiento_pago.html";
        } else {
            alert("❌ Error al registrar la compra: " + data.error);
        }
    })
    .catch(error => console.error("❌ Error al enviar datos al servidor:", error));
}

// ================== MOSTRAR / OCULTAR CARRITO ==================
function toggleCarrito() {
    const menu = document.getElementById("carrito-menu");
    if (menu) menu.classList.toggle("visible");
}

// ================== EVENTOS AL CARGAR ==================
document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("carrito-items")) actualizarCarrito();

    const btnPagar = document.querySelector(".btn-pago");
    if (btnPagar) btnPagar.addEventListener("click", verificarSesionYPagar);
});

function procesarPago(metodo) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        alert("⚠️ No hay productos en el carrito.");
        window.location.href = "../../html/precio/precio.html";
        return;
    }

    alert(`⏳ Procesando pago con ${metodo}...`);

    setTimeout(() => {
        alert(`✅ Pago realizado con éxito usando ${metodo}.`);
        realizarPago(carrito);
    }, 2000);
}

// ================== ENVIAR LA COMPRA AL SERVIDOR ==================
function realizarPago(carrito) {
    console.log("📢 Enviando compra al servidor:", carrito);

    fetch("../../php/registrar_compra/registrar_comprar.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ carrito })
    })
    .then(response => response.json())
    .then(data => {
        console.log("📢 Respuesta del servidor:", data);
        
        if (data.success) {
            alert("✅ Compra registrada correctamente.");
            localStorage.removeItem("carrito");
            window.location.href = "../../html/agradecimiento_pago/agradecimiento_pago.html";
        } else {
            alert("❌ Error al registrar la compra: " + data.error);
        }
    })
    .catch(error => console.error("❌ Error al enviar datos al servidor:", error));
}

