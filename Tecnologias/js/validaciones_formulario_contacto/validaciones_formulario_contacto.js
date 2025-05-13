// // Asegurarse de que el DOM se haya cargado antes de ejecutar el script
// document.addEventListener('DOMContentLoaded', function () {
  
//     // Seleccionar el formulario y los campos
//     const formulario = document.getElementById('formulario-contacto');
//     const nombre = document.getElementById('nombre');
//     const apellidos = document.getElementById('apellidos');
//     const email = document.getElementById('email');
//     const telefono = document.getElementById('telefono');
//     const asunto = document.getElementById('asunto');
//     const mensaje = document.getElementById('mensaje');
    
//     // Función para mostrar mensajes de error
//     function showError(id, mensaje) {
//       const errorElemento = document.getElementById(id);
//       errorElemento.textContent = mensaje;
//       errorElemento.style.display = 'block';  // Asegura que el mensaje de error sea visible
//     }
  
//     // Función para ocultar mensajes de error
//     function hideError(id) {
//       const errorElemento = document.getElementById(id);
//       errorElemento.style.display = 'none'; // Oculta el mensaje de error
//     }
  
//     // Al enviar el formulario, validamos
//     formulario.addEventListener('submit', function (e) {
//       e.preventDefault();  // Evita que el formulario se envíe antes de las validaciones
      
//       let isValid = true;
  
//       // Limpiar mensajes de error previos
//       hideError('error-nombre');
//       hideError('error-apellidos');
//       hideError('error-email');
//       hideError('error-telefono');
//       hideError('error-asunto');
//       hideError('error-mensaje');
  
//       // Validación de nombre
//       if (nombre.value.trim() === '') {
//         showError('error-nombre', '⚠️ El nombre es obligatorio.');
//         isValid = false;
//       }
  
//       // Validación de apellidos
//       if (apellidos.value.trim() === '') {
//         showError('error-apellidos', '⚠️ Los apellidos son obligatorios.');
//         isValid = false;
//       }
  
//     // Validación de email
// const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

// // Errores comunes en dominios de correos
// const commonEmailMistakes = {
//   "hotmailll.com": "hotmail.com",
//   "hotmaiil.com": "hotmail.com",
//   "gamil.com": "gmail.com",
//   "gamil.co": "gmail.com",
//   "gail.com": "gmail.com",
//   "gmial.com": "gmail.com",
//   "outlok.com": "outlook.com",
//   "yaho.com": "yahoo.com",
//   "outlooko.com": "outlook.com"
// };

// const emailValue = email.value.trim();
// if (emailValue === '') {
//   showError('error-email', '⚠️ El email es obligatorio.');
//   isValid = false;
// } else if (!emailPattern.test(emailValue)) {
//   showError('error-email', '⚠️ El email debe contener "@" y un dominio válido (ej: usuario@dominio.com).');
//   isValid = false;
// } else {
//   // Verificar si el dominio contiene un error común
//   const emailParts = emailValue.split('@');
//   if (emailParts.length === 2) {
//     const domain = emailParts[1].toLowerCase();
//     if (commonEmailMistakes[domain]) {
//       showError('error-email', `⚠️ El dominio "${domain}" parece tener un error de escritura. Quizás quisiste decir "${commonEmailMistakes[domain]}"`);
//       isValid = false;
//     }
//   }
// }
  
//       // Validación de teléfono (exactamente 9 números)
//       const telefonoPattern = /^[0-9]{9}$/;
//       if (telefono.value.trim() === '') {
//         showError('error-telefono', '⚠️ El teléfono es obligatorio.');
//         isValid = false;
//       } else if (!telefonoPattern.test(telefono.value)) {
//         showError('error-telefono', '⚠️ El teléfono debe contener exactamente 9 números.');
//         isValid = false;
//       }
  
//       // Validación de asunto
//       if (asunto.value.trim() === '') {
//         showError('error-asunto', '⚠️ El asunto es obligatorio.');
//         isValid = false;
//       }
  
//       // Validación de mensaje
//       if (mensaje.value.trim() === '') {
//         showError('error-mensaje', '⚠️ El mensaje es obligatorio.');
//         isValid = false;
//       } else if (mensaje.value.trim().length < 10) {
//         showError('error-mensaje', '⚠️ El mensaje debe contener al menos 10 caracteres.');
//         isValid = false;
//       }
  
//       // Si todo es válido, podemos enviar el formulario
//       if (isValid) {
//         formulario.submit(); // Si todo está bien, envía el formulario
//         alert("✅ ¡Formulario enviado con éxito!");
//       }
//     });
  
//   });
  

// Asegurarse de que el DOM se haya cargado antes de ejecutar el script
document.addEventListener('DOMContentLoaded', function () {
  
    // Seleccionar el formulario y los campos
    const formulario = document.getElementById('formulario-contacto');
    const nombre = document.getElementById('nombre');
    const apellidos = document.getElementById('apellidos');
    const email = document.getElementById('email');
    const telefono = document.getElementById('telefono');
    const asunto = document.getElementById('asunto');
    const mensaje = document.getElementById('mensaje');
    
    // Función para mostrar mensajes de error
    function showError(id, mensaje) {
      const errorElemento = document.getElementById(id);
      errorElemento.textContent = mensaje;
      errorElemento.style.display = 'block';  // Asegura que el mensaje de error sea visible
    }
  
    // ===============0Función para ocultar mensajes de error =================
    function hideError(id) {
      const errorElemento = document.getElementById(id);
      errorElemento.style.display = 'none'; // Oculta el mensaje de error
    }
  
    // =====================Al enviar el formulario, validamos ====================
    formulario.addEventListener('submit', function (e) {
      e.preventDefault();  // Evita que el formulario se envíe antes de las validaciones
      
      let isValid = true;
  
      //===================== Limpiar mensajes de error previos =====================
      ['error-nombre', 'error-apellidos', 'error-email', 'error-telefono', 'error-asunto', 'error-mensaje'].forEach(hideError);
  
      // ==================== Validación de nombre ====================
      if (nombre.value.trim() === '') {
        showError('error-nombre', '⚠️ El nombre es obligatorio.');
        isValid = false;
      }
  
      // ========================= Validación de apellidos =========================
      if (apellidos.value.trim() === '') {
        showError('error-apellidos', '⚠️ Los apellidos son obligatorios.');
        isValid = false;
      }
  
      //  ======================= Validación de email =======================
      // Lista de dominios de correos mas usados
      const dominiosPermitidos = ["hotmail.com", "gmail.com", "outlook.com", "yahoo.com"];

      // Diccionario de errores comunes de dominio
      const erroresComunesDominio = {
        "hotmailll.com": "hotmail.com",
        "hotmaiil.com": "hotmail.com",
        "gamil.com": "gmail.com",
        "gail.com": "gmail.com",
        "gmial.com": "gmail.com",
        "outlok.com": "outlook.com",
        "yaho.com": "yahoo.com",
        "outlooko.com": "outlook.com",
        "gmil.com": "gmail.com",
        "yhaoo.com": "yahoo.com"
      };

    // ====================== Expresión regular para validar email : sin mas =====================
    const patronCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    // ================== Obtener y limpiar el valor del campo ======================
    const valorCorreo = email.value.trim();

    if (valorCorreo === '') {
    showError('error-email', '⚠️ El correo electrónico es obligatorio.');
    isValid = false;

    } else if (!patronCorreo.test(valorCorreo)) {
    showError('error-email', '⚠️ El correo debe tener un formato válido con "@" y un dominio correcto.');
    isValid = false;

    } else {
    const partesCorreo = valorCorreo.split('@');

    if (partesCorreo.length === 2) {
    const nombreUsuario = partesCorreo[0];
    const dominio = partesCorreo[1].toLowerCase();

    // ====================== Sugerencia si hay un error común en el dominio =====================
    if (erroresComunesDominio[dominio]) {
      const sugerencia = erroresComunesDominio[dominio];
      showError('error-email', `⚠️ Quizás quisiste decir "${nombreUsuario}@${sugerencia}".`);
      isValid = false;

    // ======================= Si el dominio no está permitido =======================
    } else if (!dominiosPermitidos.includes(dominio)) {
      showError('error-email', `⚠️ Solo se permiten correos de: ${dominiosPermitidos.join(', ')}. Por favor, vuelve a introducir tu correo.`);
      email.value = ''; // Limpia el campo para que se vuelva a introducir
      email.focus();    // Coloca el cursor en el campo
      isValid = false;
    }

    } else {
    showError('error-email', '⚠️ El correo no tiene un formato válido.');
    isValid = false;
    }
  }
  
      // ==================== Validación de teléfono ====================
      if (!/^\d{9}$/.test(telefono.value.trim())) {
        showError('error-telefono', '⚠️ El teléfono debe contener exactamente 9 números.');
        isValid = false;
      }
  
      // =================== Validación de asunto ===================
      if (asunto.value.trim() === '') {
        showError('error-asunto', '⚠️ El asunto es obligatorio.');
        isValid = false;
      }
  
      // ================ Validación de mensaje ==================
      if (mensaje.value.trim().length < 10) {
        showError('error-mensaje', '⚠️ El mensaje debe contener al menos 10 caracteres.');
        isValid = false;
      }
  
      // Si todo es válido, envía el formulario
      if (isValid) {
        formulario.submit();
      }
    });
});
