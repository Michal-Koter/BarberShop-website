<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

include_once "../Booking.php";
include_once "../Account.php";

if(!empty($_COOKIE['cancel_id'])){
    Booking::modifyConfirm(-1,$_COOKIE['cancel_id']);
    setcookie("cancel_id","",-1);
}
$role = Account::getRole($_SESSION['user']);
if ($role == 'user'){
    header("Location: account.php");
}
if ($role == 'admin') {
    header("Location: visits.php");
}