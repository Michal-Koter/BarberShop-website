<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
$data = array("year"=>$_GET['year'],"week"=>$_GET['week'],"day"=>$_GET["day"],"time"=>$_POST["time"]);
$_SESSION["data"] = $data;
include_once "../Booking.php";
include_once "../Service.php";
?>

    <script>
        function confirmUserAction() {
            let confirmAction1 = confirm("Potwierdź zmiany: \n" +
                "<?php echo 'Usługa: ' . Service::getName(Booking::get($_COOKIE['book_id'])['service_id']);?> \n" +
                "<?php echo 'Data: ' . date('d-m-Y',strtotime($data['year'] . 'W' . $data['week'] . $data['day'])) . ' ' . $data['time']?>")
            if (confirmAction1) {
                alert('Rezerwacja zmieniona!')
                window . location . href = 'edit_b.php'
            } else {
                window . location . href = 'account.php'
            }
        }

        function confirmAdminAction() {
            let confirmAction2 = confirm("Potwierdź zmiany: \n" +
                "<?php echo 'Usługa: ' . Service::getName(Booking::get($_COOKIE['book_id'])['service_id']);?> \n" +
                "<?php echo 'Data: ' . date('d-m-Y',strtotime($data['year'] . 'W' . $data['week'] . $data['day'])) . ' ' . $data['time']?>")
            if (confirmAction2) {
                alert('Rezerwacja zmieniona!')
                window . location . href = 'edit_b.php'
            } else {
                window . location . href = 'admin_panel/visits.php'
            }
        }
    </script>



<?php
    if($_SESSION['role'] == 'user'){
?>
        <script type="text/javascript">
            confirmUserAction();
        </script>
<?php
    }
    if($_SESSION['role'] == 'admin'){
?>
        <script type="text/javascript">
            confirmAdminAction();
        </script>
<?php
    }
?>