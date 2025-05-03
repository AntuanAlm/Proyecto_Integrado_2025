document.addEventListener('DOMContentLoaded', () => {
    // Obtén todos los enlaces con el atributo data-enlace
    const enlaces = document.querySelectorAll('[data-enlace]');
  
    // Configura las rutas en un objeto (rutas relativas ajustadas)
    const rutas = {
        inicio: '../../../html/Vista_Principal/index.html',
        sobre_nosotros: '../../../html/sobre_nosotros/sobre_nosotros.html',
        reseñas: '../../../html/reseñas/reseñas.html',
        precio: '../../../html/precio/precio.html',
        politica_pasarela_pago: '../../../html/politica_pasarela_pago/politica_pasarela_pago.html',
        pasarela_pago: '../../../html/pasarela_pago/pasarela_pago.html',
        contacto: '../../../html/contacto/contacto.html',
        coche: '../../../html/coche/coche.html',
        cursos_intensivos: '../../../html/curso_intensivo/curso_intensivo.html',
        clases_reciclaje: '../../../html/clases_reciclajes/clases_reciclajes.html',
        profesores: '../../../html/conoce_profesores/conoce_profesores.html',
        test: '../../../html/test-alumnos/test-alumnos.html',
        calendario: '../../../html/calendario/calendario.html',
        formulario_registro_nuevo_cliente: '../../../html/formularios/formulario_registro_cliente/formulario_registro_cliente.html',
        agradecimiento: '../../../html/agradecimiento_pago/agradecimiento_pago.html',
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
  