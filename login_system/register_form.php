<?php

@include 'config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['password']);
   $hash_pass = password_hash($password, PASSWORD_DEFAULT); //  encrypt password 
   $hash_cpass = $hash_pass; // encrypt confirm password
   // $pass = md5($_POST['password']); craccano la password facilmente
   // $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$hash_pass' ";

   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {

      $error[] = 'Questo utente già esiste';
   } else {

      if ($hash_pass != $hash_cpass) {
         $error[] = 'password not matched!';
      } else {
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$hash_pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registrati</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="form-container">

      <form action="" method="post">
         <h3>Registrati</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
            };
         };
         ?>
         <input type="text" name="name" required placeholder="inserisci il tuo nome">
         <input type="email" name="email" required placeholder="inserisci la tua email">
         <input type="password" name="password" required placeholder="inserisci la tua password">
         <input type="password" name="cpassword" required placeholder="conferma la tua password">
         <select name="user_type">
            <option value="user">Utente</option>
         </select>
         <input type="submit" name="submit" value="Registrati" class="form-btn">
         <p>Hai già un account? <a href="login_form.php">Accedi</a></p>
      </form>

   </div>

</body>

</html>