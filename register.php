<?php

session_start();

require_once "database.php";

$_SESSION['success'] = true;

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$login = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

$errorStart = '<small class="text-danger">';
$errorEnd = '</small>';

$query = $db->prepare('SELECT email FROM users WHERE email = :email');
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->execute();

if ($query->rowCount() > 0) {
    $_SESSION['email_err'] = $errorStart . 'Podany adres e-mail już istnieje w bazie danych!' . $errorEnd;
    $_SESSION['success'] = false;
}

if (strlen($login) < 4 || strlen($login) > 20) {
    $_SESSION['login_err'] = $errorStart . 'Login musi posiadać od 4 do 20 znaków!' . $errorEnd;
    $_SESSION['success'] = false;
}

$query = $db->prepare('SELECT login FROM users WHERE login = :login');
$query->bindValue(':login', $login, PDO::PARAM_STR);
$query->execute();

if ($query->rowCount() > 0) {
    $_SESSION['login_err'] = $errorStart . 'Podany login już istnieje w bazie danych!' . $errorEnd;
    $_SESSION['success'] = false;
}

if ($_POST['password'] != $_POST['passwordConfirmation']) {
    $_SESSION['pswd_err'] = $errorStart . 'Hasła w obu polach muszą być takie same!' . $errorEnd;
    $_SESSION['success'] = false;
}

header('Location: index.php');
