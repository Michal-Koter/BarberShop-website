<?php
session_start();
include_once "../Reservation.php";
include_once "../Booking.php";
include_once "../Page_element.php";
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
if (isset($_GET['id'])){
    setcookie("book_id",$_GET['id'],time()+3600);
    $book_id = $_GET['id'];
} else if(isset($_COOKIE['book_id'])){
    $book_id = $_COOKIE['book_id'];
} else{
    header("Location: account.php");
}
$reservation = Booking::get($book_id);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Terminarz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>
<body>
<?php
Page_element::navbar();
$year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
$week = (isset($_GET['week'])) ? $_GET['week'] : date('W');
$day = (isset($_GET['day'])) ? $_GET['day'] : date("N");
if($day > 6) {
    $week++;
    $day = 1;
} elseif($day<1){
    $week--;
    $day = 6;
}
if($week > 52) {
    $year++;
    $week = 1;
} elseif($week < 1) {
    $year--;
    $week = 52;
}
?>
<div class="container mt-5">
    <div class="row">
        <div class="col d-flex justify-content-around">
            <a class="btn btn-primary btn-s"
               href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week == 1 ? 52 : $week -1).'&year='.($week == 1 ? $year - 1 : $year).'&day='.$day; ?>">Poprzedni tydzień</a>
        </div>
        <div class="col d-flex justify-content-around">
            <a class="btn btn-primary btn-s"
               href="<?php echo $_SERVER['PHP_SELF'].'?week='.(date("W",time())).'&year='.(date("Y",time())).'&day='.date("N"); ?>">Dziś</a>
        </div>
        <div class="col d-flex justify-content-around">
            <a class="btn btn-primary btn-s"
               href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week == 52 ? 1 : 1 + $week).'&year='.($week == 52 ? 1 + $year : $year).'&day='.$day; ?>">Następny tydzień</a>
        </div>
    </div>
    <br>
    <div class="row-cols-lg-6 d-flex justify-content-around">
        <a class="btn btn-primary btn-s"
           href="<?php echo $_SERVER['PHP_SELF'].'?week=' . $week .'&year='. $year . '&day=' . 1; ?>">
            <?php showDay($year,$week,1); ?>
        </a>
        <a class="btn btn-primary btn-s"
           href="<?php echo $_SERVER['PHP_SELF'].'?week=' . $week .'&year='. $year . '&day=' . 2; ?>">
            <?php showDay($year,$week,2); ?>
        </a>
        <a class="btn btn-primary btn-s"
           href="<?php echo $_SERVER['PHP_SELF'].'?week=' . $week .'&year='. $year . '&day=' . 3; ?>">
            <?php showDay($year,$week,3); ?>
        </a>
        <a class="btn btn-primary btn-s"
           href="<?php echo $_SERVER['PHP_SELF'].'?week=' . $week .'&year='. $year . '&day=' . 4; ?>">
            <?php showDay($year,$week,4); ?>
        </a>
        <a class="btn btn-primary btn-s"
           href="<?php echo $_SERVER['PHP_SELF'].'?week=' . $week .'&year='. $year . '&day=' . 5; ?>">
            <?php showDay($year,$week,5); ?>
        </a>
        <a class="btn btn-primary btn-s"
           href="<?php echo $_SERVER['PHP_SELF'].'?week=' . $week .'&year='. $year . '&day=' . 6; ?>">
            <?php showDay($year,$week,6); ?>
        </a>
    </div>
</div>
<div class="container mb-5">
    <form method="post" action="confirm_edit.php?<?php echo 'year='.$year.'&week='.$week.'&day='.$day ?>">

        <div class="row-cols-lg-auto d-flex justify-content-around">
            <?php
            $d = strtotime($year . "W" . $week . $day);
            echo "<div class='col-lg-7'>";
            echo "<div class='row d-flex justify-content-around'>" . date('l', $d) . "<br>" . date('d M', $d) . "</div>";
            $now = date_create();
            $timezone= new DateTimeZone('Europe/Berlin');
            $date = new DateTime("@$d");
            $date->setTimezone($timezone);
            $date->add(DateInterval::createFromDateString('10 hour'));

            $open_hours = Reservation::openHours();
            foreach($open_hours as $open){
                foreach ($open as $hour) {
                    $hour->setDate($year, date('n', $d), date('j', $d));
                }
            }
            switch($day) {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                    hours($open_hours[0][0], $open_hours[0][1], $now, $date, $reservation['service_id'], $reservation['id']);
                    break;
                case 6:
                    hours($open_hours[1][0], $open_hours[1][1], $now, $date, $reservation['service_id'], $reservation['id']);
                    break;
            }
            ?>
        </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col d-flex justify-content-around">
            <input type="submit" class="btn btn-primary">
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<?php

function hours(Datetime $open, DateTime $close, DateTime $now, DateTime $date,$service_id,$reservation_id=0){
    $time_needed = Booking::duration($service_id);
    $time_needed = DateInterval::createFromDateString("$time_needed minutes");
    $result = Booking::getBooking($open->format("Y-m-d H:i:s"),$close->format("Y-m-d H:i:s"),$reservation_id);
    $clone = clone $close;
    $close->modify('-10 minutes');
    $count_visits = 0;
    if ($now < $close) {
        if (!empty(end($result))){
            $last_book = new DateTime(end($result)['term']);
        } else {
            $last_book = new DateTime("0001-01-01");
        }
        echo "<div class='container d-flex justify-content-around'>";

        $row = 0;
        echo "<div class='btn-group btn-group-toggle' data-toggle='buttons'>";
        echo "<div>";
        while ($date <= $now) {
            if($row%6==0) {
                echo "</div>";
                echo "<div class='row-cols-auto'>";

            }
            echo "<label class='btn btn-light btn-sm m-1'>" .
                "<input type='radio' disabled>" . $date->format("H:i") .
                "</label>";
            $date->modify('10 minutes');
            $row++;
        }
        while ($date <= $close) {
            if($row%6==0) {
                echo "</div>";
                echo "<div class='row-cols-auto'>";

            }
            $str = $date->format("H:i");
            if ($last_book >= $date) {
                $free_time = $date->diff(new DateTime($result[$count_visits]["term"]));
                if (((int)$free_time->format("%h")*60 + (int)$free_time->format("%i")) >= $time_needed->format("%i")) {
                    echo "<label class='btn btn-primary btn-sm m-1'>" .
                        "<input type='radio' name='time' value='$str' autocomplete='off'>$str" .
                        "</label>";
                    $date->modify('10 minutes');
                    $row++;
                } else {
                    if ($date->format("Y-m-d H:i:s") == $result[$count_visits]['term']) {
                        $service_time = Booking::duration($result[$count_visits]["service_id"]);
                        while ($service_time > 0) {
                            echo "<label class='btn btn-light btn-sm m-1'>" .
                                "<input type='radio' disabled>" . $date->format("H:i") .
                                "</label>";
                            $service_time -= 10;
                            $date->modify("10 minutes");
                            $row++;
                            if ($row % 6 == 0) {
                                echo "</div>";
                                echo "<div class='row-cols-auto'>";
                            }
                        }
                        $count_visits++;
                    } else {
                        echo "<label class='btn btn-light btn-sm m-1'>" .
                            "<input type='radio' disabled>" . $str .
                            "</label>";
                        $date->modify("10 minutes");
                        $row++;
                    }
                }
            } else {
                $free_time = $date->diff($clone);
                if(((int)$free_time->format("%h")*60 + (int)$free_time->format("%i")) < $time_needed->format("%i")){
                    echo "<label class='btn btn-light btn-sm m-1'>" .
                        "<input type='radio' disabled>" . $date->format("H:i") .
                        "</label>";
                } else {
                    echo "<label class='btn btn-primary btn-sm m-1'>" .
                        "<input type='radio' name='time' value='$str' autocomplete='off'>$str" .
                        "</label>";
                }
                $date->modify('10 minutes');
                $row++;
            }
        }
        echo "</div></div>";
        echo "</div>";
    }
}

function showDay(int $year, int $week,int $num){
    $d = strtotime($year . "W" . $week . $num);
    echo date('l', $d) . "<br>" . date('d M', $d);
}
?>
