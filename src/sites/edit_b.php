<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

include_once "../Booking.php";

$data = $_SESSION['data'];
unset($_SESSION['date']);

$term = date("Y-m-d",strtotime($data['year'] . "W" . $data['week'] . $data['day'])) . " " . $data['time'] . ":00";
Booking::updateTerm($_COOKIE['book_id'],$term);
setcookie("book_id","",-1);

if($_SESSION['role'] == 'user'){
    header("Location: account.php");
}
if($_SESSION['role'] == 'admin'){
    header("Location: admin_panel/visits.php");
}
