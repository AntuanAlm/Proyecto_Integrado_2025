// Función para agregar un artículo al carrito


/**
 * Agrega un producto al carrito de compras almacenado en el localStorage.
 * Si el producto ya existe en el carrito, incrementa su cantidad.
 * Si no existe, lo añade como un nuevo elemento.
 *
 * @param {string} nombre - El nombre del producto.
 * @param {number} precio - El precio del producto.
 * @param {string} tipo - El tipo o categoría del producto.
 *
 * @description Se utiliza JSON para convertir el carrito a un formato de texto (JSON.stringify)
 * y almacenarlo en localStorage, ya que localStorage solo puede guardar cadenas de texto.
 * Al recuperar el carrito, se usa JSON.parse para convertirlo de nuevo a un objeto JavaScript.
 */

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

// Función para mostrar/ocultar el menú del carrito
function toggleCarrito() {
    const menu = document.getElementById("carrito-menu");
    menu.classList.toggle("visible");
}

// Cargar el contenido del carrito cuando la página se carga
document.addEventListener('DOMContentLoaded', actualizarCarrito);
