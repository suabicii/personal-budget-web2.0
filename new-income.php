<?php

require_once "database.php";
session_start();

// dzisiejsza data
$today = date('Y-m-d');

if ($_POST['amount'] < 0) {
    $_SESSION['amount_err'] = '<small class="text-danger">Podaj liczbę dodatnią!</small>';
    header('Location: add-income.php');
    exit();
}

if ($_POST['date'] > $today) {
    $_SESSION['date_err'] = '<small class="text-danger">Data nie może być późniejsza od dzisiejszej!</small>';
    header('Location: add-income.php');
    exit();
}

$query = $db->prepare('SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :name');
$query->execute([
    ":user_id" => $_SESSION['logged_id'],
    ":name" => $_POST['category']
]);
$income_category_id = $query->fetch();

$query = $db->prepare('INSERT INTO incomes VALUES (
    NULL,
    :user_id,
    :income_category_assigned_to_user_id,
    :amount,
    :date,
    :comment
)');
$query->execute([
    ":user_id" => $_SESSION['logged_id'],
    ":income_category_assigned_to_user_id" => $income_category_id['id'],
    ":amount" => $_POST['amount'],
    ":date" => $_POST['date'],
    ":comment" => $_POST['comment']
]);

$_SESSION['income_added'] = true;
header('Location: add-income.php');
