<?php

require_once "redirect.php";

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
                    <a class="nav-link" href="main.php">Menu główne</a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class="nav-link" href="add-income.php">Dodaj przychód</a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="add-expense.php">Dodaj wydatek</a>
                </li>
                <li class="nav-item active ml-lg-5 m-auto">
                    <a class=" nav-link" href="balance.php">Przeglądaj bilans <span class="sr-only">(aktualna
                            opcja)</span></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class="nav-link" href="#">Ustawienia</a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class=" nav-link" href="logout.php">Wyloguj się</a>
                </li>
                <li class="nav-item dropdown active ml-lg-5 m-auto">
                    <a class="nav-link dropdown-toggle dropdown-heading" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Wybierz okres
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="current-month" href="#">Bieżący miesiąc</a>
                        <a class="dropdown-item" id="previous-month" href="#">Poprzedni miesiąc</a>
                        <a class="dropdown-item" id="current-year" href="#">Bieżący rok</a>
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
                                    <td>5000</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Odsetki bankowe</td>
                                    <td>300</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Sprzedaż na allegro</td>
                                    <td>1000</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Inne</td>
                                    <td>550</td>
                                </tr>
                                <tr>
                                    <th scope="row">Razem</th>
                                    <td class="text-center">-</td>
                                    <th id="incomes">6850</th>
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
                                    <td>600</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Mieszkanie</td>
                                    <td>1000</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Transport</td>
                                    <td>300</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Telekomunikacja</td>
                                    <td>45</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Opieka zdrowotna</td>
                                    <td>80</td>
                                </tr>
                                <tr>
                                    <th scope="row">6</th>
                                    <td>Ubranie</td>
                                    <td>225</td>
                                </tr>
                                <tr>
                                    <th scope="row">7</th>
                                    <td>Higiena</td>
                                    <td>44</td>
                                </tr>
                                <tr>
                                    <th scope="row">8</th>
                                    <td>Dzieci</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th scope="row">9</th>
                                    <td>Rozrywka</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <th scope="row">10</th>
                                    <td>Wycieczka</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th scope="row">11</th>
                                    <td>Szkolenia</td>
                                    <td>38</td>
                                </tr>
                                <tr>
                                    <th scope="row">12</th>
                                    <td>Książki</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <th scope="row">13</th>
                                    <td>Oszczędności</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <th scope="row">14</th>
                                    <td>Na złotą jesień, czyli emeryturę</td>
                                    <td>500</td>
                                </tr>
                                <tr>
                                    <th scope="row">15</th>
                                    <td>Spłata długów</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th scope="row">16</th>
                                    <td>Darowizna</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <th scope="row">17</th>
                                    <td>Inne wydatki</td>
                                    <td>200</td>
                                </tr>
                                <tr>
                                    <th scope="row">Razem</th>
                                    <td class="text-center">-</td>
                                    <th id="expenses">3280</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                    <form action="">
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