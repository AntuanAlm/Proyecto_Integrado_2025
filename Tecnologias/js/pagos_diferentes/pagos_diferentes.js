function pagarConPaypal() {
    if (confirm("¿Seguro que deseas pagar con PayPal?")) {
      window.location.href = "https://www.paypal.com/";
    }
  }

  function pagarConBizum() {
    if (confirm("¿Seguro que deseas pagar con Bizum?")) {
      window.location.href = "https://bizum.es/";
    }
  }

  function pagarConTarjeta() {
    if (confirm("¿Seguro que deseas pagar con tarjeta?")) {
      window.location.href = "https://www.stripe.com/";
    }
  }