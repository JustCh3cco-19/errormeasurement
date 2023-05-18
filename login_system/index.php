<?php

require_once('config.php');
$_SESSION['connessioneAttiva'] = false; // impostata su false in modo da non restituire a schermo la stringa per il check della connessione al database


// schermata login dove bisogna inserire email e password con cui ci si è registrati
if (isset($_POST['submit'])) {
   $email = $_POST['email'];
   $password = $_POST['password'];

   // uso delle prepared statements per avere un layer di sicurezza aggiuntivo nel login e prevenire sql injection
   $select = "SELECT * FROM user_form WHERE email = ?";
   $stmt = mysqli_prepare($connessione, $select);
   mysqli_stmt_bind_param($stmt, "s", $email);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   // crea un array associativo se le righe presenti nel database sono maggiori di 0 e cerca la password associata all'email
   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $stored_password = $row['password'];

      // verifica password inserita dall'utente in fase di login e quella salvata nel database per quello specifico account
      if (password_verify($password, $stored_password)) {
         /* if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin_page.php');
         } */
         // se si tratta di un account user, rediretct all'area privata per lo user 
         if ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['username'];
            header('location:area_privata');
         }
      } else { // se nel database non sono presenti l'email o password date in input dall'utente mostra a schermo il seguente messaggio
         $error[] = 'Email o password non corretta!';
      }
   }
}

// mostrare messaggio "Accedi con le tue credenziali al primo login subito dopo la registrazione"
$login_ok_message = '';

if (isset($_GET['login_ok'])) {
   $login_ok = json_decode(urldecode($_GET['login_ok']), true);
   if (is_array($login_ok)) {
      $login_ok_message = $login_ok[0]; // Prendi solo il primo messaggio
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="description" content="Inserire breve descrizione del sito">
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

         if (isset($login_ok_message) && !empty($login_ok_message)) {
            echo '<span class="login_ok">' . $login_ok_message . '</span>';
         }
         ?>

         <input type="email" name="email" required placeholder="inserisci la tua email" required>
         <input type="password" name="password" placeholder="inserisci la tua password" required>
         <input type="submit" name="submit" value="Accedi" class="form-btn">
         <p>Non hai un account? <a href="registrati">Registrati</a></p>
      </form>

   </div>

</body>

</html>