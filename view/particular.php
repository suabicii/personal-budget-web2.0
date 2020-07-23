<?php

session_start();

if (isset($_SESSION['general'])) unset($_SESSION['general']);

$_SESSION['particular'] = true;

header('Location: ../balance.php');
