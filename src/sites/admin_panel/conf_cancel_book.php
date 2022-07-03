<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
}
if($_SESSION['role']!='admin'){
    header("Location: ../index.php");
}
include_once "../../Booking.php";

if(!empty($_GET['id'])) {
    $id = $_GET['id'];
    setcookie("cancel_id",$_GET['id'],time()+600);
} else {
    header("Location: visits.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdź</title>
    <script>
        function confirmAction() {
            let confirmAction = confirm("Na pewno chcesz usunąć rezerwację nr: " + <?php echo $id ?>)
            if (confirmAction) {
                window . location . href = 'cancel_book.php'
            } else {
                window . location . href = 'visits.php?'
            }
        }
    </script>
</head>
<body>
    <script>
        confirmAction();
    </script>
</body>
</html>