<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
include_once "../Page_element.php";
include_once "../Reservation.php";
include_once "../Service.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rezerwacja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>
<body>
    <?php
    Page_element::navbar();
    $services = Service::display2();
    ?>
    <div class="container mt-5 mb-5">
        <h1 class="h3 text-center">Wybierz usługę</h1>
        <div class="table">
            <?php while ($result = $services->fetch()){ ?>
                <div class="row-cols-xs-1">
                    <div class="col">
                        <div class="row">
                            <div class="col-5">
                                <b><?php echo $result['name']?></b>
                            </div>
                            <div class="col">
                                <div class="col text-end">
                                    <div><?php echo $result['price'] . "zł"?></div>
                                    <div><?php echo $result['duration'] . " minut"?></div>
                                </div>
                            </div>
                            <div class="col-1">
                                <a class="btn btn-primary" href="calendar.php?<?php echo 'id='.$result['id']?>" role="button">Umów</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
