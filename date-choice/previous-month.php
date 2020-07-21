<?php

require_once "../database.php";
session_start();

$baseDate = new DateTime();
$baseDate->modify('-1 month');

$beginningOfMonth = new DateTime($baseDate->format('Y-m') . '-01');

$baseDate->modify('last day of this month');

$endOfMonth = new DateTime($baseDate->format('Y-m-d'));

echo $beginningOfMonth->format('Y-m-d') . '<br>';
echo $endOfMonth->format('Y-m-d') . '<br>';

$_SESSION['start_date'] = $beginningOfMonth;
$_SESSION['end_date'] = $endOfMonth;

// Pobieranie przychodów
$query = $db->prepare("SELECT amount FROM incomes WHERE user_id = {$_SESSION['logged_id']} AND (date_of_income BETWEEN '{$beginningOfMonth->format('Y-m-d')}' AND '{$endOfMonth->format('Y-m-d')}')");
$query->execute();

$_SESSION['incomes'] = $query->fetchAll();

// Pobieranie wydatków
$query = $db->prepare("SELECT amount FROM expenses WHERE user_id = {$_SESSION['logged_id']} AND (date_of_expense BETWEEN '{$beginningOfMonth->format('Y-m-d')}' AND '{$endOfMonth->format('Y-m-d')}')");
$query->execute();

$_SESSION['expenses'] = $query->fetchAll();

$_SESSION['previous_month'] = true;

header('Location: ../balance.php');
