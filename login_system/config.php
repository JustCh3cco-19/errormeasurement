<?php
// variabili di connessione al database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'user_db';

// connessione al database
$connessione = new mysqli($host, $user, $password, $database);

// check se la connessione al database non risulta attiva mostra il seguente errore
if ($connessione == true) {
    echo 'Connessione al database ' . $host . ' riuscita';
} else {
    echo "Errore durante la connessione: " . $connessione->connect_error;
}
