<?php
session_start();
include_once "../../Account.php";
include_once "../../Page_element.php";
include_once "../../Booking.php";
include_once "../../Service.php";

if(!isset($_SESSION['user'])) {
    header("Location: ../index.php");
}
if(Account::getRole($_SESSION['user'])!='admin') {
    header("Location: ../index.php");
}

$dt = new DateTime;
if (isset($_GET['year']) && isset($_GET['week'])) {
    $dt->setISODate($_GET['year'], $_GET['week']);
} else {
    $dt->setISODate($dt->format('o'), $dt->format('W'));
}
$year = $dt->format('o');
$week = $dt->format('W');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kalendarz wizyt</title>
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
    <?php
    $year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
    $week = (isset($_GET['week'])) ? $_GET['week'] : date('W');
    if($week > 52) {
    $year++;
    $week = 1;
    } elseif($week < 1) {
    $year--;
    $week = 52;
    }
    ?>
        <div class="col-lg-9 border">
            <div class="row mt-3">
                <div class="col-1"></div>
                <div class="col-3 d-flex justify-content-around">
                    <a class="btn btn-primary btn-s"
                       href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week == 1 ? 52 : $week -1).'&year='.($week == 1 ? $year - 1 : $year); ?>">Poprzedni tydzień</a>
                </div>
                <div class="col-3 d-flex justify-content-around">
                    <a class="btn btn-primary btn-s"
                       href="<?php echo $_SERVER['PHP_SELF'].'?week='.(date("W",time())).'&year='.(date("Y",time())).'&day='; ?>">Obecny tydzień</a>
                </div>
                <div class="col-3 d-flex justify-content-around">
                    <a class="btn btn-primary btn-s"
                       href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week == 52 ? 1 : 1 + $week).'&year='.($week == 52 ? 1 + $year : $year); ?>">Następny tydzień</a>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-around">
                    <?php
                    do {
                        if($dt->format("N") != 7) {
                    ?>
                            <div class="col border mt-3">
                                <div class="row d-flex justify-content-center bg-primary text-light fw-bold">
                                    <?php echo $dt->format('l')?>
                                </div>
                                <div class="row d-flex justify-content-center border-bottom bg-primary text-light fw-bold">
                                    <?php echo $dt->format('d M')?>
                                </div>
                                <?php
                                $open = $dt->format("Y-m-d" . " 00:00:00");
                                $close = $dt->format("Y-m-d") . " 23:59:59";
                                $visits = Booking::getVisits($open, $close);
                                if (!empty($visits[0])) {
                                    foreach ($visits as $visit) {
                                        preg_match("/[0-9]{2}:[0-9]{2}/", $visit['term'], $time);
                                        $dis = $time[0];
                                        $id = $visit['id'];
                                ?>
                                        <div class="row border-top bg-light mx-1 mt-3">
                                            <div class="col-10">
                                                <div class="row text-start">
                                                    <div class="col-6 ">
                                                        <?php echo $dis ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col fw-bold text-start">
                                                        <?php echo $visit['service']?>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-4 text-start">
                                                        <a href='conf_cancel_book.php?id=<?php echo $id?>' role="button" class='btn btn-outline-danger btn-sm'>ANULUJ</a>
                                                    </div>
                                                    <div class="col-2"></div>
                                                    <div class="col-4 text-end">
                                                        <a href='../edit_book.php?id=<?php echo $id?>' role="button" class='btn btn-outline-warning btn-sm'>EDYTUJ</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        <?php
                                        }
                                    }
                                }
                                $dt->modify('+1 day');
                                echo "</div>";
                            } while ($week == $dt->format('W'));
                        ?>
                </div>
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


