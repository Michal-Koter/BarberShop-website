<?php

include_once "Account.php";

class Page_element
{
    public static function navbar() : void
    { ?>
        <nav class='navbar navbar-dark bg-primary navbar-expand-md p-3'>
            <a class="navbar-brand" href="http://localhost/src/sites/index.php">
                <img src="http://localhost/img/logo.png" alt="Barber Shop"
                     width="150" height="50" class="d-inline-block">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-center" href="http://localhost/src/sites/index.php">Strona główna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="http://localhost/src/sites/opinion.php">Opinie</a>
                    </li>
                <?php if(isset($_SESSION['user'])){
                    if($_SESSION['role'] == 'user') {?>
                        <li class="nav-item">
                            <a class="nav-link text-center" href='http://localhost/src/sites/booking.php'>Rezerwacje</a>
                        </li>
                    </ul>
                    <div class="m-auto"></div>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-center" href='http://localhost/src/sites/account.php'>Konto</a>
                        </li>
                    <?php } else if ($_SESSION['role'] == 'admin'){ ?>
                        <li class="nav-item">
                            <a class="nav-link text-center" href='http://localhost/src/sites/admin_panel/visits.php'>Rezerwacje</a>
                        </li>
                    </ul>
                    <div class="m-auto"></div>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-center" href='http://localhost/src/sites/admin_panel/admin_panel.php'>Konto</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link text-center" href="http://localhost/src/sites/logout.php">Wyloguj się</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link text-center" href='http://localhost/src/sites/booking.php'>Rezerwacje</a>
                    </li>
                </ul>
                <div class="m-auto"></div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-center" href='http://localhost/src/sites/login.php'>Zaloguj się</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center" href='http://localhost/src/sites/registration.php'>Zarejestruj się</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </nav>
<?php
        echo "";
    }

    public static function adminSidebar()
    { ?>
        <aside class="row mb-4">
            <div class="row mt-4">
                <h1 class="h5">Pasek nawigacji</h1>
            </div>
            <div class="col mt-4">
                <div class="col-6 mb-3">
                    <a href="http://localhost/src/sites/admin_panel/admin_panel.php" class="btn d-flex btn-outline-primary fw-bold btn-sm">Panel admina</a>
                </div>
                <div class="col-6">
                    <a href="http://localhost/src/sites/admin_panel/visits.php" class="btn d-flex btn-outline-primary fw-bold btn-sm">Terminarz</a>
                </div>

                <div class="row mt-3 border-bottom">
                    <div class="border-bottom">Statystyki</div>
                    <div class="col-7 mt-2 mb-2">
                        <a href="http://localhost/src/sites/admin_panel/statistic.php" class="btn d-flex btn-outline-primary fw-bold btn-sm">Klienci</a>
                    </div>
                </div>
                <div class="col-6 mt-4">
                    <a href="http://localhost/src/sites/admin_panel/services_list.php" class="btn d-flex btn-outline-primary fw-bold btn-sm">Usługi</a>
                </div>
            </div>
        </aside>
<?php
    }
}