<?php

require_once('config.php');
$_SESSION['connessioneAttiva'] = false;

// se non abbiamo una sessione attiva reindirizza l'utente al login per entrare nell'area privata
if (!isset($_SESSION['user_name'])) {
   header('location:../index');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Area Privata</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>

<body>

   <div class="container">

      <div class="content">
         <h1>Benvenuto <span><?php echo $_SESSION['user_name'] ?></span></h1> <!--messaggio di benvenuto nell'area privata-->
         <p>Questa è la tua Area Privata</p>
         <a href="../calcola/calcolaf(x)" class="btn">Calcola la funzione</a>
         <a href="../index" class="btn">Login</a>
         <a href="logout" class="btn">Logout</a>
      </div>

   </div>

</body>

</html>