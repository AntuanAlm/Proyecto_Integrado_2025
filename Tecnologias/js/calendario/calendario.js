document.addEventListener("DOMContentLoaded", function () {
  const calendario = document.querySelector(".dias");
  const mesActual = document.querySelector(".encabezado h2");
  const botonesMes = document.querySelectorAll(".botones-mes button");
  const botonFlotante = document.querySelector(".boton-flotante");
  const menuAcciones = document.getElementById("menuAcciones");

  let eventos = JSON.parse(localStorage.getItem("eventos")) || [];
  let añoActual = 2025;
  let mesActualIndex = 5; // Estamos en junio (mes 5, ya que enero es 0) como los array empiezan en 0
  

  const meses = [
    "Enero", "Febrero", "Marzo", "Abril",
    "Mayo", "Junio", "Julio", "Agosto",
    "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];

  function formatearFechaCorrectamente(año, mes, dia) {
    return `${dia} de ${meses[mes]} de ${año}`;
  }

  function generarCalendario(año, mes) {
    calendario.innerHTML = "";
    mesActual.textContent = `${meses[mes]} ${año}`;

    const primerDia = new Date(año, mes, 1).getDay();
    const diasEnMes = new Date(año, mes + 1, 0).getDate();

    for (let i = 0; i < (primerDia === 0 ? 6 : primerDia - 1); i++) {
      const divVacio = document.createElement("div");
      divVacio.classList.add("vacío");
      calendario.appendChild(divVacio);
    }

    const hoy = new Date();
    const esHoyMes = hoy.getFullYear() === año && hoy.getMonth() === mes;

    for (let dia = 1; dia <= diasEnMes; dia++) {
      const divDia = document.createElement("div");
      divDia.textContent = dia;
      divDia.classList.add("dia");

      if (esHoyMes && hoy.getDate() === dia) {
        divDia.classList.add("hoy");
      }

      const fechaFormateada = formatearFechaCorrectamente(año, mes, dia);
      const eventosDelDia = eventos.filter(e => e.fecha === fechaFormateada);

      eventosDelDia.forEach(ev => {
        const eventoElemento = document.createElement("div");
        eventoElemento.classList.add("evento");
        eventoElemento.style.backgroundColor = ev.color;
        eventoElemento.textContent = ev.titulo;
        divDia.appendChild(eventoElemento);
      });

      divDia.addEventListener("click", () => abrirModalEvento(año, mes + 1, dia));
      calendario.appendChild(divDia);
    }
  }

  function cambiarMes(direccion) {
    mesActualIndex += direccion;
    if (mesActualIndex < 0) {
      mesActualIndex = 11;
      añoActual--;
    } else if (mesActualIndex > 11) {
      mesActualIndex = 0;
      añoActual++;
    }
    generarCalendario(añoActual, mesActualIndex);
  }

  botonesMes[0].addEventListener("click", () => cambiarMes(-1));
  botonesMes[1].addEventListener("click", () => cambiarMes(1));

  function toggleMenu() {
    menuAcciones.classList.toggle("visible");
  }

  botonFlotante.addEventListener("click", function (e) {
    if (e.target === botonFlotante || e.target.textContent.trim() === "☰") {
      toggleMenu();
    }
  });

  document.addEventListener("click", function (event) {
    if (!botonFlotante.contains(event.target) && !menuAcciones.contains(event.target)) {
      menuAcciones.classList.remove("visible");
    }
  });

  function abrirModalEvento(año, mes, dia) {
    const fechaFormateada = formatearFechaCorrectamente(año, mes - 1, dia);
    const eventosDelDia = eventos.filter(e => e.fecha === fechaFormateada);
    if (eventosDelDia.length > 0) {
      const lista = eventosDelDia.map(e => `- ${e.titulo}`).join("\n");
      alert(`Eventos del ${fechaFormateada}:\n${lista}`);
    } else {
      alert(`No hay eventos para el ${dia} de ${meses[mes - 1]} ${año}`);
    }
  }

 // ========================= AÑADIR EVENTO =========================
// Función para añadir un evento al calendario

function añadirEvento() {
  // Confirmar si el usuario desea añadir un evento
  const confirmarAñadir = confirm("¿Desea añadir un nuevo evento?");
  
  if (!confirmarAñadir) {
    return; // Si el usuario cancela, salimos de la función
  }

  const titulosPermitidos = [
    "Examen práctico",
    "Curso intensivo",
    "Examen teórico",
    "Medico",
    "Cumpleaños",
    "Reunión",
  ];

  let titulo;
  // Pedir el título hasta que sea válido
  do {
    titulo = prompt("Ingrese el título del evento: Ej: Examen práctico // Curso intensivo // Examen teórico // Médico // Cumpleaños...");
    if (!titulosPermitidos.some(t => t.toLowerCase() === titulo?.toLowerCase())) {
      if (titulo) {
        alert("Título inválido. Debe ser uno de los siguientes: " + titulosPermitidos.join(", "));
      } else {
        alert("Debe ingresar un título.");
        return; // Si no se ingresa nada, salimos de la función
      }
    }
  } while (!titulosPermitidos.some(t => t.toLowerCase() === titulo?.toLowerCase())); // Continuar pidiendo hasta que el título sea válido

  // Convertir el título ingresado a su formato original (mayúsculas/minúsculas)
  titulo = titulosPermitidos.find(t => t.toLowerCase() === titulo?.toLowerCase());

  let fecha;
  let fechaValida = false;
  // Pedir la fecha hasta que sea válida
  do {
    fecha = prompt("Ingrese la fecha en formato: día/mes/año (ejemplo: 15/5/2025)");

    if (fecha) {
      const fechaArray = fecha.split("/");
      if (fechaArray.length === 3) {
        const dia = parseInt(fechaArray[0].trim());
        const mes = parseInt(fechaArray[1].trim()) - 1;
        const año = parseInt(fechaArray[2].trim());

        const hoy = new Date();
        const fechaIngresada = new Date(año, mes, dia);

        // Verificar si la fecha es válida
        if (!isNaN(dia) && !isNaN(mes) && !isNaN(año) && 
            dia > 0 && dia <= 31 && mes >= 0 && mes <= 11) {
          
          // Verificar si la fecha no es anterior a la fecha actual ni más allá del próximo año
          if (fechaIngresada < hoy) {
            alert("La fecha no puede ser en el pasado.");
          } else if (fechaIngresada > new Date(hoy.getFullYear() + 1, hoy.getMonth(), hoy.getDate())) {
            alert("La fecha no puede ser más allá del próximo año.");
          } else {
            fechaValida = true;
          }
        } else {
          alert("Fecha inválida. Asegúrese de ingresar el día, mes y año correctamente.");
        }
      } else {
        alert("Formato de fecha incorrecto. Use: día/mes/año.");
      }
    } else {
      alert("Debe ingresar una fecha.");
    }
  } while (!fechaValida); // Continuar pidiendo hasta que la fecha sea válida

  // Determinar el tipo de evento (examen o curso) basado en el título
  let tipoEvento = titulo.toLowerCase().includes("examen") ? "examen" : "curso";

  // Validar si es un examen y cae en un fin de semana
  if (tipoEvento === "examen") {
    let diaSemana;
    do {
      const fechaArray = fecha.split("/");
      const dia = parseInt(fechaArray[0].trim());
      const mes = parseInt(fechaArray[1].trim()) - 1;
      const año = parseInt(fechaArray[2].trim());
      const fechaIngresada = new Date(año, mes, dia);
      diaSemana = fechaIngresada.getDay(); // 0 = domingo, 6 = sábado

      // Si es sábado o domingo, pedir una nueva fecha
      if (diaSemana === 0 || diaSemana === 6) { // Si es sábado o domingo
        alert("No se puede añadir un examen en fin de semana. Elija otro día.");
        fecha = prompt("Ingrese una nueva fecha en formato: día/mes/año (ejemplo: 15/5/2025)");
      }
    } while (diaSemana === 0 || diaSemana === 6); // Continuar hasta que la fecha no sea fin de semana
  }

  // Pedir color hasta que sea válido
  let colorInput;
  let colorValido = false;
  const coloresPermitidos = {
    rojo: "red",
    verde: "green",
    amarillo: "gold",
    azul: "blue",
    morado: "purple"
  };

  do {
    colorInput = prompt(
      "Elija un color para el evento (escriba uno de los siguientes en español):\nrojo, verde, amarillo, azul, morado"
    );

    const color = coloresPermitidos[colorInput?.toLowerCase()];

    if (color) {
      colorValido = true;
    } else {
      alert("Color inválido. Escriba uno de los colores permitidos.");
    }
  } while (!colorValido);

  // Verificar si ya hay 2 eventos en la fecha seleccionada
  const fechaArray = fecha.split("/");
  const dia = parseInt(fechaArray[0].trim());
  const mes = parseInt(fechaArray[1].trim()) - 1;
  const año = parseInt(fechaArray[2].trim());
  const fechaFormateada = formatearFechaCorrectamente(año, mes, dia);

  const eventosDelDia = eventos.filter(e => e.fecha === fechaFormateada);
  if (eventosDelDia.length >= 2) {
    alert("No se pueden añadir más de 2 eventos en un mismo día.");
    return;
  }

  // Añadir el evento con todos los datos
  eventos.push({ titulo, fecha: fechaFormateada, color: coloresPermitidos[colorInput.toLowerCase()], tipoEvento });
  localStorage.setItem("eventos", JSON.stringify(eventos));
  alert("Evento añadido correctamente.");
  generarCalendario(añoActual, mesActualIndex);
}

// ========================= BORRAR EVENTO =========================
// Función para borrar un evento del calendario

function borrarEvento() {
  let fecha;
  let eventoEncontrado = false;

  // Pedir la fecha hasta que se ingrese una válida
  do {
    fecha = prompt("Ingrese la fecha del evento a borrar (día/mes/año):");

    const fechaArray = fecha.split("/");
    if (fechaArray.length === 3) {
      const dia = parseInt(fechaArray[0].trim());
      const mes = parseInt(fechaArray[1].trim()) - 1;
      const año = parseInt(fechaArray[2].trim());

      const fechaFormateada = formatearFechaCorrectamente(año, mes, dia);

      // Buscar eventos en esa fecha
      const eventosEnFecha = eventos.filter(evento => evento.fecha === fechaFormateada);
      
      if (eventosEnFecha.length > 0) {
        // Si hay más de un evento, mostrar una lista para que elija cuál borrar
        if (eventosEnFecha.length > 1) {
          let listaEventos = "Elija cuál evento desea borrar:\n";
          eventosEnFecha.forEach((evento, index) => {
            listaEventos += `${index + 1}. ${evento.titulo} - ${evento.tipoEvento}\n`;
          });
          const eventoElegido = parseInt(prompt(listaEventos));

          if (eventoElegido >= 1 && eventoElegido <= eventosEnFecha.length) {
            // Borrar el evento seleccionado
            const eventoIndex = eventos.findIndex(evento => evento.fecha === fechaFormateada && evento.titulo === eventosEnFecha[eventoElegido - 1].titulo);
            eventos.splice(eventoIndex, 1);
            localStorage.setItem("eventos", JSON.stringify(eventos));
            alert("Evento eliminado.");
            generarCalendario(añoActual, mesActualIndex);
            eventoEncontrado = true;
          } else {
            alert("Opción inválida. No se borró ningún evento.");
          }
        } else {
          // Si solo hay un evento en esa fecha, borrarlo directamente
          eventos.splice(eventos.findIndex(evento => evento.fecha === fechaFormateada), 1);
          localStorage.setItem("eventos", JSON.stringify(eventos));
          alert("Evento eliminado.");
          generarCalendario(añoActual, mesActualIndex);
          eventoEncontrado = true;
        }
      } else {
        alert("No se encontró ningún evento en esa fecha.");
      }
    } else {
      alert("Formato de fecha incorrecto. Asegúrese de usar el formato: día/mes/año.");
    }
  } while (!eventoEncontrado); // Continuar pidiendo hasta que el evento sea encontrado y borrado
}

// ========================== MODIFICAR EVENTO =========================


  function modificarEvento() {
  const titulosPermitidos = [
    "Examen práctico",
    "Curso intensivo",
    "Examen teórico",
    "Medico",
    "Cumpleaños",
    "Reunión",
  ];

  const coloresPermitidos = {
    rojo: "red",
    verde: "green",
    amarillo: "gold",
    azul: "blue",
    morado: "purple",
  };

  let fecha = null;
  let fechaArray = [];

  // Pedir fecha válida
  while (true) {
    fecha = prompt("Ingrese la fecha del evento a modificar (día/mes/año):");
    if (fecha === null) return; // Cancelar
    fechaArray = fecha.split("/");
    if (fechaArray.length === 3) break;
    alert("Formato incorrecto. Usa día/mes/año.");
  }

  const dia = parseInt(fechaArray[0].trim());
  const mes = parseInt(fechaArray[1].trim()) - 1;
  const año = parseInt(fechaArray[2].trim());

  const fechaFormateada = formatearFechaCorrectamente(año, mes, dia);
  const evento = eventos.find(e => e.fecha === fechaFormateada);

  if (!evento) {
    alert("No se encontró evento en esa fecha.");
    return;
  }

  // Pedir título válido (o dejar el actual)
  let nuevoTitulo;
  while (true) {
    nuevoTitulo = prompt("Nuevo título del evento (dejar en blanco para mantener actual):", evento.titulo);
    if (nuevoTitulo === null) return; // Cancelar
    if (nuevoTitulo.trim() === "") break; // Mantener actual
    if (titulosPermitidos.includes(nuevoTitulo.trim())) {
      evento.titulo = nuevoTitulo.trim();
      break;
    } else {
      alert("Título no permitido. Usa uno de estos:\n" + titulosPermitidos.join(", "));
    }
  }

  // Pedir nueva fecha válida o dejar en blanco
  let nuevoDia;
  while (true) {
    nuevoDia = prompt("Nuevo día del evento (día/mes/año) (dejar en blanco si no deseas cambiar):");
    if (nuevoDia === null) return; // Cancelar
    if (nuevoDia.trim() === "") break; // No cambiar fecha

    const nuevoDiaArray = nuevoDia.split("/");
    if (nuevoDiaArray.length === 3) {
      const diaNuevo = parseInt(nuevoDiaArray[0].trim());
      const mesNuevo = parseInt(nuevoDiaArray[1].trim()) - 1;
      const añoNuevo = parseInt(nuevoDiaArray[2].trim());
      const nuevaFecha = new Date(añoNuevo, mesNuevo, diaNuevo);

      if (!isNaN(nuevaFecha.getTime())) {
        const nuevaFechaFormateada = formatearFechaCorrectamente(añoNuevo, mesNuevo, diaNuevo);
        evento.fecha = nuevaFechaFormateada;
        break;
      }
    }
    alert("Fecha inválida. Usa el formato día/mes/año.");
  }

  // Pedir nuevo color válido o dejar en blanco
  let nuevoColor;
  while (true) {
    nuevoColor = prompt("Nuevo color del evento (rojo, verde, amarillo, azul, morado) (dejar en blanco si no deseas cambiar):");
    if (nuevoColor === null) return; // Cancelar
    if (nuevoColor.trim() === "") break; // No cambiar color

    const colorElegido = coloresPermitidos[nuevoColor.toLowerCase().trim()];
    if (colorElegido) {
      evento.color = colorElegido;
      break;
    }
    alert("Color inválido. Usa uno de estos: " + Object.keys(coloresPermitidos).join(", "));
  }

  // Guardar cambios
  localStorage.setItem("eventos", JSON.stringify(eventos));
  alert("Evento modificado correctamente.");
  generarCalendario(añoActual, mesActualIndex);
}


  
  document.getElementById("btnAñadir").addEventListener("click", añadirEvento);
  document.getElementById("btnBorrar").addEventListener("click", borrarEvento);
  document.getElementById("btnModificar").addEventListener("click", modificarEvento);

  generarCalendario(añoActual, mesActualIndex);
});



