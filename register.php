<?php

session_start();

require_once "database.php";

$success = false;

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$login = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

$query = $db->prepare('SELECT email FROM users WHERE email = :email');
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->execute();

if ($query->rowCount() > 0) $_SESSION['email_err'] = '<small class="text-danger">Podany adres e-mail już istnieje w bazie danych!</small>';

$query = $db->prepare('SELECT login FROM users WHERE login = :login');
$query->bindValue(':login', $login, PDO::PARAM_STR);
$query->execute();

if ($query->rowCount() > 0) $_SESSION['login_err'] = '<small class="text-danger">Podany login już istnieje w bazie danych!</small>';

header('Location: index.php');
