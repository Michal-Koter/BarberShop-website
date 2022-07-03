<?php
session_start();
if (!isset($_SESSION['user'])){header("Location: login.php");}

if(empty($_GET['id'])){
    header("Location: account.php");
} else {
    $id = $_GET['id'];
    setcookie("cancel_id",$_GET['id'],time()+600);
}
include_once "../Page_element.php";
include_once "../Booking.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Anulowanie rezerwacji</title>
    <script>
        function confirmUserAction() {
            let confirmAction = confirm("Na pewno chcesz anulować rezerwację?");
            if (confirmAction) {
                window . location . href = 'cancel_book.php';
            } else {
                window . location . href = 'account.php';
            }
        }

        function confirmAdminAction() {
            let confirmAction = confirm("Na pewno chcesz anulować rezerwację?");
            if (confirmAction) {
                window . location . href = 'cancel_book.php';
            } else {
                window . location . href = 'admin_panel/admin_panel.php';
            }
        }
    </script>
</head>
<body>
    <?php
        if ($_SESSION['role'] == 'user'){
    ?>
        <script>
            confirmUserAction()
        </script>
    <?php
        }
        if($_SESSION['role'] == 'admin') {
    ?>
        <script>
            confirmUserAction()
        </script>
    <?php } ?>
</body>
</html>
