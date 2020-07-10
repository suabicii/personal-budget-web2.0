<?php

require_once "database.php";
session_start();

/* if (!isset($_SESSION['income_added'])) {
    header('Location: add-income.php');
    exit();
} */

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
