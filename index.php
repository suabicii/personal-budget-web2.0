<?php
session_start();

if (isset($_SESSION['logged_id'])) {
    header('Location: main.php');
    exit();
}

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
            <blockquote class="blockquote">
                <p class="lead mb-0">Pieniądze rosną na drzewie wytrwałości</p>
                <footer class="blockquote-footer text-white">Jakiś Japończyk, nieważne jak się nazywał <i class="far fa-smile"></i></footer>
            </blockquote>
        </div>
    </header>

    <main>
        <section class="about mt-3">
            <div class="container container-sm border rounded bg-white text-center pt-2">
                <h2>Chcesz zapanować nad własnymi finansami? <i class="fas fa-comment-dollar"></i></h2>
                <p class="text-muted">Ta aplikacja idealnie Ci w tym pomoże! <i class="far fa-thumbs-up"></i></p>
                <h3>Jak zacząć?</h3>
                <ul>
                    <li>1. Załóż konto/zaloguj się</li>
                    <li>2. Dodawaj swoje <strong>przychody i wydatki</strong> do aplikacji</li>
                    <li>3. Przejdź do <strong>bilansu</strong> i obserwuj swoje finanse - sprawdź czy nie jesteś "pod
                        kreską" <i class="far fa-smile"></i></li>
                </ul>
            </div>
        </section>
        <section class="main-menu mt-3">
            <div class="container py-3">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-lg btn-block btn-primary mb-3 mb-md-0" data-toggle="modal" data-target="#registerModal">Zarejestruj się <i class="fas fa-user-plus"></i></button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-lg btn-block btn-success mb-5 mb-md-0" data-toggle="modal" data-target="#loginModal">Zaloguj się <i class="fas fa-key"></i></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal do rejestracji -->
        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Rejestracja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="register.php" id="register" method="post">
                        <div class="modal-body">
                            <div class="input-group mr-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <label class="sr-only" for="name">Imię</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Imię" required>
                            </div>
                            <div class="input-group mr-2 mt-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <label class="sr-only" for="surname">Nazwisko</label>
                                <input type="text" name="surname" id="surname" class="form-control" placeholder="Nazwisko" required>
                            </div>
                            <div class="input-group mr-2 mt-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-at"></i></div>
                                </div>
                                <label class="sr-only" for="email">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
                            </div>
                            <?php

                            if (isset($_SESSION['email_err'])) {
                                echo $_SESSION['email_err'];
                                unset($_SESSION['email_err']);
                            }

                            ?>
                            <div class="input-group mr-2 mt-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text pr-2"><i class="fas fa-user-shield"></i></div>
                                </div>
                                <label class="sr-only" for="username">Login</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Login" required>
                            </div>
                            <?php

                            if (isset($_SESSION['login_err'])) {
                                echo $_SESSION['login_err'];
                                unset($_SESSION['login_err']);
                            }

                            ?>
                            <div class="input-group mr-2 mt-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <label class="sr-only" for="password">Hasło</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Hasło" required>
                            </div>
                            <div class="input-group mr-2 mt-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <label class="sr-only" for="passwordConfirmation">Potwierdź hasło</label>
                                <input type="password" name="passwordConfirmation" id="passwordConfirmation" class="form-control" placeholder="Powtórz hasło" required>
                            </div>
                            <?php

                            if (isset($_SESSION['pswd_err'])) {
                                echo $_SESSION['pswd_err'];
                                unset($_SESSION['pswd_err']);
                            }

                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                            <button type="submit" class="btn btn-primary">Załóż konto <i class="fas fa-user-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal do logowania -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Logowanie</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="login" method="post" action="login.php">
                        <div class="modal-body">
                            <div class="input-group mr-2 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text pr-2"><i class="fas fa-user-shield"></i></div>
                                </div>
                                <label class="sr-only" for="userLogin">Login</label>
                                <input type="text" name="userLogin" id="userLogin" class="form-control" placeholder="Login" required>
                            </div>
                            <div class="input-group mr-2 mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <label class="sr-only" for="authorization">Hasło</label>
                                <input type="password" name="authorization" id="authorization" class="form-control" placeholder="Hasło" required>
                            </div>
                            <div>
                                <?php
                                if (isset($_SESSION['bad_attempt'])) {
                                    echo '<p class="text-danger">Niepoprawny login lub hasło</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                            <button type="submit" class="btn btn-success">Zaloguj się <i class="fas fa-key"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal po rejestracji -->
        <div class="modal fade" id="registerConfirmation" tabindex="-1" role="dialog" aria-labelledby="registerConfirmationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success" id="registerConfirmationLabel">Sukces</h5>
                        <a href="main.html" class="close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Rejestracja zakończona sukcesem</h3>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK <i class="far fa-smile"></i></button>
                    </div>
                </div>
            </div>
        </div>
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
    <!-- Jeśli logowanie się nie powiedzie, nie zamykaj od razu formularza logowania -->
    <script src=<?php
                if (isset($_SESSION['bad_attempt'])) {
                    echo "login-error.js";
                    unset($_SESSION['bad_attempt']);
                } else echo "";
                ?>>
    </script>
    <!-- Jeśli rejestracja się nie powiedzie, nie zamykaj od razu formularza rejestracji -->
    <script src=<?php
                if (isset($_SESSION['success']) && !$_SESSION['success']) {
                    echo "register-error.js";
                    unset($_SESSION['success']);
                } else echo "";
                ?>>
    </script>

    <?php
    // Wyświetl modal potwierdzający udaną rejestrację
    if (isset($_SESSION['register_completed'])) {
        echo <<<END
        <script>
            $("#registerConfirmation").modal("show");
        </script>

END;
        unset($_SESSION['register_completed']);
    }

    ?>
</body>

</html>