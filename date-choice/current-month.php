<?php

require_once "../database.php";
session_start();

$today = date("Y-m-d");
$firstDayOfMonth = date("Y-m-01", strtotime($today));

$income_category = 'income_category_assigned_to_user_id';
// Pobieranie przychodów
$query = $db->prepare("SELECT {$income_category}, amount FROM incomes WHERE user_id = {$_SESSION['logged_id']} AND (date_of_income BETWEEN '{$firstDayOfMonth}' AND '{$today}')");
$query->execute();

$_SESSION['incomes'] = $query->fetchAll();
$incomes = $query->fetchAll();

$expense_category = 'expense_category_assigned_to_user_id';
// Pobieranie wydatków
$query = $db->prepare("SELECT {$expense_category}, amount FROM expenses WHERE user_id = {$_SESSION['logged_id']} AND (date_of_expense BETWEEN '{$firstDayOfMonth}' AND '{$today}')");
$query->execute();

$_SESSION['expenses'] = $query->fetchAll();
$expenses = $_SESSION['expenses'];

header('Location: ../balance.php');
