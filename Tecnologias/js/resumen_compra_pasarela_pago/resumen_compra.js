document.addEventListener("DOMContentLoaded", function () {
    const carritoContenedor = document.getElementById("carrito-contenedor");
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  
    function renderizarCarrito() {
      carritoContenedor.innerHTML = "";
  
      if (carrito.length === 0) {
        const vacio = document.createElement("p");
        vacio.id = "carrito-vacio";
        vacio.textContent = "Tu carrito está vacío.";
        carritoContenedor.appendChild(vacio);
        return;
      }
  
      const carritoItems = document.createElement("div");
      carritoItems.id = "carrito-items";
  
      let subtotal = 0;
  
      carrito.forEach((item, index) => {
        const itemDiv = document.createElement("div");
        itemDiv.classList.add("carrito-item", "fade-in");
  
        const nombre = document.createElement("p");
        nombre.textContent = item.nombre;
  
        const precio = document.createElement("p");
        precio.textContent = `${item.precio.toFixed(2)}€`;
  
        const eliminar = document.createElement("button");
        eliminar.textContent = "Eliminar";
        eliminar.onclick = () => {
          carrito.splice(index, 1);
          localStorage.setItem("carrito", JSON.stringify(carrito));
          renderizarCarrito();
        };
  
        itemDiv.appendChild(nombre);
        itemDiv.appendChild(precio);
        itemDiv.appendChild(eliminar);
        carritoItems.appendChild(itemDiv);
  
        subtotal += item.precio;
      });
  
      const iva = subtotal * 0.21;
      const total = subtotal + iva;
  
      const totalDiv = document.createElement("div");
      totalDiv.id = "total-carrito";
      totalDiv.classList.add("fade-in");
  
      totalDiv.innerHTML = `
        <div class="totales">
          <p>Subtotal: ${subtotal.toFixed(2)}€</p>
          <p>IVA (21%): ${iva.toFixed(2)}€</p>
          <p><strong>Total: ${total.toFixed(2)}€</strong></p>
        </div>
      `;
  
      carritoContenedor.appendChild(carritoItems);
      carritoContenedor.appendChild(totalDiv);
    }
  
    renderizarCarrito();
  });
  