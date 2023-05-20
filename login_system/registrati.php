<?php

require_once('config.php');
$_SESSION['connessioneAttiva'] = false; // impostata su false in modo da non restituire a schermo la stringa per il check della connessione al database


if (isset($_POST['submit'])) {
   // inizializzazione variabili per il register form
   $username = $_POST['username'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $hash_pass = password_hash($password, PASSWORD_DEFAULT);
   // $user_type = $_POST['user_type'];

   // uso delle prepared statements
   $select = "SELECT * FROM user_form WHERE username = ? OR email = ?";
   $stmt = mysqli_prepare($connessione, $select);
   mysqli_stmt_bind_param($stmt, "ss", $username, $email);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);


   // inizializzazione variabili check sia email e password singolarmente che contemporaneamente
   $esisteUsername = false;
   $esisteEmail = false;
   $esistonoEmailUsername = false;

   // check per vedere se l'input dell'utente nella sezione email e username è già stato utilizzato
   if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
         if ($row['username'] === $username && $row['email'] === $email) {
            $esistonoEmailUsername = true;
            $error[] = 'Email e username già in uso';
         } elseif ($row['username'] === $username) {
            $esisteUsername = true;
            $error[] = 'Username già in uso';
         } elseif ($row['email'] === $email) {
            $esisteEmail = true;
            $error[] = 'Email già in uso';
         }
      }
   } else {
      if ($password != $cpass) {
         $error[] = 'Le password non corrispondono!'; // errore nell'inserimento password
      } else {
         // user_type
         $verifica_email = 0;
         // prepared statments (sicurezza aggiuntiva per prevenire sql injection)
         $insert = "INSERT INTO user_form (username, email, password)  VALUES (?, ?, ?)";
         $stmt = mysqli_prepare($connessione, $insert);
         mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hash_pass); //$user_type);
         mysqli_stmt_execute($stmt);

         // header('location: index'); // redirect alla pagina di login

         // mostra a schermo Accedi con le tue credenziali nella pagina di login
         $login_ok = array("Accedi con le tue credenziali");
         header('location: index.php?login_ok=' . urlencode(json_encode($login_ok))); // redirect alla pagina di login con login_ok incluso
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
         }

         if (isset($login_ok)) {
            foreach ($login_ok as $login_ok_message) {
               echo '<span class="error-msg">' . $login_ok . '</span>';
            };
         }

         ?>

         <input type="text" name="username" placeholder="inserisci il tuo username" required>
         <input type="email" name="email" placeholder="inserisci la tua email" required>
         <input type="password" name="password" placeholder="inserisci la tua password" required>
         <input type="password" name="cpassword" placeholder="conferma la tua password" required>
         <select name="user_type">
            <!-- <option value="admin">Admin</option> -->
            <option value="user">Utente</option>
         </select>
         <input type="submit" name="submit" value="Registrati" class="form-btn">
         <p>Hai già un account? <a href="index">Accedi</a></p>
      </form>

   </div>

</body>

</html>