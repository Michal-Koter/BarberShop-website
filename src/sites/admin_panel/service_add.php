<?php
session_start();

include_once "../../Page_element.php";
include_once "../../Account.php";
include_once "../../Service.php";

if(!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
if(Account::getRole($_SESSION['user'])!='admin') {
    header("Location: ../index.php");
}

if(!empty($_POST)){
    Service::addToDB($_POST['name'],$_POST['price'],$_POST['duration']);
    header("Location: services_list.php");
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Nowa usługa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>
<body>
<?php Page_element::navbar()?>
<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-2 border bg-light">
            <?php Page_element::adminSidebar();?>
        </div>
        <div class="col-1"></div>
        <div class="col-6 justify-content-center">
            <h1 class="h4 text-center">Nowa usługa</h1>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-5 container-fluid border bg-light mt-4">
                <div>
                    <form method="post">
                        <div class="row mt-3">
                            <label for="name">Nazwa: </label>
                            <input type="text" name="name" id="name" placeholder="nazwa" required class="col-md-10 container-fluid mt-2">
                        </div>
                        <div class="row mt-3">
                            <label for="price">Cena: </label>
                            <input type="number" step="0.01" name="price" id="price" required class="col-md-10 container-fluid mt-2">
                        </div>
                        <div class="row mt-3">
                            <label for="duration">Czas: </label>
                            <input type="number" name="duration" id="duration" required class="col-md-10 container-fluid mt-2">
                        </div>
                        <div class="row mt-5">
                            <input type="submit" name="submit" value="DODAJ USŁUGĘ" class="btn btn-primary col-sm-8 container-fluid mb-4">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>