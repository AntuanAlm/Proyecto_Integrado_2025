// ================== FUNCIÓN PARA SIMULAR LA REALIZACIÓN DE UN PAGO ==================
function realizarPago() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        alert("⚠️ Tu carrito está vacío. Agrega un producto antes de proceder.");
        console.error("Error: No hay productos en localStorage.");
        window.location.href = "../../html/precio/precio.html";
        return;
    }

    fetch("../../php/verificar_usuario_pago/verificar_usuario.php")
        .then(response => response.json())
        .then(data => {
            console.log("Estado de sesión:", data.sesion_activa);

            if (!data.sesion_activa) {
                alert("⚠️ Debes iniciar sesión para realizar la compra.");
                window.location.href = "../../html/login_usuario/login_usuario.html";
            } else {
                // 🔹 Simular pago después de confirmar sesión
                setTimeout(() => {
                    alert("✅ Pago simulado con éxito.");
                    registrarCompra(carrito);
                }, 2000);
            }
        })
        .catch(error => console.error("Error al verificar sesión:", error));
}

// ================== FUNCIÓN PARA REGISTRAR LA COMPRA EN EL SERVIDOR ==================
function registrarCompra(carrito) {
    console.log("Enviando compra al servidor:", carrito);

    // 🔹 Transformamos los datos para asegurarnos de que cada producto tiene su cantidad reflejada
    let carritoProcesado = carrito.map(item => ({
        nombre: item.nombre,
        precioUnitario: item.precio,
        cantidad: item.cantidad,
        precioTotal: item.precio * item.cantidad // ✅ Multiplicamos el precio por la cantidad
    }));

    fetch("../../php/registrar_compra/registrar_comprar.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ carrito: carritoProcesado }) // ✅ Enviar datos corregidos
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta del servidor:", data);
        
        if (data.success) {
            alert("✅ Compra registrada con éxito.");
            localStorage.removeItem("carrito"); // 🔹 Vaciar carrito tras el pago
            window.location.href = "../../html/agradecimiento_pago/agradecimiento_pago.html";
        } else {
            alert("⚠️ Error al registrar la compra: " + data.error);
        }
    })
    .catch(error => console.error("Error al registrar la compra:", error));
}

// ================== FUNCIÓN PARA AGREGAR PRODUCTOS AL CARRITO ==================
function agregarAlCarrito(nombre, precio, tipo) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    let itemExistente = carrito.find(item => item.nombre === nombre);
    if (itemExistente) {
        itemExistente.cantidad += 1;
    } else {
        carrito.push({ nombre, precio, tipo, cantidad: 1 });
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));
    console.log("Carrito actualizado:", carrito); // 🔹 Ver datos en la consola
    alert(`✅ ${nombre} añadido al carrito.`);
}
