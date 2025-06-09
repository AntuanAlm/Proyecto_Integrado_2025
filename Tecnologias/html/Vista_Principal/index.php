<?php
session_start();

$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoescuela Almansa.es</title>

    <!-- Links de css -->
    <link rel="stylesheet" href="../../css/vista_principal/index.css">
    <link rel="stylesheet" href="../../css/body_header_nav/body_header_nav.css">
    <link rel="stylesheet" href="../../css/carrito_compra/carrito_compra.css">
    <link rel="stylesheet" href="../../css/formularios/formulario_contacto/formulario_contacto.css">
    <link rel="stylesheet" href="../../css/titulo_botones_nuevos_alumnos/titulo_botones_nuevos_alumnos.css">
    <link rel="stylesheet" href="../../css/footer_generico/footer.css">
    <link rel="stylesheet" href="../../css/sesion_iniciada_usuario/sesion_iniciada_usu.css">

    <!-- Link de las fuentes de google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png" type="image/x-icon">

    <!-- JS -->
    <script src="../../js/enlaces_href/universal.js"></script>
    <script src="../../js/enlaces_src/imagenes.js"></script>
    <script src="../../js/carritoFinal.js"></script>
    <script src="../../js/carrusel_reseñas/carrusel_reseñas.js"></script>
    <script src="../../js/validaciones_formulario_contacto/validaciones_formulario_contacto.js"></script>
    <script src="../../js/menu_flotante_sesion/menu_flotante_sesion.js"></script>
    <script src="../../js/cerrar_sesion/cerrar_sesion.js"></script>
    

</head>
<body>

      <!-- ======================= PARTE SUPERIOR DEL HEADER ========================== -->
        <div class="container">
        
            <p class="email">
                <img data-src="gmail" alt="email" width="35" height="35" mailto="autoescuelaalmansa@hotmail.com">
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

   <!-- ========================== INICIO/CIERRE DE SESIÓN ========================== -->

<?php if (isset($_GET['cerrado']) && $_GET['cerrado'] == 1): ?>
  <div class="sesion-cerrada">
    <p class="mensaje-sesion">🔒 Sesión cerrada correctamente.</p>
  </div>
<?php endif; ?>

<div class="sesion-iniciada sesion-reducida" id="sesionIniciada">

  <!-- Avatar siempre visible -->
  <button id="toggleSesion" class="avatar" title="Menú de sesión">
    <?php 
      if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id'])) {
        $usuario_id = $_SESSION['usuario']['id']; // Obtiene el ID del usuario
        $nombre = $_SESSION['usuario']['nombre']; // Obtiene el nombre del usuario

        if (is_array($nombre)) {
          $nombre = implode(' ', $nombre); // Convertimos array a cadena
        }

        // Elimina números y caracteres extraños en el nombre (pero mantiene el ID)
        $nombreLimpio = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/u', '', $nombre);

        $iniciales = '';
        foreach (explode(' ', trim($nombreLimpio)) as $palabra) {
          if (!empty($palabra)) {
            $iniciales .= strtoupper($palabra[0]); // Toma solo iniciales
          }
        }

        // Avatar con ID + Iniciales (Ejemplo: "10PP")
        echo $usuario_id . $iniciales;
      } else {
        echo '👤';
      }
    ?>
  </button>

  <!-- Si la sesión está iniciada -->
  <?php if (isset($_SESSION['usuario'])): ?>
    <div class="contenido-sesion" id="contenidoSesion">
      <?php
        $nombreUsuario = $_SESSION['usuario']['nombre'];
        if (is_array($nombreUsuario)) {
          $nombreUsuario = implode(' ', $nombreUsuario);
        }
      ?>
      <p class="mensaje-sesion">✅ Sesión iniciada como:<br><strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
      <div class="acciones-sesion">
        <form action="../../php/login_usuarios/logout.php" method="get" class="form-logout">
          <button type="submit">Cerrar sesión</button>
        </form>
        <!-- Botón para ir al área de alumnos -->
        <a href="../../html/area_alumnos/area_alumnos.php">
          <button type="button">Ir al área de alumnos</button>
        </a>
      </div>
    </div>
  <!-- Si la sesión NO está iniciada -->
  <?php else: ?>
    <div class="contenido-sesion">
      <form action="../../html/login_usuario/login_usuario.html" method="post" class="form-login">
        <button type="submit">Iniciar sesión</button>
      </form>
    </div>
  <?php endif; ?>
</div>

      </header>
      
    <!-- ============================ TITULO ===========================  -->

      <div class="contenedor-titulos" role="banner">
        <h1><span class="resaltado">Autoescuela</span> Almansa.es</h1>
        <h2>Consigue tu <strong>permiso de conducir</strong> de la mejor forma.</h2>
    </div>

    <h3 id="subtitulo-etiquetas">¿Estás interesado en sacarte el carnet de conducir?</h3>

    <!-- ======================== SUBTITULO =============================== -->

    <div id="container-etiquetas">
        <div class="etiqueta">
            <a href="#coche" data-enlace="coche">
                <img src="../../img/logo/coche_blanco_auto.png" alt="Coche blanco auto" width="120" height="120">
                <p>Coche</p>
            </a>
        </div>
    </div>
     
         
     <!-- ==================================== NUEVOS CLIENTES E INICIAR SESIÓN ================================ -->

    <h1 class="titulo-principal">¿Ya eres alumno de nuestra autoescuela o te gustaría unirte?</h1>
     
     
     <div class="cliente-buttons">
         <button class="btn-nuevo-cliente" onclick="window.location.href='../../html/formularios/formulario_registro_cliente/formulario_registro_cliente.php'">
             ¡Quiero unirme ahora!
         </button>
         <button class="btn-cliente-actual" onclick="window.location.href='../../html/login_usuario/login_usuario.html'">
             Soy alumno de esta autoescuela. ¡Accede a tu área personal ahora!
         </button>
     </div>

     <!-- ========================== DIFERENCIAS ============================== -->
     
     <h3 id="subtitulo-diferencias">¿En qué nos diferenciamos?</h3>

     <div id="container-texto-direfencias">
        <p id="texto-diferencias">En <strong id="auto-titulo">Autoescuela Almansa.es</strong> nos preocupamos por la formación de nuestros alumnos. Por eso, ofrecemos una enseñanza personalizada y adaptada a las necesidades de cada uno. Nuestros profesores son expertos en la materia y están siempre dispuestos a resolver cualquier duda que puedas tener.</p> 
        <p id="texto-diferencias">Además, contamos con una amplia flota de vehículos modernos y seguros para que puedas practicar con total confianza. Y si necesitas un curso intensivo, ¡también lo tenemos!</p>
        <p id="texto-diferencias-3"> <strong id="motivacion">No lo dudes más y ven a conocernos. ¡Te esperamos!</strong></p>
     </div>


       <!----------------------------- RESEÑAS ---------------------------->
       <div id="reseñas">
        <h2 id="subtexto-etiquetas-reseñas">¿Qué dicen sobre nuestra autoescuela?</h2>
    
        <div class="carrusel-contenedor">

          <div class="carrusel-item activo">
            <img data-src="reseñas_google" alt="reseña-verificada">
            <h3>Lucía ***</h3>
            <p>"¡Increíble experiencia! Aunque solo hice las prácticas aquí, María es una profesora espectacular que hace que aprender sea un placer. ¡Recomendada al 100%!"</p>
          </div>
          
          <div class="carrusel-item">
            <img data-src="reseñas_google" alt="reseña-verificada">
            <h3>Carlos ***</h3>
            <p>"La experiencia ha sido increíble, aprendí muchísimo en poco tiempo. Los instructores son muy profesionales y amables. ¡Altamente recomendados!"</p>
          </div>

          <div class="carrusel-item">
            <img data-src="reseñas_google" alt="reseña-verificada">
            <h3>Ana ***</h3>
            <p>"Un excelente lugar para aprender. Las clases son muy claras y el ambiente es muy agradable. Me sentí muy segura durante todo el proceso."</p>
          </div>

          <div class="carrusel-item">
            <img data-src="reseñas_google" alt="reseña-verificada">
            <h3>Juan ***</h3>
            <p>"El mejor lugar para aprender a conducir. Instructores con mucha paciencia y experiencia. Gracias por todo el apoyo durante mis clases."</p>
          </div>

          <div class="carrusel-item">
            <img data-src="reseñas_google" alt="reseña-verificada">
            <h3>María ***</h3>
            <p>"Me ayudaron a aprobar el examen con facilidad. Las clases son muy completas y me dieron confianza para manejar en cualquier situación."</p>
          </div>

          <div class="carrusel-item">
            <img data-src="reseñas_google" alt="reseña-verificada">
            <h3>José ***</h3>
            <p>"Una experiencia maravillosa. Los instructores se preocupan por tu progreso y están siempre disponibles para resolver dudas. ¡Muy recomendables!"</p>
          </div>
        </div>
    
        <div class="carrusel-controles">
          <button id="anterior">⟵</button>
          <button id="siguiente">⟶</button>
        </div>
      </div>




  <!-- ======================================Formulario de contacto ========================================-->

  <h2 id="titulo-formulario">CONTACTO</h2>

  <form action="../../php/formulario_contacto/contacto.php" method="POST" id="formulario-contacto" novalidate>

    <div class="campo">
      <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
      <p class="error" id="error-nombre"></p>
    </div>
  
    <div class="campo">
      <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" required>
      <p class="error" id="error-apellidos"></p>
    </div>
  
    <div class="campo">
      <input type="email" name="email" id="email" placeholder="Email" required>
      <p class="error" id="error-email"></p>
    </div>
  
    <div class="campo">
      <input type="text" name="telefono" id="telefono" placeholder="Teléfono" required>
      <p class="error" id="error-telefono"></p>
    </div>
  
    <div class="campo">
      <select name="asunto" id="asunto" required>
        <option value="" disabled selected>Selecciona un asunto:</option>
        <option value="coche">Permiso B</option>
        <option value="cursos-intensivos">Cursos intensivos</option>
        <option value="clases-reciclaje">Clases de reciclaje</option>
      </select>
      <p class="error" id="error-asunto"></p>
    </div>
  
    <div class="campo">
      <textarea name="mensaje" id="mensaje" cols="30" rows="10" placeholder="Escribe tu mensaje aquí..." required></textarea>
      <p class="error" id="error-mensaje"></p>
    </div>
  
    <div class="botones">
      <button type="submit">Enviar info!</button>
      <button type="reset">Resetear info!</button>
    </div>

</form>

     
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
          <p id="texto-ubicacion">📞 666 666 666</p>
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