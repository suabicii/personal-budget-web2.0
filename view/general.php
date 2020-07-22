<?php

session_start();

$_SESSION['general'] = true;

header('Location: ../balance.php');
