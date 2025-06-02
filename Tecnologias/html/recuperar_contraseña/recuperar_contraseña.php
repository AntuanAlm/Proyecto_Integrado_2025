<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../../php/conexion/conexion.php');

$correo = $_POST['correo'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($correo)) {
    // Verificar si el correo está en la base de datos
    $stmt = $conexion->prepare("SELECT 'profesor' AS tipo_usuario FROM profesores WHERE correo = ? 
                                UNION 
                                SELECT 'alumno' AS tipo_usuario FROM clientes WHERE correo = ?");
    $stmt->bind_param("ss", $correo, $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $tipo_usuario = $resultado->fetch_assoc()['tipo_usuario'] ?? null;

    if (!$tipo_usuario) {
        $mensaje_error = "⚠️ Este correo no está registrado.";
    } else {
        echo "<p style='color: green;'>📩 Correo enviado. Redirigiendo en 5 segundos...</p>";
        echo "<script>setTimeout(function(){ window.location.href = '../../html/establecer_contraseña/establecer_contraseña.php?correo=$correo&tipo=$tipo_usuario'; }, 5000);</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

    <!-- links de css -->
    <link rel="stylesheet" href="../../css/recuperar_contraseña/recuperar_contraseñas.css">
    <link rel="stylesheet" href="../../css/body_header_nav/body_header_nav.css">
    <link rel="stylesheet" href="../../css/footer_generico/footer.css">


    <!-- Link de las fuentes de google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png" type="image/x-icon">

    <!-- JS -->
    <script src="../../js/enlaces_href/universal.js"></script>
    <script src="../../js/enlaces_src/imagenes.js"></script>

</head>
<body>

 <!-- ----------------------------- CONTAINER PRINCIPAL ------------------------- -->

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
                    <a id="submenu-intensivos"data-enlace="cursos_intensivos">Cursos Intensivos</a>
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



    <!-- =============================== RECUPERAR CONTRASEÑA ============================= -->
    <h2>Recuperar contraseña</h2>

    <form method="POST" id="formulario-recuperar">
        <label for="correo">Introduce tu correo:</label>
        <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
        <p class="mensaje-error"><?= $mensaje_error ?? '' ?></p>
        <input type="submit" value="Recuperar contraseña">
    </form>


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
