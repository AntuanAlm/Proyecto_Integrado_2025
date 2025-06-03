<!-- /**
 * Este script inicializa una sesión en PHP y genera un token CSRF (Cross-Site Request Forgery).
 * 
 * - `session_start()`: Inicia una nueva sesión o reanuda una existente. Esto es necesario para
 *   almacenar variables de sesión, como el token CSRF.
 * - `bin2hex(random_bytes(32))`: Genera una cadena aleatoria criptográficamente segura de 32 bytes
 *   y la convierte en una representación hexadecimal. Esto asegura que el token CSRF sea único y
 *   difícil de adivinar.
 * - `$_SESSION['csrf_token']`: Almacena el token CSRF generado en la sesión, haciéndolo accesible
 *   en toda la aplicación para la protección contra CSRF.
 * 
 * Este token puede ser utilizado para proteger formularios al incluirlo como un campo oculto y
 * validarlo en el servidor para prevenir solicitudes no autorizadas.
 */ -->
<?php
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Datos del Cliente</title>

  <!-- Links de css -->
  <link rel="stylesheet" href="../../../css/formularios/formulario_registro_cliente/formulario_registro_cliente.css">
  <link rel="stylesheet" href="../../../css/body_header_nav/body_header_nav.css">
  <link rel="stylesheet" href="../../../css/carrito_compra/carrito_compra.css">
  <link rel="stylesheet" href="../../../css/footer_generico/footer.css">


  <!-- Link de las fuentes de google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../../../img/logo/logo-autoescuela.png" type="image/x-icon">

  <!-- JS -->
   <script src="../../../js/enlaces_href/universal_form_registro.js"></script>    
   <script src="../../../js/enlaces_src/imagenes_form_registro.js"></script>
   <script src="../../../js/carritoFinal.js"></script>
   <script src="../../../js/validaciones_formulario_registro/validaciones_formularios_registro.js"></script>
</head>
<body>

    <div class="container">
        
        <p class="email">
            <img data-src="gmail" alt="email" width="35" height="35">
            autoescuelaalmansa@hotmail.com
        </p>

            <a href="https://www.facebook.com/antonio.almansa.39?locale=es_ES" class="facebook" target="_blank">
                <img data-src="fb" alt="facebook" width="30" height="30">
            </a>

            <a href="https://www.instagram.com/autoalmansa.es/?igsh=MXJseXk1Y2NkZDRnZg%3D%3D#" class="instagram" target="_blank">
                <img data-src="instagram" alt="instagram" width="30" height="30">
            </a>
        
    </div>

      <!-- ----------------------------- CARRITO DE LA COMPRA ----------------------------- -->
<div id="carrito" class="carrito-icon" onclick="toggleCarrito()">
  <span>🛒 Carrito</span>
  <span id="carrito-count" class="carrito-count">0</span>
</div>

<div id="carrito-menu" class="carrito-menu">
  <div id="carrito-header" class="carrito-header">
    <h2>Tu Carrito</h2>
    <button class="close-carrito" onclick="toggleCarrito()">✖</button>
  </div>
  <div id="carrito-vacio" class="carrito-vacio">
    <p>No tienes artículos en el carrito</p>
  </div>
  <div id="carrito-contenido" class="carrito-contenido">
    <div id="carrito-items" class="carrito-items"></div>
    <div id="carrito-total" class="carrito-total">
      <p>Total: <span id="total-carrito">0€</span></p>
    </div>
    <!-- Botón que ahora es manejado por JavaScript -->
    <button class="btn-pago">Ir a pagar</button>
  </div>
</div>
    
    <!------------------------------------ HEADER -------------------------------------->

    <header class="header">

      <div class="logo-container">
          <a class="logo-principal" data-enlace="inicio">
              <img data-src="logo_autoescuela" alt="Logo Autoescuela Almansa" width="100" height="100">
          </a>
      </div>
      
      <nav id="menu-navegacion">
          <div id="menu-carnets">
              <a href="#carnets" data-enlace="carnets">Carnets</a>
              <div id="submenu-carnets">
                  <a id="submenu-coche" data-enlace="coche">Coche - B</a>
                  <a id="submenu-precio" data-enlace="precio">Precios - B</a>
                  <a id="submenu-intensivos" data-enlace="cursos_intensivos">Cursos Intensivos</a>
                  <a id="submenu-reciclaje" data-enlace="clases_reciclaje">Clases de Reciclaje</a>
              </div>
          </div>
      
          <div id="menu-alumnos">
              <a href="#alumnos" data-enlace="alumnos">Alumnos</a>
              <div id="submenu-alumnos">
                  <a id="submenu-test" data-enlace="test">Test</a>
                  <a id="submenu-nota" data-enlace="nota">Consulta tu Nota</a>
              </div>
          </div>
  
          <div id="profesores">
              <a>Profesores</a>
              <div id="submenu-profesores">
                  <a data-enlace="profesores">Conoce a tus profesores</a>
                  <a data-enlace="login_profesores">Area profesores</a>
              </div>
          </div>
      
          <div id="menu-calendario">
              <a data-enlace="calendario">Calendario</a>
          </div>
      
          <div id="menu-resenas">
              <a data-enlace="reseñas">Reseñas</a>
          </div>
      
          <div id="menu-sobrenosotros">
              <a data-enlace="sobre_nosotros">Sobre nosotros</a>
          </div>
      
          <div id="menu-contacto">
              <a data-enlace="contacto">Contacto</a>
          </div>
      </nav>
  </header>


<!-- ====================== FORMULARIO REGISTRO =========================== -->
<section id="registro-cliente">
  <h1>Datos del Cliente</h1>
  <div class="contenedor-formulario">
    <form id="form-datos" method="post" action="../../../php/registro_cliente/registro_cliente.php" novalidate>

     <!-- Token CSRF oculto : Este código genera un campo oculto en el formulario que incluye un token CSRF almacenado en la sesión para proteger contra ataques de falsificación de solicitudes entre sitios (CSRF). -->
     <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">


      <div>
        <label for="nombre">Nombre:</label>
        <input id="nombre" name="nombre" type="text" placeholder="Tu nombre" required>
        <p id="error-nombre" class="error-message"></p>
      </div>

      <div>
        <label for="apellidos">Apellidos:</label>
        <input id="apellidos" name="apellidos" type="text" placeholder="Tus apellidos" required>
        <p id="error-apellidos" class="error-message"></p>
      </div>

      <div>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required onkeydown="return false" onpaste="return false">
        <p id="error-fecha_nacimiento" class="error-message"></p>
      </div>

      <div>
        <label for="dni">DNI:</label>
        <input id="dni" name="dni" type="text" pattern="[0-9]{8}[A-Za-z]{1}" placeholder="12345678A" required>
        <p id="error-dni" class="error-message"></p>
      </div>

      <div>
        <label for="telefono">Teléfono:</label>
        <input id="telefono" name="telefono" type="tel" placeholder="123456789" pattern="[0-9]{9}" required>
        <p id="error-telefono" class="error-message"></p>
      </div>

      <div>
        <label for="correo">Correo electrónico:</label>
        <input id="correo" name="correo" type="email" placeholder="tu@email.com" required>
        <p id="error-correo" class="error-message"></p>
      </div>

      <div>
        <label for="contrasena">Contraseña:</label>
        <input id="contrasena" name="contrasena" type="password" placeholder="Tu contraseña" required>
        <button type="button" onclick="mostrarContraseña()">Mostrar contraseña</button>
        <script>
        function mostrarContraseña() {
          const input = document.getElementById('contrasena');
          input.type = input.type === 'password' ? 'text' : 'password';
        }
        </script>
        <p id="error-contrasena" class="error-message"></p>
      </div>

      <div class="contenedor-botones">
        <button type="reset" id="reset-datos">Resetear campos</button>
        <button type="submit" id="enviar-datos">Registrarse</button>
      </div>
    </form>
  </div>
</section>


   <!-- -------------------------- FOOTER O PIE DE PAGINA -------------------------- -->


   <footer id="pie-pagina">
    <div class="container-footer">
  
      <div class="footer-section">
        <p class="email-footer">
          <img data-src="gmail" alt="email" width="24" height="24">
          autoescuelaalmansa@hotmail.com
        </p>
  
        <div class="social-icons">
          <a data-src="gmail" target="_blank">
            <img data-src="fb" alt="facebook" width="30" height="30">
          </a>
          <a data-src="instagram" target="_blank">
            <img data-src="instagram" alt="instagram" width="30" height="30">
          </a>
        </div>
      </div>
  
      <div class="footer-section" id="ubicacion-footer">
        <p id="texto-ubicacion">📍 C. Pez Espada, 1, Supeco, 11207 Algeciras, Cádiz</p>
        <p id="texto-ubicacion">📞 *** *** ***</p>
        <p id="texto-ubicacion">🕒 Lunes a Viernes de 10:00 a 13:00 y de 17:00 a 20:00</p>
      </div>
    </div>
  
    <div id="iframe-ubicacion">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3223.4964282840815!2d-5.443612424682271!3d36.105761706537756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0c95a901ed9945%3A0xb83093c80d4fc973!2sAlmansa.%20Es!5e0!3m2!1ses!2ses!4v1744008383788!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  
    <div id="container-pie-pagina">
      <p id="texto-pie-pagina">Autoescuela Almansa.es &copy; 2025 – Todos los derechos reservados</p>
      <p id="texto-pie-pagina">Desarrollado por: Antonio Almansa</p>
    </div>
  </footer>
</body>
</html>
