<?php

require_once('config.php');

// kill sessione attiva
session_start();
session_unset();
session_destroy();

header('location:../'); // redirect al login
