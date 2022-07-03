<?php
session_start();
include_once "../../Account.php";
include_once "../../Page_element.php";
include_once "../../Booking.php";
include_once "../../Service.php";

if(!isset($_SESSION['user'])) {
    header("Location: ../index.php");
}
if(Account::getRole($_SESSION['user'])!='admin'){
    header("Location: ../index.php");
}
//$reservations = Booking::getBooking(date("Y-m-d H:i:s"),date("Y-m-d")." 23:59:59");
$reservations = Booking::getBooking("2022-06-25 00:00:00",date("Y-m-d")." 23:59:59");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
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

        <div class="col-6">
            <div class="row mx-3">
            <h1 class="h3">Dzisiajsze wizyty</h1>
                <div class="row mt-3">
                <?php
                    if (!empty($reservations[0])){
                    foreach ($reservations as $reservation){
                        preg_match("/[0-9]{2}:[0-9]{2}/",$reservation['term'],$time);
                        if($reservation['confirmed']==1){
                ?>
                    <div class="row border bg-light mx-2 mb-3">
                        <div class="col mt-1">
                            <div class="row-cols-2 text-start fs-5">
                                <?php echo Service::getName($reservation['service_id'])?>
                            </div>
                            <div class="row-cols-2 text-start fs-5">
                                <?php echo $time[0]?>
                            </div>
                        </div>
                        <div class="col mt-2">
                            <div class="col text-end fs-5">
                                <?php echo Account::getName($reservation['client_email'])[0]?>
                            </div>
                        </div>
                    </div>
                <?php }}
                    }else { ?>
                    <p class="fs-5 mt-3">Brak rezerwacji</p>
                   <?php }?>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <h2 class="h5">Nowe rezerwacje</h2>
            </div>
            <div>
                <?php
                $reservations = Booking::getBookingToConfirm();
                if(!empty($reservations[0])){
                    foreach($reservations as $reservation) {?>
                        <form method="post" action="book_action.php?id=<?php echo $reservation['id']?>" class="row bg-light border">
                            <div class="col mt-2">
                                <div class="row text-start mx-1">
                                    <?php echo $reservation['term']?>
                                </div>
                                <div class="row text-start mx-1">
                                    <?php echo $reservation['name']?>

                                </div>
                            </div>
                            <div class="col text-start mt-1">
                                <div class="col text-end">
                                    <?php echo $reservation['client_email']?>

                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="row mt-2 mb-3">
                                    <div class="col">
                                        <input type="submit" class="btn btn-success btn-sm" name="accept" value="POTWIERDŹ" />
                                    </div>
                                    <div class="col"></div>
                                    <div class="col">
                                        <input type="submit" class="btn btn-danger btn-sm" name="cancel" value="ODRZUĆ" />
                                    </div>
                                </div>
                            </div>
                        </form>
                <?php }
                } else {
                    echo "Brak nowych rezerwacji.";
                } ?>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
