<?php

require_once "../database.php";
session_start();

$beginningOfYear = new DateTime('first day of January');
$today = new DateTime();

echo $beginningOfYear->format('Y-m-d');

$_SESSION['start_date'] = $beginningOfYear;
$_SESSION['end_date'] = $today;

$income_category = 'income_category_assigned_to_user_id';
// Pobieranie przychodów
$query = $db->prepare("SELECT {$income_category}, amount FROM incomes WHERE user_id = {$_SESSION['logged_id']} AND (date_of_income BETWEEN '{$beginningOfYear->format('Y-m-d')}' AND '{$today->format('Y-m-d')}')");
$query->execute();

$_SESSION['incomes'] = $query->fetchAll();

$expense_category = 'expense_category_assigned_to_user_id';
// Pobieranie wydatków
$query = $db->prepare("SELECT {$expense_category}, amount FROM expenses WHERE user_id = {$_SESSION['logged_id']} AND (date_of_expense BETWEEN '{$beginningOfYear->format('Y-m-d')}' AND '{$today->format('Y-m-d')}')");
$query->execute();

$_SESSION['expenses'] = $query->fetchAll();

$_SESSION['current_year'] = true;

header('Location: ../balance.php');
