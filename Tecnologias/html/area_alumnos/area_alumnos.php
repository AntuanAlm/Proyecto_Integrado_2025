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
    <title>Bienvenid@ a tu área</title>

    <!-- Link de css -->
    <link rel="stylesheet" href="../../css/area_alumnos/area_alumnos.css">
    <link rel="stylesheet" href="../../css/body_header_nav/body_header_nav.css">
    <link rel="stylesheet" href="../../css/carrito_compra/carrito_compra.css">
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
    <script src="../../js/carrito_compra/carrito.js"></script>
    <script src="../../js/menu_flotante_sesion/menu_flotante_sesion.js"></script>
    <script src="../../js/cerrar_sesion/cerrar_sesion.js"></script>
    <script src="../../js/animacion_titulo_index/animacion_titulo_index.js"></script>
     <script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get("error") === "Ya_tienes_sesion") {
        alert("⚠️ Ya tienes una sesión activa como alumno. Para acceder al área de profesores, primero debes cerrar sesión.");
    }
});
</script>



</head>
<body>

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
        $nombre = $_SESSION['usuario'];

        if (is_array($nombre)) {
          $nombre = implode(' ', $nombre); // Convertimos array a cadena
        }

        if (is_string($nombre)) {
          $iniciales = '';
          foreach (explode(' ', $nombre) as $palabra) {
            if (isset($palabra[0])) {
              $iniciales .= strtoupper($palabra[0]);
            }
          }
          echo $iniciales;
        } else {
          echo '👤';
        }
      } else {
        echo '👤';
      }
    ?>
  </button>

  <!-- Si la sesión está iniciada -->
  <?php if (isset($_SESSION['usuario'])): ?>
    <div class="contenido-sesion" id="contenidoSesion">
      <?php
        $nombreUsuario = $_SESSION['usuario'];
        if (is_array($nombreUsuario)) {
          $nombreUsuario = implode(' ', $nombreUsuario);
        }
      ?>
      <p class="mensaje-sesion">✅ Sesión iniciada como:<br><strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
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

        <!-- =============== AVISO DE QUE LA SESIÓN YA ESTÁ INICIADA=================== -->

       <?php
if (isset($_SESSION['mensaje'])) {
    echo "<script>alert('" . htmlspecialchars($_SESSION['mensaje']) . "');</script>";
    unset($_SESSION['mensaje']); // 🔹 Borra el mensaje para que no se repita
}
?>

        <!-- ========================= AREA DEL ALUMNO  ============================ -->

        <div id="container-alumno">
            <h1 id="titulo-alumno">Bienvenid@ a tu área de alumno de la Autoescuela Almansa.es</h1>
            <p id="texto-alumno">Aquí podrás gestionar tu cuenta, ver tus clases, consultar tus notas y mucho más.</p>

            <div class="botones-alumno">
              
          <img data-src="gif_test" alt="el gif de los test" width="150" height="150">    
          <button data-enlace="test" class="btn-alumno">¿Vamos a hacer test?</button>
          
          <img data-src="gif_estadisticas" alt="el gif de las estadisticas" width="150" height="150">
          <button onclick="window.location.href='/Proyecto_Integrado_2025/Tecnologias/php/resultados_usuario/resultado.php?usuario_id=<?= $_SESSION['usuario']['id'] ?>';" class="btn-alumno">
          ¿Quieres consultar tus notas?
          </button>

          
          <img data-src="gif_compras" alt="el gif de las compras" width="150" height="150">
          <button data-enlace="compras_usuario" class="btn-alumno">¿Qué has comprado?</button>

            </div>
        </div>

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