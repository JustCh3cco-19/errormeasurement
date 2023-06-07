<?php

require_once('config.php');
$_SESSION['connessioneAttiva'] = true;

// Se non abbiamo una sessione attiva, reindirizza l'utente al login per accedere all'area privata
if (!isset($_SESSION['user_name'])) {
   header('location:../index');
   exit; // Aggiunto per terminare l'esecuzione dello script dopo il reindirizzamento
}

// Controlla se l'utente ha pagato
// $pagato = 0; // Valore predefinito per chi non ha pagato il servizio

if (isset($_SESSION['user_name'])) {
   $username = $_SESSION['user_name'];

   $query = "SELECT pagato FROM user_form WHERE username = '$username'";
   $result = mysqli_query($connessione, $query);

   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION['pagato'] = $row['pagato'];
      // echo $_SESSION['pagato'];
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Area Privata</title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

</head>

<body>

   <div class="container">

      <div class="content">
         <h1>Ciao <span><?php echo $_SESSION['user_name']; ?></span></h1>
         <p>Questa è la tua Area Privata</p>
         <?php if ($_SESSION['pagato'] == 1) : ?>
            <a href="../calcola/calcolaf(x).html" class="btn">Calcola la funzione</a>
         <?php else : ?>
            <p>Clicca uno di questi bottoni per poterci supportare con un piccolo contributo!</p>
            <div id="paypal-button-container"></div>
            <script src="https://www.paypal.com/sdk/js?client-id=ASBcA_JGwWk6AYu8JkQA8Z9Izj5e2mjbZwJNgI7axRjuxhvk_I_n4cXZfXML1wQyJO9Io87q8IHmr4Z2&currency=EUR&buyer-country=IT&locale=it_IT"></script>
            <script src="../paga/paypal.js"></script>
         <?php endif; ?>
         <a href="../" class="btn">Login</a>
         <a href="logout" class="btn">Logout</a>
      </div>

   </div>

</body>

</html>