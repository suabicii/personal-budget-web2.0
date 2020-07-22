<?php

session_start();

if (isset($_SESSION['particular'])) unset($_SESSION['particular']);

$_SESSION['general'] = true;

header('Location: ../balance.php');
