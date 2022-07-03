<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: index.php");
}
include_once "../Page_element.php";
include_once "../Account.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body>
    <?php Page_element::navbar();?>
<div class="container-xs justify-content-center mt-5 mb-5">
    <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3 container-fluid border bg-light">
        <h1 class="h4 text-center mt-4">Rejestracja</h1>
        <form method="post" action="registration.php">
            <div class="row mt-3">
                <label for="firstname">Imię*: </label>
                <input type="text" id="firstname" name="firstname" required placeholder="Imię" class="col-md-10 container-fluid mt-2">
            </div>
            <div class="row mt-3">
                <label for="lastname">Nazwisko*: </label>
                <input type="text" id="lastname" name="lastname" required placeholder="Nazwisko" class="col-md-10 container-fluid mt-2">
            </div>
            <div class="row mt-3">
                <label for="phone">Telefon: </label>
                <input type="text" id="phone" name="phone" placeholder="123456789" class="col-md-10 container-fluid mt-2">
            </div>
            <div class="row mt-3">
                <label for="email">E-mail*: </label>
                <input type="text" id="email" name="email" required placeholder="email@poczta.pl" class="col-md-10 container-fluid mt-2">
            </div>
            <div class="row mt-3">
                <label for="password">Hasło*: </label>
                <input type="password" id="password" name="password" required placeholder="*****" minlength="6" class="col-md-10 container-fluid mt-2">
            </div>
            <div class="row mt-3">
                <label for="repeat_password">Powtórz hasło*: </label>
                <input type="password" id="repeat_password" name="repeat_password" required placeholder="*****" minlength="6" class="col-md-10 container-fluid mt-2">
            </div>
            <p class="fw-light fst-italic mt-1">* pole wymagane</p>
            <div class="row mt-3 mb-4">
                <input type="submit" id="register" name="register" value="Zarejestruj się" class="btn btn-primary col-md-6 container-fluid">
            </div>
        </form>

    </div>

</div>
<?php
    if(!empty($_POST)) {
        if ($message = Account::validation($_POST)) {
            echo "<h4>$message</h4>";
            exit();
        }
        if ($message = Account::addToDB($_POST)) {
            echo "<h4>$message</h4>";
            exit();
        }

        echo "<script type = 'text/javascript' >
                alert('Rejestracja udana!')
                window . location . href = 'login.php'
            </script >";
    }
?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>