<?php

session_start();

require_once "database.php";

$_SESSION['success'] = true;

$email = $_POST['email'];
$login = filter_var($_POST['username'], FILTER_SANITIZE_STRING);

$errorStart = '<small class="text-danger">';
$errorEnd = '</small>';

if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_err'] = $errorStart . 'Podaj poprawny adres e-mail!' . $errorEnd;
    $_SESSION['success'] = false;
}

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

if (!ctype_alnum($login)) {
    $_SESSION['login_err'] = $errorStart . 'Login może składać się tylko z liter i cyfr (bez polskich znaków)!' . $errorEnd;
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

if ($_SESSION['success']) {
    $query = $db->prepare('INSERT INTO users values (NULL, :name, :surname, :email_posted, :login_posted, :password)');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query->execute([
        ":name" => $_POST['name'],
        ":surname" => $_POST['surname'],
        ":email_posted" => $email,
        ":login_posted" => $login,
        ":password" => $password
    ]);
    unset($_SESSION['success']);
    $_SESSION['register_completed'] = true;
}

header('Location: index.php');
