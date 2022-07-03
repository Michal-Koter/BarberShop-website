<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
}
if($_SESSION['role']!='admin'){
    header("Location: ../index.php");
}
include_once "../../Booking.php";

if(!empty($_POST) && !empty($_GET['id'])){
    if(isset($_POST['accept'])) {
        Booking::modifyConfirm(1,$_GET['id']);
    } else if (isset($_POST['cancel'])){
        Booking::modifyConfirm(-1,$_GET['id']);
    }
}
header("Location: admin_panel.php");
?>