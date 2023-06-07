<?php

require_once('../login/config.php');
$email = $_SESSION['email'] ?? null; // Se l'email non è disponibile, assegna il valore null

if ($email) {
  $query = "UPDATE user_form SET pagato = 1 WHERE email = ?";
  $stmt = mysqli_prepare($connessione, $query);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Database aggiornato con successo";
  } else {
    echo "Errore nell'aggiornamento del database";
  }
} else {
  echo "Email non disponibile";
}
