<?php

require_once "database.php";
session_start();

// dzisiejsza data
$today = date('Y-m-d');

if ($_POST['amount'] < 0) {
    $_SESSION['amount_err'] = '<small class="text-danger mt-2">Podaj liczbę dodatnią!</small>';
    header('Location: add-income.php');
    exit();
}

if ($_POST['date'] > $today) {
    $_SESSION['date_err'] = '<small class="text-danger mt-2">Data nie może być późniejsza od dzisiejszej!</small>';
    header('Location: add-income.php');
    exit();
}

if (isset($_SESSION['adding_income'])) {
    $query = $db->prepare("SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :user_id AND name = :name");
    $query->execute([
        ":user_id" => $_SESSION['logged_id'],
        ":name" => $_POST['category']
    ]);
    $category_id = $query->fetch();

    $query = $db->prepare("INSERT INTO incomes VALUES (
    NULL,
    :user_id,
    :category_assigned_to_user_id,
    :amount,
    :date,
    :comment
)");
    $query->execute([
        ":user_id" => $_SESSION['logged_id'],
        ":category_assigned_to_user_id" => $category_id['id'],
        ":amount" => $_POST['amount'],
        ":date" => $_POST['date'],
        ":comment" => $_POST['comment']
    ]);

    $_SESSION['income_added'] = true;
    header('Location: add-income.php');
} elseif (isset($_SESSION['adding_expense'])) {
    $query = $db->prepare("SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :user_id AND name = :name");
    $query->execute([
        ":user_id" => $_SESSION['logged_id'],
        ":name" => $_POST['category']
    ]);
    $category_id = $query->fetch();

    $query = $db->prepare("SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :user_id AND name = :name");
    $query->execute([
        ":user_id" => $_SESSION['logged_id'],
        ":name" => $_POST['payment']
    ]);
    $payment_id = $query->fetch();

    $query = $db->prepare("INSERT INTO expenses VALUES (
    NULL,
    :user_id,
    :category_assigned_to_user_id,
    :payment_assigned_to_user_id,
    :amount,
    :date,
    :comment
)");
    $query->execute([
        ":user_id" => $_SESSION['logged_id'],
        ":category_assigned_to_user_id" => $category_id['id'],
        "payment_assigned_to_user_id" => $payment_id['id'],
        ":amount" => $_POST['amount'],
        ":date" => $_POST['date'],
        ":comment" => $_POST['comment']
    ]);

    $_SESSION['expense_added'] = true;
    header('Location: add-expense.php');
}
