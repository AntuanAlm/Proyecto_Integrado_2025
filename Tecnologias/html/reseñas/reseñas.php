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
    <title>Reseñas</title>

    <!-- Links de css -->
    <link rel="stylesheet" href="../../css/reseñas/reseñas.css">
    <link rel="stylesheet" href="../../css/body_header_nav/body_header_nav.css">
    <link rel="stylesheet" href="../../css/carrito_compra/carrito_compra.css">
    <link rel="stylesheet" href="../../css/footer_generico/footer.css">
    <link rel="stylesheet" href="../../css/sesion_iniciada_usuario/sesion_iniciada_usu.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png" type="image/x-icon">


    <!-- JS -->
    <script src="../../js/enlaces_href/universal.js"></script>
    <script src="../../js/enlaces_src/imagenes.js"></script>
    <script src="../../js/carrito_compra/carrito.js"></script>
    <script src="../../js/borrar_reseñas/borrar_reseñas.js"></script>
    <script src="../../js/menu_flotante_sesion/menu_flotante_sesion.js"></script>
    <script src="../../js/cerrar_sesion/cerrar_sesion.js"></script>


</head>
<body>

    <!------------------- APARTADO DE REDES SOCIALES ---------------------------->

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

  <!-------------------------------- CARRITO DE LA COMPRA ---------------------------->
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
      <a data-enlace="pasarela_pago" class="btn-pago">Ir a pagar</a>
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
                <a data-enlace="login">Area profesores</a>
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
      if (isset($_SESSION['usuario'])) {
        // Si hay sesión, mostramos las iniciales del usuario
        $nombre = $_SESSION['usuario'];
        $iniciales = '';
        foreach (explode(' ', $nombre) as $palabra) {
          $iniciales .= strtoupper($palabra[0]);
        }
        echo $iniciales;
      } else {
        // Si no hay sesión, mostramos el ícono de "iniciar sesión"
        echo '👤';
      }
    ?>
  </button>

  <!-- Si la sesión está iniciada -->
  <?php if (isset($_SESSION['usuario'])): ?>
    <div class="contenido-sesion" id="contenidoSesion">
      <p class="mensaje-sesion">✅ Sesión iniciada como:<br><strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>
      <div class="acciones-sesion">
        <form action="../../php/login_usuarios/logout.php" method="get" class="form-logout">
          <button type="submit">Cerrar sesión</button>
        </form>
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

    <!-- >>>>>>>>>>>>>>>>>>>>>>>> APARTADO DE RESEÑAS <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< -->

    <h1 id="titulo-reseñas">Reseñas</h1>

    <div id="encabezado-reseñas">
      <p>La opinión de nuestros alumnos es muy importante, ya que, es una muy buena forma de hacernos a conocer para todas las personas que quieren obtener su permiso de conducir. Actualmente contamos con un 4.9 de media en reseñas de Google, lo que refleja el esfuerzo y dedicación que ponemos en cada clase y en cada alumno. A continuación, puedes leer algunas de las reseñas que nuestros alumnos han dejado:</p>
    </div>

    <div id="img-reseñas">
      <img data-src="estrellas_google" alt="4.9 estrellas" width="300" height="200">
    </div>

    <div id="etiquetas">

      <!-- Etiqueta 1 -->
      <div id="etiqueta-reseñas">
      <img data-src="reseñas_google" alt="reseña-verificada" width="100" height="100">
      <h3>Lucía ***</h3>
      <p>¡Increíble experiencia! Aunque solo hice las prácticas aquí, María es una profesora espectacular que hace que aprender sea un placer. ¡Recomendada al 100%!</p>
      <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      </div>

      <!-- Etiqueta 2 -->
      <div id="etiqueta-reseñas">
      <img data-src="reseñas_google" alt="reseña-verificada" width="100" height="100">
      <h3>Carlos ***</h3>
      <p>La experiencia ha sido increíble, aprendí muchísimo en poco tiempo. Los instructores son muy profesionales y amables. ¡Altamente recomendados!</p>
      <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      </div>

      <!-- Etiqueta 3 -->
      <div id="etiqueta-reseñas">
      <img data-src="reseñas_google" alt="reseña-verificada" width="100" height="100">
      <h3>Ana ***</h3>
      <p>Un excelente lugar para aprender. Las clases son muy claras y el ambiente es muy agradable. Me sentí muy segura durante todo el proceso.</p>
      <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      </div>

      <!-- Etiqueta 4 -->
      <div id="etiqueta-reseñas">
      <img data-src="reseñas_google" alt="reseña-verificada" width="100" height="100">
      <h3>Juan ***</h3>
      <p>El mejor lugar para aprender a conducir. Instructores con mucha paciencia y experiencia. Gracias por todo el apoyo durante mis clases.</p>
      <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      </div>

      <!-- Etiqueta 5 -->
      <div id="etiqueta-reseñas">
      <img data-src="reseñas_google" alt="reseña-verificada" width="100" height="100">
      <h3>María ***</h3>
      <p>Me ayudaron a aprobar el examen con facilidad. Las clases son muy completas y me dieron confianza para manejar en cualquier situación.</p>
      <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      </div>

      <!-- Etiqueta 6 -->
      <div id="etiqueta-reseñas">
      <img data-src="reseñas_google" alt="reseña-verificada" width="100" height="100">
      <h3>José ***</h3>
      <p>Una experiencia maravillosa. Los instructores se preocupan por tu progreso y están siempre disponibles para resolver dudas. ¡Muy recomendables!</p>
      <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      </div>
    </div>

    <a data-enlace="contacto" id="boton-contactar">Contacta con nosotros!</a>

    <!-- ========================== AGREGAR RESEÑA ======================== -->

    <div id="agregar-reseña">
      <h2>¿Has estado apuntado en nuestra autoescuela? ¡Dejanos tu reseña!</h2>
      <input type="text" id="nombre-usuario" placeholder="Tu nombre..." />
      <br>
      <textarea id="nueva-reseña" placeholder="Escribe tu reseña aquí..." rows="4" cols="50"></textarea>
      <br>
      <button id="boton-agregar-reseña" onclick="agregarReseña()">Agregar Reseña</button>
    </div>
    <!-------------------------------- FOOTER ------------------------------------>

     <footer id="pie-pagina">
      <div class="container-footer">
    
        <div class="footer-section">
          <p class="email-footer">
            <img data-src="gmail" alt="email" width="24" height="24">
            autoescuelaalmansa@hotmail.com
          </p>
    
          <div class="social-icons">
            <a href="https://www.facebook.com/" target="_blank">
              <img data-src="fb" alt="facebook" width="30" height="30">
            </a>
            <a href="https://www.instagram.com/" target="_blank">
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