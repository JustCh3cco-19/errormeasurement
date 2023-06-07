<?php
session_start();

// variabili utilizzate per la connessione al database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'user_db';

// connessione al database
$connessione = new mysqli($host, $user, $password, $database);

function stampaConnessione()
{
    global $connessione;
    // check connessione al database, con inizializzazione variabile $_SESSION['connessioneAttiva'] per impedire alla funzione di stampare in tutte le pagine il check della connessione al database
    if ($connessione == true && isset($_SESSION['connessioneAttiva']) && $_SESSION['connessioneAttiva']) {
        echo "Connessione riuscita: " . $connessione->host_info;
        $_SESSION['connessioneAttiva'] = false; // impostata su false per evitare la visualizzazione ripetuta del messaggio
    } elseif ($connessione == false) {
        echo "Errore durante la connessione: " . $connessione->connect_error;
    }
}

if ($connessione->connect_errno) {
    $_SESSION['connessioneAttiva'] = false;
} else {
    $_SESSION['connessioneAttiva'] = true;
}
