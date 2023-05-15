<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="container">

      <div class="content">
         <h1>Benvenuto <span><?php echo $_SESSION['user_name'] ?></span></h1>
         <p>Questa è la tua Area Privata</p>
         <a href="login_form.php" class="btn">Login</a>
         <a href="register_form.php" class="btn">Registrazione account</a>
         <a href="logout.php" class="btn">Esci</a>
      </div>

   </div>

</body>

</html>