<?php

require_once "redirect.php";
require_once "database.php";

if (!isset($_SESSION['default_period'])) {
    $_SESSION['default_period'] = true;
    header('Location: ./date-choice/current-month.php');
} else unset($_SESSION['default_period']);

if (isset($_SESSION['adding_expense'])) unset($_SESSION['adding_expense']);
else if (isset($_SESSION['adding_income'])) unset($_SESSION['adding_income']);

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="icons/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Personal Budget Manager 2.0 by Michael Slabikovsky</title>
</head>

<body>
    <header class="text-white text-center bg-dark py-2">
        <div class="header-content py-2">
            <h1 class="display-4">Menedżer budżetu osobistego</h1>
            <h2>Bilans <span class="period">z bieżącego miesiąca</span></h2>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="main.php"><i class="fas fa-piggy-bank"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Rozwiń menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav m-auto">
                <li class="nav-item m-auto">
                    <a class="nav-link" href="main.php">Menu główne <i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class="nav-link" href="add-income.php">Dodaj przychód <i class="fas fa-hand-holding-usd"></i></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="add-expense.php">Dodaj wydatek <i class="fas fa-wallet"></i></a>
                </li>
                <li class="nav-item active ml-lg-5 m-auto">
                    <a class=" nav-link" href="balance.php">Przeglądaj bilans <i class="fas fa-chart-line"></i><span class="sr-only">(aktualna
                            opcja)</span></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class="nav-link" href="#">Ustawienia <i class="fas fa-cog"></i></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="logout.php">Wyloguj się <i class="fas fa-sign-out-alt"></i></a>
                </li>
                <li class="nav-item dropdown active ml-lg-5 m-auto">
                    <a class="nav-link dropdown-toggle dropdown-heading" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Wybierz okres
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="current-month" href="./date-choice/current-month.php">Bieżący miesiąc</a>
                        <a class="dropdown-item" id="previous-month" href="./date-choice/previous-month.php">Poprzedni miesiąc</a>
                        <a class="dropdown-item" id="current-year" href="./date-choice/current-year.php">Bieżący rok</a>
                        <button class="dropdown-item" id="custom-date" data-toggle="modal" data-target="#customDateModal">Niestandardowy</button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="container border rounded bg-white mt-2 pt-3">
            <section class="balance">
                <div class="row justify-content-between">
                    <?php
                    // Obliczanie bilansu
                    $incomes = $_SESSION['incomes'];
                    $expenses = $_SESSION['expenses'];
                    unset($_SESSION['incomes']);
                    unset($_SESSION['expenses']);
                    $income_category = 'income_category_assigned_to_user_id';
                    $expense_category = 'expense_category_assigned_to_user_id';

                    $sumOfAllIncomes = 0;
                    $sumOfAllExpenses = 0;
                    $query = $db->prepare("SELECT * FROM incomes_category_default");
                    $query->execute();
                    $amountOfIncomesCategories = $query->rowCount();

                    // definiowanie ram czasowych do pobierania przychodów i wydatków
                    $startDate = $_SESSION['start_date'];
                    $endDate = $_SESSION['end_date'];
                    unset($_SESSION['start_date']);
                    unset($_SESSION['end_date']);

                    if ($_SESSION['logged_id'] > 1) {
                        $lastIncomeCategoryId = $amountOfIncomesCategories * $_SESSION['logged_id'];
                        $i = $amountOfIncomesCategories + 1;
                    } else {
                        $lastIncomeCategoryId = $amountOfIncomesCategories;
                        $i = 1;
                    }

                    $j = 1;

                    // Sumowanie przychodów wg kategorii
                    for ($i; $i <= $lastIncomeCategoryId; $i++) {
                        $query = $db->prepare("SELECT SUM(amount) FROM incomes WHERE {$income_category} = {$i} AND date_of_income BETWEEN '{$startDate->format('Y-m-d')}' AND '{$endDate->format('Y-m-d')}'");
                        $query->execute();
                        $sumOfIncomesInCategory[$j] = $query->fetch();
                        $j++;
                    }

                    $query = $db->prepare('SELECT * FROM expenses_category_default');
                    $query->execute();
                    $amountOfExpensesCategories = $query->rowCount();

                    if ($_SESSION['logged_id'] > 1) {
                        $lastExpenseCategoryId = $amountOfExpensesCategories * $_SESSION['logged_id'];
                        $i = $amountOfExpensesCategories + 1;
                    } else {
                        $lastExpenseCategoryId = $amountOfExpensesCategories;
                        $i = 1;
                    }

                    $j = 1;

                    // Sumowanie wydatków wg kategorii
                    for ($i; $i <= $lastExpenseCategoryId; $i++) {
                        $query = $db->prepare("SELECT SUM(amount) FROM expenses WHERE {$expense_category} = {$i} AND date_of_expense BETWEEN '{$startDate->format('Y-m-d')}' AND '{$endDate->format('Y-m-d')}'");
                        $query->execute();
                        $sumOfExpensesInCategory[$j] = $query->fetch();
                        $j++;
                    }

                    // Sumowanie wszystkich przychodów i wydatków
                    foreach ($incomes as $income) {
                        $sumOfAllIncomes += $income['amount'];
                    }

                    foreach ($expenses as $expense) {
                        $sumOfAllExpenses += $expense['amount'];
                    }

                    // Wstawianie wartości do tabel
                    echo <<< END
                    <div class="col">
                        <h3 class="text-center">Przychody</h3>
                        <table class="table table-bordered">
                            <thead class="bg-success text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="middle-col">Kategoria</th>
                                    <th scope="col">Łączna kwota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Wynagrodzenie</td>
                                    <td id="salary">{$sumOfIncomesInCategory[1]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Odsetki bankowe</td>
                                    <td id="interest">{$sumOfIncomesInCategory[2]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Sprzedaż na allegro</td>
                                    <td id="allegro">{$sumOfIncomesInCategory[3]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Inne</td>
                                    <td id="another-incomes">{$sumOfIncomesInCategory[4]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Razem</th>
                                    <td class="text-center">-</td>
                                    <th id="incomes">{$sumOfAllIncomes}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <h3 class="text-center">Wydatki</h3>
                        <table class="table table-bordered">
                            <thead class="bg-warning text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="middle-col">Kategoria</th>
                                    <th scope="col">Łączna kwota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Jedzenie</td>
                                    <td id="food">{$sumOfExpensesInCategory[3]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Mieszkanie</td>
                                    <td id="apartments">{$sumOfExpensesInCategory[4]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Transport</td>
                                    <td id="transport">{$sumOfExpensesInCategory[1]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Telekomunikacja</td>
                                    <td id="telecommunication">{$sumOfExpensesInCategory[5]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Opieka zdrowotna</td>
                                    <td id="health">{$sumOfExpensesInCategory[6]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Ubranie</td>
                                    <td id="clothes">{$sumOfExpensesInCategory[7]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>Higiena</td>
                                    <td id="hygiene">{$sumOfExpensesInCategory[8]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">8</th>
                                    <td>Dzieci</td>
                                    <td id="kids">{$sumOfExpensesInCategory[9]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">9</th>
                                    <td>Rozrywka</td>
                                    <td id="recreation">{$sumOfExpensesInCategory[10]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">10</th>
                                    <td>Wycieczka</td>
                                    <td id="trip">{$sumOfExpensesInCategory[11]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">11</th>
                                    <td>Szkolenia</td>
                                    <td id="courses">{$sumOfExpensesInCategory[17]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">12</th>
                                    <td>Książki</td>
                                    <td id="books">{$sumOfExpensesInCategory[2]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">13</th>
                                    <td>Oszczędności</td>
                                    <td id="savings">{$sumOfExpensesInCategory[12]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">14</th>
                                    <td>Na złotą jesień, czyli emeryturę</td>
                                    <td id="retirement">{$sumOfExpensesInCategory[13]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">15</th>
                                    <td>Spłata długów</td>
                                    <td id="debt-repayment">{$sumOfExpensesInCategory[14]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">16</th>
                                    <td>Darowizna</td>
                                    <td id="gift">{$sumOfExpensesInCategory[15]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">17</th>
                                    <td>Inne wydatki</td>
                                    <td id="another-expenses">{$sumOfExpensesInCategory[16]['SUM(amount)']}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Razem</th>
                                    <td class="text-center">-</td>
                                    <th id="expenses">{$sumOfAllExpenses}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

END;
                    ?>
            </section>

            <section class="charts">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div id="piechart-incomes"></div>
                    </div>
                    <div class="col-lg-6">
                        <div id="piechart-expenses"></div>
                    </div>
                </div>
            </section>

            <section class="difference py-3">
                <table class="table table-bordered">
                    <tr>
                        <th scope="col">Różnica</th>
                        <td id="difference" class="text-white"></td>
                    </tr>
                </table>
                <div class="feedback text-center">
                    <div class="onPlus">
                        <h4><span class="text-success">Gratulacje. </span>Świetnie zarządzasz finansami!</h4>
                    </div>
                    <div class="onMinus">
                        <h4><span class="text-danger">Uważaj! </span>Wpadasz w długi :(</h4>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal do wyboru niestandardowego okresu -->
        <div class="modal fade" id="customDateModal" tabindex="-1" role="dialog" aria-labelledby="customDateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customDateModalLabel">Podaj daty początku i końca okresu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="./date-choice/custom.php" method="post">
                        <div class="modal-body">
                            <div class="input-group mr-2 mb-2">
                                <label for="start-date" class="mr-2">Od</label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                                <input type="date" name="start-date" id="start-date" class="form-control" required>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <label for="end-date" class="mr-2">Do </label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                                <input type="date" name="end-date" id="end-date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                            <button type="submit" class="btn btn-some">Wybierz</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container-fluid bg-dark pt-1 mt-2">
            <div class="row">
                <div class="col">
                    <h6 class="text-white text-center">Copyright &copy; 2020 Michael Slabikovsky</h6>
                </div>
            </div>
        </div>
    </footer>

    <!-- Skrypty do prawidłowego działania Bootstrapa -->
    <script src="jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="bootstrap-4.5.0/dist/js/bootstrap.min.js"></script>

    <!-- Skrypt do wyświetlania wykresów kołowych -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Skrypt do prawidłowego wyświetlania bilansu -->
    <script src="balance.js"></script>
</body>

</html>