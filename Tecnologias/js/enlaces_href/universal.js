document.addEventListener('DOMContentLoaded', () => {
    // Obtén todos los enlaces con el atributo data-enlace
    const enlaces = document.querySelectorAll('[data-enlace]');
  
    // Configura las rutas en un objeto
    const rutas = {
      inicio: '/Tecnologias/html/Vista_Principal/index.html',
      sobre_nosotros: '/Tecnologias/html/sobre_nosotros/sobre_nosotros.html',
      reseñas: '/Tecnologias/html/reseñas/reseñas.html',
      precio: '/Tecnologias/html/precio/precio.html',
      politica_pasarela_pago: '/Tecnologias/html/politica_pasarela_pago/politica_pasarela_pago.html',
      pasarela_pago: '/Tecnologias/html/pasarela_pago/pasarela_pago.html',
      contacto: '/Tecnologias/html/contacto/contacto.html',
      coche: '/Tecnologias/html/coche/coche.html',
      logo_reseñas_google: '/Tecnologias/img/logo/reviews-google.png',
      cursos_intensivos: '/Tecnologias/html/curso_intensivo/curso_intensivo.html',
      clases_reciclaje: '/Tecnologias/html/clases_reciclajes/clases_reciclajes.html',
      profesores:'/Tecnologias/html/conoce_profesores/conoce_profesores.html',
      test:'/Tecnologias/html/test-alumnos/test-alumnos.html',
      calendario:'/Tecnologias/html/calendario/calendario.html',
      formulario_registro_nuevo_cliente:'Tecnologias/html/formularios/formulario_registro_cliente/formulario_registro_cliente.html',
      agradecimiento:'Tecnologias/html/agradecimiento_pago/agradecimiento_pago.html',

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
  