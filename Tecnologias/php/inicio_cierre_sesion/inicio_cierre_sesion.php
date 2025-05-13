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