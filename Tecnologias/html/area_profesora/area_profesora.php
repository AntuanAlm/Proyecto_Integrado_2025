<?php
session_start();
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

if (!isset($_SESSION["profesor_id"]) || $_SESSION["profesor_id"] !== 2) {
    die("Acceso denegado.");
}

// Obtener alumnos asignados a María y sus compras desde la tabla `compras`
$stmt = $conexion->prepare("
    SELECT clientes.id, clientes.nombre, clientes.apellidos, clientes.dni, clientes.telefono, clientes.correo, 
    DATE(clientes.fecha_registro) AS fecha_inscripcion, clientes.fecha_nacimiento, clientes.profesor_id, 
    IFNULL(GROUP_CONCAT(CONCAT(compras.producto, ' - ', compras.precio, '€') SEPARATOR ', '), 'Sin compras') AS productos_comprados,
    IFNULL(SUM(compras.precio), 0) AS total_gastado
    FROM clientes 
    LEFT JOIN compras ON clientes.id = compras.usuario_id 
    WHERE clientes.profesor_id = 2 
    GROUP BY clientes.id
");


$stmt->execute();
$resultados = $stmt->get_result();

// Guardamos los resultados en un array para evitar múltiples bucles
$alumnos = [];
while ($fila = $resultados->fetch_assoc()) {
    $alumnos[] = $fila;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area de María López</title>

    <!-- Links de css -->
    <link rel="stylesheet" href="../../css/area_profesora/area_profesora.css">
    <link rel="stylesheet" href="../../css/calendario/calendario.css">
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
    <script src="../../js/calendario/calendario.js"></script>
    
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get("error") === "Ya_tienes_sesion_profesor") {
        alert("⚠️ Ya tienes una sesión activa como profesor. Para acceder al área de alumnos, primero debes cerrar sesión.");
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
          <?php if (isset($_GET['cerrado']) && $_GET['cerrado'] == 1): ?>
  <div class="sesion-cerrada">
    <p class="mensaje-sesion">🔒 Sesión cerrada correctamente.</p>
  </div>
  <?php endif; ?>
  
  <?php if (isset($_SESSION['profesor_id'])): ?>
        <form action="../../php/cerrar_sesion_profes/cerrar_sesion_profes.php" method="post">
    <button type="submit" class="btn-logout">Cerrar sesión 🔒</button>
</form>


    <?php endif; ?>
        </header>
        
        <!-- =============================== AREA DE MARIA LOPEZ ========================= -->

        <h1>Alumnos de María (Teóricas)</h1>
<h2>Selecciona un alumno para ver su información</h2>

<div class="contenedor-alumnos">
    <select id="selector-alumnos">
        <option value="">-- Seleccionar Alumno --</option>
        <?php foreach ($alumnos as $fila) { ?>
            <option value="alumno-<?= $fila['id']; ?>">
                <?= htmlspecialchars($fila["nombre"] . " " . $fila["apellidos"]); ?>
            </option>
        <?php } ?>
    </select>
</div>

<?php foreach ($alumnos as $fila) { ?>
<div id="alumno-<?= $fila['id']; ?>" class="tarjeta-alumno">
    <h3><?= htmlspecialchars($fila["nombre"] . " " . $fila["apellidos"]); ?></h3>
    <p><strong>DNI:</strong> <?= htmlspecialchars($fila["dni"]); ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($fila["telefono"]); ?></p>
    <p><strong>Fecha de inscripción:</strong> <?= date_format(date_create($fila["fecha_inscripcion"]), 'd/m/Y'); ?></p>
    <p><strong>Correo:</strong> <?= htmlspecialchars($fila["correo"]); ?></p>
    <p><strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($fila["fecha_nacimiento"]); ?></p>
    <p><strong>Profesora:</strong> <?= ($fila["profesor_id"] == 2) ? "María" : "Juan"; ?></p>
    <p><strong>Compras:</strong> <?= htmlspecialchars($fila["productos_comprados"]); ?></p>
    <p><strong>Total gastado:</strong> <?= number_format($fila["total_gastado"], 2) . "€"; ?></p>
    <a href="../../php/resultados_usuario/resultado.php?usuario_id=<?= $fila['id']; ?>" class="btn-ver-resultados">
        Ver Resultados de los test
    </a>
</div>
<?php } ?>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectorAlumnos = document.getElementById("selector-alumnos");

            selectorAlumnos.addEventListener("change", function () {
                const alumnoSeleccionado = this.value;

                // Ocultar todas las tarjetas
                document.querySelectorAll(".tarjeta-alumno").forEach(tarjeta => {
                    tarjeta.style.display = "none";
                });

                // Mostrar la tarjeta del alumno seleccionado
                if (alumnoSeleccionado) {
                    document.getElementById(alumnoSeleccionado).style.display = "block";
                }
            });
        });
    </script>

<!-- ======================= CALENDARIO ========================== -->
<h2 id = titulo-calendario>Calendarío de clases y examenes</h2>

    <div class="calendario">
      <div class="encabezado">
        <div class="botones-mes">
          <button>&lt; Mes anterior</button>
        </div>
        <h2>Mayo 2025</h2>
        <div class="botones-mes">
          <button>Mes siguiente &gt;</button>
        </div>
      </div>
      
      <div class="dias-semana">
        <div>Lun</div>
        <div>Mar</div>
        <div>Mié</div>
        <div>Jue</div>
        <div>Vie</div>
        <div>Sáb</div>
        <div>Dom</div>
      </div>
      
      <div class="dias">
        <div class="vacío"></div>
        <div class="vacío"></div>
        <div class="vacío"></div>
        <div>1</div>
        <div>2</div>
        <div class="hoy">3</div>
        <div>4</div>
        <div>5</div>
        <div>6</div>
        <div>7</div>
        <div>8</div>
        <div>9</div>
        <div>10</div>
        <div>11</div>
        <div>12</div>
        <div>13</div>
        <div>14</div>
        <div>15</div>
        <div>16</div>
        <div>17</div>
        <div>18</div>
        <div>19</div>
        <div>20</div>
        <div>21</div>
        <div>22</div>
        <div>23</div>
        <div>24</div>
        <div>25</div>
        <div>26</div>
        <div>27</div>
        <div>28</div>
        <div>29</div>
        <div>30</div>
        <div>31</div>
      </div>
      </div>
      
      <!-- Botón flotante -->
      <div class="boton-flotante">
      ☰
      <div class="menu-acciones" id="menuAcciones">
        <button id="btnAñadir">➕ Añadir</button>
        <button id="btnBorrar">🗑️ Borrar</button>
        <button id="btnModificar">✏️ Modificar</button>
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