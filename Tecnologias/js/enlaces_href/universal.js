document.addEventListener('DOMContentLoaded', () => {
  // Obtén todos los enlaces con el atributo data-enlace
  const enlaces = document.querySelectorAll('[data-enlace]');

  // Configura las rutas en un objeto (rutas relativas ajustadas)
  const rutas = {
      inicio: '../../html/Vista_Principal/index.php',
      sobre_nosotros: '../../html/sobre_nosotros/sobre_nosotros.html',
      reseñas: '../../html/reseñas/reseñas.html',
      precio: '../../html/precio/precio.html',
      politica_pasarela_pago: '../../html/politica_pasarela_pago/politica_pasarela_pago.html',
      pasarela_pago: '../../html/pasarela_pago/pasarela_pago.html',
      contacto: '../../html/contacto/contacto.html',
      coche: '../../html/coche/coche.html',
      logo_reseñas_google: '../../img/logo/reviews-google.png',
      cursos_intensivos: '../../html/curso_intensivo/curso_intensivo.html',
      clases_reciclaje: '../../html/clases_reciclajes/clases_reciclajes.html',
      profesores: '../../html/conoce_profesores/conoce_profesores.html',
      test: '../../html/test-alumnos/test-alumnos.php',
      calendario: '../../html/calendario/calendario.html',
      formulario_registro_nuevo_cliente: '../../html/formularios/formulario_registro_cliente/formulario_registro_cliente.html',
      agradecimiento: '../../html/agradecimiento_pago/agradecimiento_pago.html',
      descripcion_coche_autoescuela:'../../html/descripcion_coche_autoescuela/descripción_coche_autoescuela.html',
      test_tematicos:'../../html/test_tematicos/menu_test_tematicos.html',
      login_usuario:'../../html/login_usuario/login_usuario.html',
      login_pago:'../../html/alumno_nuevoAlumno/alumno_nuevoAlumno.php',
      compras_usuario:'../../html/perfil_usuario_compras/perfil_usuario_compras.html',
      area_alumno:'../../html/area_alumnos/area_alumnos.php',
      resultados:'../../php/resultados_usuario/resultado.php',
      test_aleatorio:'../../html/test_aleatorio/menu_test_aleatorio.html',
      test_examen:'../../html/test_examen/menu_test_examen.html',
      login_profesores:'../../html/login_area_profesores/login_area_profesores.php',
  };

  // Asocia un evento a cada enlace
  enlaces.forEach(enlace => {
      enlace.addEventListener('click', (e) => {
          e.preventDefault();  // Prevenir la acción predeterminada del enlace
          const destino = enlace.getAttribute('data-enlace');

          // Verifica si existe una ruta definida para este enlace
          if (rutas[destino]) {
              window.location.href = rutas[destino];
          } else {
              console.warn('Ruta no definida para:', destino);
          }
      });
  });
});
