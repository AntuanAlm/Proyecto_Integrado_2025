
//   Este script gestiona la lógica para añadir productos al carrito de compras en la página de precios.
//   - Antes de añadir un producto, consulta al servidor para verificar si el usuario ya ha comprado el producto seleccionado.
//   - Impide que se añadan productos únicos (no recurrentes) más de una vez al carrito.
//   - Permite la compra múltiple solo de productos definidos como recurrentes.
//   - Valida que el precio recibido sea un número válido antes de añadirlo al carrito.
//   - Fusiona la lógica del carrito local (localStorage) para actualizar cantidades o añadir nuevos productos.
//   - Actualiza la visualización del carrito y muestra alertas informativas al usuario según la acción realizada.


function agregarAlCarrito(nombre, precio, tipo) {
    fetch("http://localhost/Proyecto_Integrado_2025/Tecnologias/php/verificar_usuario_pago/verificar_usuario.php")
        .then(response => response.json())
        .then(data => {
            // 🔹 Lista de productos que se pueden comprar múltiples veces
            let productosRecurrentes = ["Práctico", "Pack de 10 Clases Prácticas", "Pack de 20 Clases Prácticas", "Curso Intensivo"];

            if (!productosRecurrentes.includes(nombre) && data.productos_comprados.includes(nombre)) {
                alert(`❌ Ya has comprado '${nombre}'. No puedes añadirlo nuevamente.`);
                return; // 🔹 Bloquea la acción antes de que cause errores
            }
            // no puedes comprar el pack completo si ya has comprado el teórico o práctico porque lo he limitado a 1 desde el php.

            // 🔹 Asegura que el precio es un número válido
            precio = parseFloat(precio); 
            if (isNaN(precio)) {
                console.error(`⚠️ Error: Precio inválido para '${nombre}'. Valor recibido:`, precio);
                alert(`❌ Error: El precio de '${nombre}' es inválido.`);
                return;
            }

            // 🔹 Manejo del carrito fusionando lógica de `carrito.js`
            let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            let itemExistente = carrito.find(item => item.nombre === nombre);

            if (itemExistente) {
                itemExistente.cantidad += 1;
            } else {
                carrito.push({ nombre, precio: Number(precio), tipo, cantidad: 1 });
            }

            localStorage.setItem("carrito", JSON.stringify(carrito));
            actualizarCarrito(); // Refresca la visualización del carrito

            alert(`✅ '${nombre}' ha sido añadido al carrito.`);
        })
        .catch(error => console.error("Error al verificar compras antes de añadir al carrito:", error));
}
