<?php

session_start();
unset($_SESSION['logged_id']);
unset($_SESSION['logged_name']);

header('Location: index.php');
