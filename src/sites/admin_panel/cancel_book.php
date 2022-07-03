<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
}
if($_SESSION['role']!='admin'){
    header("Location: ../index.php");
}
include_once "../../Booking.php";
if(!empty($_COOKIE['cancel_id'])){
    Booking::modifyConfirm(-1,$_COOKIE['cancel_id']);
    setcookie("cancel_id","",-1);
}
header("Location: visits.php");