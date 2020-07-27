<?php

require_once "redirect.php";
require_once "database.php";
require_once "categories.php";

if (!isset($_SESSION['default_period']) && !isset($_SESSION['previous_month']) && !isset($_SESSION['current_year']) && !isset($_SESSION['custom_date'])) {
    $_SESSION['default_period'] = true;
    header('Location: ./date-choice/current-month.php');
} else if (isset($_SESSION['previous_month'])) {
    unset($_SESSION['previous_month']);
    $period = '<span>z poprzedniego miesiąca</span>';
} else if (isset($_SESSION['current_year'])) {
    unset($_SESSION['current_year']);
    $period = '<span>z bieżącego roku</span>';
} else if (isset($_SESSION['custom_date'])) {
    $period = '<span>z okresu od ' . $_SESSION['start_date'] . ' do ' . $_SESSION['end_date'] . '</span>';
} else {
    unset($_SESSION['default_period']);
    $period = '<span>z bieżącego miesiąca</span>';
}

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
    <link rel="stylesheet" href="css/main.css">
    <title>Personal Budget Manager 2.0 by Michael Slabikovsky</title>
</head>

<body>
    <header class="text-white text-center bg-dark py-2">
        <div class="header-content py-2">
            <h1 class="display-4">Menedżer budżetu osobistego</h1>
            <h2>Bilans <?= $period ?></h2>
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
            </ul>
        </div>
    </nav>

    <main>
        <div class="container border rounded bg-white mt-2 pt-3">
            <section class="balance">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-other btn-lg btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Wybierz widok
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" id="current-month" href="./view/general.php">Ogólny</a>
                            <a class="dropdown-item" id="previous-month" href="./view/particular.php">Szczegółowy</a>
                        </div>
                    </div>
                    <div class="col-md-6 period-choice">
                        <button type="button" class="btn btn-info btn-lg btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Wybierz okres
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" id="current-month" href="./date-choice/current-month.php">Bieżący miesiąc</a>
                            <a class="dropdown-item" id="previous-month" href="./date-choice/previous-month.php">Poprzedni miesiąc</a>
                            <a class="dropdown-item" id="current-year" href="./date-choice/current-year.php">Bieżący rok</a>
                            <button class="dropdown-item" id="custom-date" data-toggle="modal" data-target="#customDateModal">Niestandardowy</button>
                        </div>
                    </div>
                </div>
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

                // Ustalanie ram czasowych do pobierania przychodów i wydatków
                $startDate = $_SESSION['start_date'];
                $endDate = $_SESSION['end_date'];
                unset($_SESSION['start_date']);
                unset($_SESSION['end_date']);

                if (isset($_SESSION['custom_date'])) {
                    $startDateForQuery = $startDate;
                    $endDateForQuery = $endDate;
                    unset($_SESSION['custom_date']);
                } else {
                    $startDateForQuery = $startDate->format('Y-m-d');
                    $endDateForQuery = $endDate->format('Y-m-d');
                }

                // Sumowanie wszystkich przychodów i wydatków
                foreach ($incomes as $income) {
                    $sumOfAllIncomes += $income['amount'];
                }

                foreach ($expenses as $expense) {
                    $sumOfAllExpenses += $expense['amount'];
                }

                // Wstawianie wartości do tabel
                if (isset($_SESSION['particular'])) { // Widok szczegółowy
                    echo '<script>let particularView = true;</script>';
                    echo <<< END
                    <div class="row justify-content-between">
                        <div class="col">
                            <h3 class="text-center">Przychody</h3>
                            <table class="table table-bordered">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kategoria</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Kwota</th>
                                        <th scope="col">Komentarz</th>
                                    </tr>
                                </thead>
                                <tbody>
END;
                    // Pobieranie wszystkiego jak leci
                    $query =  $db->prepare("SELECT incomes.user_id, income_category_assigned_to_user_id, name, amount, date_of_income, income_comment FROM incomes, incomes_category_assigned_to_users WHERE incomes_category_assigned_to_users.id = incomes.{$income_category} AND incomes.user_id = {$_SESSION['logged_id']} AND date_of_income BETWEEN '{$startDateForQuery}' AND '{$endDateForQuery}' ORDER BY amount DESC");
                    $query->execute();

                    $allIncomes = $query->fetchAll();
                    $amountOfAllIncomes = $query->rowCount();

                    $j = 1;

                    for ($i = 0; $i < $amountOfAllIncomes; $i++) {
                        $categoryName = $incomesCategories["{$allIncomes[$i]['name']}"];

                        if ($allIncomes[$i]['name'] == 'Another') $categoryClassForJS = 'another-incomes';
                        else $categoryClassForJS = $allIncomes[$i]['name'];

                        echo <<< END
                                    <tr>
                                        <th scope="row">{$j}</th>
                                        <td>{$categoryName}</td>
                                        <td>{$allIncomes[$i]['date_of_income']}</td>
                                        <td class="{$categoryClassForJS}">{$allIncomes[$i]['amount']}</td>
                                        <td>{$allIncomes[$i]['income_comment']}</td>
                                    </tr>
END;
                        $j++;
                    }

                    echo <<< END
                                    <tr>
                                        <th scope="row">Razem</th>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <th id="incomes">{$sumOfAllIncomes}</th>
                                        <td class="text-center">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

END;

                    echo <<< END
                    <div class="row justify-content-between">
                        <div class="col">
                            <h3 class="text-center">Wydatki</h3>
                            <table class="table table-bordered">
                                <thead class="bg-warning text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kategoria</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Kwota</th>
                                        <th scope="col">Komentarz</th>
                                    </tr>
                                </thead>
                                <tbody>
END;
                    $query =  $db->prepare("SELECT expenses.user_id, expense_category_assigned_to_user_id, name, amount, date_of_expense, expense_comment FROM expenses, expenses_category_assigned_to_users WHERE expenses_category_assigned_to_users.id = expenses.{$expense_category} AND expenses.user_id = {$_SESSION['logged_id']} AND date_of_expense BETWEEN '{$startDateForQuery}' AND '{$endDateForQuery}' ORDER BY amount DESC");
                    $query->execute();

                    $allExpenses = $query->fetchAll();
                    $amountOfAllExpenses = $query->rowCount();

                    $j = 1;

                    for ($i = 0; $i < $amountOfAllExpenses; $i++) {
                        $categoryName = $expensesCategories["{$allExpenses[$i]['name']}"];

                        if ($allExpenses[$i]['name'] == 'Another') $categoryClassForJS = 'another-expenses';
                        else if ($allExpenses[$i]['name'] == 'For Retirement') $categoryClassForJS = 'retirement';
                        else if ($allExpenses[$i]['name'] == 'Debt Repayment') $categoryClassForJS = 'debt-repayment';
                        else $categoryClassForJS = $allExpenses[$i]['name'];

                        echo <<< END
                                    <tr>
                                        <th scope="row">{$j}</th>
                                        <td>{$categoryName}</td>
                                        <td>{$allExpenses[$i]['date_of_expense']}</td>
                                        <td class="{$categoryClassForJS}">{$allExpenses[$i]['amount']}</td>
                                        <td>{$allExpenses[$i]['expense_comment']}</td>
                                    </tr>
END;
                        $j++;
                    }

                    echo <<< END
                                    <tr>
                                        <th scope="row">Razem</th>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <th id="expenses">{$sumOfAllExpenses}</th>
                                        <td class="text-center">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

END;
                } else { // Widok ogólny
                    echo '<script>let particularView = false;</script>';
                    echo <<< END
                    <div class="row justify-content-between">
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
END;

                    $query = $db->prepare("SELECT {$income_category}, name, SUM(amount) FROM incomes, incomes_category_assigned_to_users WHERE incomes.user_id = {$_SESSION['logged_id']} AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id AND date_of_income BETWEEN '{$startDateForQuery}' AND '{$endDateForQuery}' GROUP BY {$income_category} ORDER BY SUM(amount) DESC");
                    $query->execute();

                    $amountOfSummedIncomes = $query->rowCount();
                    $summedIncomes = $query->fetchAll();

                    $j = 1;
                    for ($i = 0; $i < $amountOfSummedIncomes; $i++) {
                        $categoryName = $incomesCategories["{$summedIncomes[$i]['name']}"];

                        if ($summedIncomes[$i]['name'] == 'Another') $categoryIdForJS = 'another-incomes';
                        else $categoryIdForJS = $summedIncomes[$i]['name'];

                        echo <<< END
                                    <tr>
                                        <th scope="row">{$j}</th>
                                        <td>{$categoryName}</td>
                                        <td id="{$categoryIdForJS}">{$summedIncomes[$i]['SUM(amount)']}</td>
                                    </tr>
END;
                        $j++;
                    }

                    echo <<< END
                                    <tr>
                                        <th scope="row">Razem</th>
                                        <td class="text-center">-</td>
                                        <th id="incomes">{$sumOfAllIncomes}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
END;
                    echo <<< END
                <div class="row justify-content-between">
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
END;

                    $query = $db->prepare("SELECT {$expense_category}, name, SUM(amount) FROM expenses, expenses_category_assigned_to_users WHERE expenses.user_id = {$_SESSION['logged_id']} AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id AND date_of_expense BETWEEN '{$startDateForQuery}' AND '{$endDateForQuery}' GROUP BY {$expense_category} ORDER BY SUM(amount) DESC");
                    $query->execute();

                    $amountOfSummedExpenses = $query->rowCount();
                    $summedExpenses = $query->fetchAll();

                    $j = 1;
                    for ($i = 0; $i < $amountOfSummedExpenses; $i++) {
                        $categoryName = $expensesCategories["{$summedExpenses[$i]['name']}"];

                        if ($summedExpenses[$i]['name'] == 'Another') $categoryIdForJS = 'another-expenses';
                        else if ($summedExpenses[$i]['name'] == 'For Retirement') $categoryIdForJS = 'retirement';
                        else if ($summedExpenses[$i]['name'] == 'Debt Repayment') $categoryIdForJS = 'debt-repayment';
                        else $categoryIdForJS = $summedExpenses[$i]['name'];

                        echo <<< END
                                    <tr>
                                        <th scope="row">{$j}</th>
                                        <td>{$categoryName}</td>
                                        <td id="{$categoryIdForJS}">{$summedExpenses[$i]['SUM(amount)']}</td>
                                    </tr>
END;
                        $j++;
                    }

                    echo <<< END
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
                }
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
                                <label for="start-date" class="mr-2">Od </label>
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