<?php
session_start();

require_once "database.php";

if (isset($_SESSION['logged_id'])) {
    header('Location: main.php');
    exit();
} else {
    $login = filter_input(INPUT_POST, 'userLogin');
    $password = filter_input(INPUT_POST, 'authorization');

    $query = $db->prepare('SELECT id, password FROM users WHERE login = :login');
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_id'] = $user['id'];
        header('Location: main.php');
        unset($_SESSION['bad_attempt']);
    } else {
        $_SESSION['bad_attempt'] = true;
        header('Location: index.php');
        exit();
    }
}
