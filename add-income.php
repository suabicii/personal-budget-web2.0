<?php

require_once "redirect.php";
$_SESSION['adding_income'] = true;

if (isset($_SESSION['adding_expense'])) unset($_SESSION['adding_expense']);

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
            <h2>Dodaj przychód</h2>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="main.php"><i class="fas fa-piggy-bank"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Rozwiń menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav m-auto">
                <li class="nav-item m-auto">
                    <a class="nav-link" href="main.php">Menu główne <i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item active ml-lg-5 m-auto">
                    <a class="nav-link" href="add-income.php">Dodaj przychód <i class="fas fa-hand-holding-usd"></i><span class="sr-only">(aktualna
                            opcja)</span></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="add-expense.php">Dodaj wydatek <i class="fas fa-wallet"></i></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="balance.php">Przeglądaj bilans <i class="fas fa-chart-line"></i></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="#">Ustawienia <i class="fas fa-cog"></i></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="logout.php">Wyloguj się <i class="fas fa-sign-out-alt"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        <section class="adding-incomes">
            <div class="container-custom border rounded bg-white mt-2 py-2">
                <div class="row justify-content-center">
                    <form action="insert.php" method="post">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text pr-3"><i class="fas fa-dollar-sign"></i></div>
                            </div>
                            <label class="sr-only" for="amount">Kwota</label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Kwota" step="0.01" required>
                        </div>
                        <?php

                        if (isset($_SESSION['amount_err'])) {
                            echo $_SESSION['amount_err'];
                            unset($_SESSION['amount_err']);
                        }

                        ?>
                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text pr-2"><i class="fas fa-money-check"></i></div>
                            </div>
                            <label class="sr-only" for="category">Kategoria</label>
                            <select name="category" id="category" class="form-control" required>
                                <option selected disabled>Wybierz kategorię</option>
                                <option value="Salary">Wynagrodzenie</option>
                                <option value="Interest">Odsetki</option>
                                <option value="Allegro">Sprzedaż na allegro</option>
                                <option value="Another">Inne</option>
                            </select>
                        </div>
                        <div class="input-group mt-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                            <label class="sr-only" for="date">Data</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <?php

                        if (isset($_SESSION['date_err'])) {
                            echo $_SESSION['date_err'];
                            unset($_SESSION['date_err']);
                        }

                        ?>
                        <div class="input-group mt-2 mb-2">
                            <label class="sr-only" for="comment">Komentarz (opcjonalnie)</label>
                            <textarea name="comment" id="comment" rows="2" class="form-control" placeholder="Komentarz (opcjonalnie)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-some">Dodaj</button>
                        <a href="main.php" class="btn btn-danger">Anuluj</a>
                    </form>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="addIncomeConfirmation" tabindex="-1" role="dialog" aria-labelledby="addIncomeConfirmationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success" id="addIncomeConfirmationLabel">Sukces</h5>
                        <a href="main.php" class="close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Przychód został dodany</h3>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a href="main.php" class="btn btn-primary">OK <i class="far fa-smile"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="space">
    </div>
    <footer class="main-footer">
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

    <!-- Skrypt do wyświetlania modalu po dodaniu przychodu -->
    <?php
    if (isset($_SESSION['income_added'])) {
        echo '<script>$("#addIncomeConfirmation").modal("show");</script>';
        unset($_SESSION['adding_income']);
        unset($_SESSION['income_added']);
    } else {
        echo "";
    }
    ?>
</body>

</html>