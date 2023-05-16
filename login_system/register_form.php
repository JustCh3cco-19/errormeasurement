<?php

require_once('config.php');

if (isset($_POST['submit'])) {
   // inizializzazione variabili per il register form
   $name = $_POST['name'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $hash_pass = password_hash($password, PASSWORD_DEFAULT);
   $user_type = $_POST['user_type'];

   // uso delle prepared statements
   $select = "SELECT * FROM user_form WHERE email = ?";
   $stmt = mysqli_prepare($connessione, $select);
   mysqli_stmt_bind_param($stmt, "s", $email);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   // check per vedere se l'input dell'utente nella sezione email è già stato utilizzato
   if (mysqli_num_rows($result) > 0) {
      $error[] = 'Email già utilizzata!';
   } else {
      if ($password != $cpass) {
         $error[] = 'Le password non corrispondono!'; // errore nell'inserimento password
      } else {
         // prepared statments (sicurezza aggiuntiva per prevenire sql injection)
         $insert = "INSERT INTO user_form (name, email, password, user_type) VALUES (?, ?, ?, ?)";
         $stmt = mysqli_prepare($connessione, $insert);
         mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hash_pass, $user_type);
         mysqli_stmt_execute($stmt);

         header('location: index.php'); // redirect alla pagina di login
      }
   }
}
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

         <input type="text" name="name" required placeholder="inserisci il tuo nome" required>
         <input type="email" name="email" required placeholder="inserisci la tua email" required>
         <input type="password" name="password" required placeholder="inserisci la tua password" required>
         <input type="password" name="cpassword" required placeholder="conferma la tua password" required>
         <select name="user_type">
            <!-- <option value="admin">Admin</option> -->
            <option value="user">Utente</option>
         </select>
         <input type="submit" name="submit" value="Registrati" class="form-btn">
         <p>Hai già un account? <a href="index.php">Accedi</a></p>
      </form>

   </div>

</body>

</html>