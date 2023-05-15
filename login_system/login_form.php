<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);
   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $stored_password = $row['password'];

      if (password_verify($password, $stored_password)) {
         /* if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin_page.php');
         } */
         if ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location:user_page.php');
         }
      } else {
         $error[] = 'Email or password incorrect!';
      }
   } else {
      $error[] = 'Email or password incorrect!';
   }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Accedi</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post">
         <h3>Login</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="email" name="email" required placeholder="inserisci la tua email">
         <input type="password" name="password" required placeholder="inserisci la tua password">
         <input type="submit" name="submit" value="Accedi" class="form-btn">
         <p>Non hai un account? <a href="register_form.php">Registrati</a></p>
      </form>

   </div>

</body>

</html>