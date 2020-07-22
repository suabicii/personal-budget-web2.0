<?php

session_start();

$_SESSION['particular'] = true;

header('Location: ../balance.php');
