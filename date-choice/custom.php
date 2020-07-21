<?php

require_once "../database.php";
session_start();

$_SESSION['start_date'] = $_POST['start-date'];
$_SESSION['end_date'] = $_POST['end-date'];

// Pobieranie przychodów
$query = $db->prepare("SELECT amount FROM incomes WHERE user_id = {$_SESSION['logged_id']} AND (date_of_income BETWEEN '{$_POST['start-date']}' AND '{$_POST['end-date']}')");
$query->execute();

$_SESSION['incomes'] = $query->fetchAll();

$expense_category = 'expense_category_assigned_to_user_id';
// Pobieranie wydatków
$query = $db->prepare("SELECT amount FROM expenses WHERE user_id = {$_SESSION['logged_id']} AND (date_of_expense BETWEEN '{$_POST['start-date']}' AND '{$_POST['end-date']}')");
$query->execute();

$_SESSION['expenses'] = $query->fetchAll();

$_SESSION['custom_date'] = true;

header('Location: ../balance.php');
