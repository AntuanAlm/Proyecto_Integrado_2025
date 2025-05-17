// document.addEventListener("DOMContentLoaded", function () {
//     fetch("../../php/verificar_usuario_pago/verificar_usuario.php?accion=test")
//         .then(response => response.json())
//         .then(data => {
//             if (!data.sesion_activa) {
//                 alert("⚠️ Debes iniciar sesión para acceder a los tests.");
//                 window.location.href = "../../html/login_usuario/login_usuario.html";
//             } else if (!data.puede_acceder_test) {
//                 alert("⚠️ Para acceder a los tests, debes comprar el Teórico o el Pack Completo.");
//                 window.location.href = "../../html/precio/precio.html";
//             }
//         })
//         .catch(error => console.error("Error al verificar acceso:", error));
// });

// document.addEventListener("DOMContentLoaded", function () {
//     fetch("../../php/verificar_usuario_pago/verificar_usuario.php?accion=test")
//         .then(response => response.json())
//         .then(data => {
//             console.log("Estado de sesión:", data);

//             if (!data.sesion_activa) {
//                 alert("⚠️ Debes iniciar sesión para acceder a los tests.");
//                 window.location.href = "../../html/login_usuario/login_usuario.html";
//             } else if (!data.puede_acceder_test) {
//                 if (!sessionStorage.getItem("redirigidoAPrecio")) { // 🔹 Verifica si ya fue redirigido
//                     sessionStorage.setItem("redirigidoAPrecio", "true"); // 🔹 Marca que ha sido redirigido
//                     window.location.href = "../../html/precio/precio.html?compra_necesaria=1";
//                 }
//             } else {
//                 console.log("✅ Acceso permitido a los tests.");
//             }
//         })
//         .catch(error => {
//             console.error("Error al verificar acceso:", error);
//             alert("⚠️ Hubo un problema al verificar el acceso. Inténtalo más tarde.");
//         });
// });

// Espera a que todo el contenido del DOM esté cargado antes de ejecutar el código
document.addEventListener("DOMContentLoaded", function () {
    // Verifica si la URL actual contiene "precio.html"
    if (window.location.href.includes("precio.html")) {
        // Si estamos en precio.html, solo mostramos el alert si es necesario y no hacemos fetch
        const urlParams = new URLSearchParams(window.location.search); // Obtenemos los parámetros de la URL
        if (urlParams.get("compra_necesaria") === "1") { // Si el parámetro compra_necesaria es igual a 1
            alert("⚠️ Para acceder a los tests debes realizar el pago."); // Mostramos alerta de pago necesario
        }
        return; // Salimos de la función para no ejecutar el resto del código
    }

    // Si no estamos en precio.html, ejecutamos el siguiente código (por ejemplo, en test.html)
    fetch("../../php/verificar_usuario_pago/verificar_usuario.php?accion=test") // Hacemos una petición para verificar el acceso del usuario
        .then(response => response.json()) // Convertimos la respuesta a JSON
        .then(data => {
            console.log("Estado de sesión:", data); // Mostramos en consola el estado de la sesión

            if (!data.sesion_activa) { // Si el usuario no ha iniciado sesión
                alert("⚠️ Debes iniciar sesión para acceder a los tests."); // Mostramos alerta de inicio de sesión necesario
                window.location.href = "../../html/login_usuario/login_usuario.html"; // Redirigimos a la página de login
            } else if (!data.puede_acceder_test) { // Si el usuario no tiene acceso a los tests (no ha pagado)
                alert("Para acceder a los tests debes realizar el pago."); // Mostramos alerta de pago necesario
                window.location.href = "../../html/precio/precio.html?compra_necesaria=1"; // Redirigimos a la página de pago con el parámetro correspondiente
            }
        })
        .catch(error => console.error("Error al verificar acceso:", error)); // Si hay un error en la petición, lo mostramos en consola
});



