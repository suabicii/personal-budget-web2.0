<?php

require_once "../database.php";
session_start();

$today = new DateTime();
$firstDayOfMonth = new DateTime($today->format('Y-m') . "-01");

$_SESSION['start_date'] = $firstDayOfMonth;
$_SESSION['end_date'] = $today;

// Pobieranie przychodów
$query = $db->prepare("SELECT amount FROM incomes WHERE user_id = {$_SESSION['logged_id']} AND (date_of_income BETWEEN '{$firstDayOfMonth->format('Y-m-d')}' AND '{$today->format('Y-m-d')}')");
$query->execute();

$_SESSION['incomes'] = $query->fetchAll();

// Pobieranie wydatków
$query = $db->prepare("SELECT amount FROM expenses WHERE user_id = {$_SESSION['logged_id']} AND (date_of_expense BETWEEN '{$firstDayOfMonth->format('Y-m-d')}' AND '{$today->format('Y-m-d')}')");
$query->execute();

$_SESSION['expenses'] = $query->fetchAll();

header('Location: ../balance.php');
