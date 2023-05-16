<?php

require_once('config.php');
$_SESSION['connessioneAttiva'] = true; // impostata su true in modo da vedere se la connessione al database è attiva

if (!isset($_SESSION['admin_name'])) {
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="container">

      <div class="content">
         <h1>Benvenuto, <span><?php echo $_SESSION['admin_name'] ?></span></h1>
         <p>Questa la sezione Admin</p>
         <a href="register_form.php" class="btn">Registrazione Account</a>
         <a href="index.php" class="btn">Login</a>
         <a href="logout.php" class="btn">Logout</a>
      </div>

   </div>

</body>

</html>