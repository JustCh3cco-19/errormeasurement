// pagamento tramite PayPal

paypal
  .Buttons({
    // Set up the transaction
    createOrder: function (data, actions) {
      return actions.order.create({
        purchase_units: [
          {
            amount: {
              value: "2.00",
            },
          },
        ],
      });
    },
    // Finalize the transaction
    onApprove: function (data, actions) {
      return actions.order.capture().then(function (orderData) {
        // Successful capture! For demo purposes:
        console.log(
          "Capture result",
          orderData,
          JSON.stringify(orderData, null, 2)
        );
        pagamentoEffettuato();
      });
    },
    style: {
      color: "gold",
      shape: "pill",
      label: "pay",
      height: 50,
    },
  })
  .render("#paypal-button-container");

function pagamentoEffettuato() {
  // Esegue una richiesta AJAX al tuo script PHP per aggiornare il database
  $.ajax({
    url: "../paga/aggiorna_db.php",
    type: "POST",
    data: { email: "<?php echo $email; ?>" }, // Passa l'email come dato
    success: function (response) {
      console.log(response); // Stampa la risposta dal server
      window.location.href = "../paga/success/success";
    },
    error: function (xhr, status, error) {
      console.error(error); // Gestisci eventuali errori
    },
  });
}
