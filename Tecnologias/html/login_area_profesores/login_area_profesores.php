<?php
session_start();

// Si el profesor ya tiene sesión activa, redirigirlo a su área correspondiente
if (isset($_SESSION["profesor_id"])) {
    if ($_SESSION["profesor_nombre"] === "Juan") {
        header("Location: ../../html/area_profesor/area_profesor.php");
    } elseif ($_SESSION["profesor_nombre"] === "María") {
        header("Location: ../../html/area_profesora/area_profesora.php");
    }
    exit();
}

// Si no hay sesión activa, mostrar el formulario de login normalmente
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Profesores Autoescuela Almansa.es</title>

    <!-- links de css -->
    <link rel="stylesheet" href="../../css/login_area_profesores/login_area_profesores.css">
    <link rel="stylesheet" href="../../css/body_header_nav/body_header_nav.css">  
    <link rel="stylesheet" href="../../css/footer_generico/footer.css">

    <!-- links de fuentes de google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png" type="image/x-icon">

    <!-- liks de js -->
    <script src="../../js/enlaces_href/universal.js"></script>
    <script src="../../js/enlaces_src/imagenes.js"></script>
    <script src="../../js/mostrar_contraseña/mostrar_contraseña.js"></script>


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
          </header>

        <!--================================= AREA DE PROFESORES ============================  -->

        <h2 id="titulo-login-profesor">Login de profesores</h2>
<form action="../../php/validar_login_profesores/validar_login_profesores.php" method="POST" id="formulario-login">

  <div id="campo">
    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" placeholder="Introduce tu correo" required><br><br>
    <p class="mensaje-error" id="error-correo"></p>
  </div>

  <div id="campo">
    <label for="contrasena">Contraseña:</label>
    <input type="password" name="contrasena" id="contrasena" placeholder="Introduce tu contraseña" required>
    <button type="button" id="mostrar-contrasena">Mostrar</button>
    <p class="mensaje-error" id="error-contrasena"></p>
  </div>

  <label>
    <input type="checkbox" name="recordar" value="1"> Recordarme
  </label><br><br>

  <input type="submit" value="Iniciar sesión">
</form>

<p><a id="enlace" href="../../php/recuperar_contrasena_profesores/recuperar_contrasena_profesores.php">¿Olvidaste tu contraseña?</a></p>
     
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