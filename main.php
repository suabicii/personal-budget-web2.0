<?php

require_once "redirect.php";
require_once "database.php";

$query = $db->prepare('SELECT name FROM users WHERE id = :id');
$query->bindValue(':id', $_SESSION['logged_id'], PDO::PARAM_STR);
$query->execute();

$user = $query->fetch();

$_SESSION['logged_name'] = $user['name'];

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
            <h2>Menu główne</h2>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="main.php"><i class="fas fa-piggy-bank"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Rozwiń menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav m-auto">
                <li class="nav-item active m-auto">
                    <a class="nav-link" href="main.php">Menu główne <i class="fas fa-home"></i> <span class="sr-only">(aktualna
                            opcja)</span></a>
                </li>
                <li class="nav-item ml-lg-5 m-auto">
                    <a class="nav-link" href="add-income.php">Dodaj przychód <i class="fas fa-hand-holding-usd"></i></a>
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
        <section class="welcome">
            <div class="container-custom border rounded bg-white text-center mt-2 py-2">
                <h3>Witaj, <?= $_SESSION['logged_name'] ?>! <i class="far fa-smile"></i></h3>
                <p class="text-muted lead">Co zamierzasz teraz zrobić? <i class="far fa-lightbulb"></i></p>
                <img class="img-fluid" src="./img/question.jpg" alt="znak zapytania">
            </div>
        </section>
    </main>

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
</body>

</html>