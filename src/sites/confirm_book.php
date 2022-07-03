<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
$data = array("year"=>$_GET['year'],"week"=>$_GET['week'],"day"=>$_GET["day"],"time"=>$_POST["time"]);

include_once "../Booking.php";
include_once "../Service.php";
?>

<script>
    function confirmAction() {
        let confirmAction = confirm("Potwierdź rezerwację: \n" +
            "<?php echo 'Usługa: ' . Service::getName(unserialize($_COOKIE['service_id']));?> \n" +
            "<?php echo 'Data: ' . date('d-m-Y',strtotime($data['year'] . 'W' . $data['week'] . $data['day'])) . ' ' . $data['time']?>")
        if (confirmAction) {
            <?php confirm($data);?>
            alert('Rezerwacja doknana!')
            window . location . href = 'index.php'
        } else {
            window . location . href = 'calendar.php'
        }
    }
</script>

<script type="text/javascript">
    confirmAction();
</script>

<?php

function confirm($data){
    $term = date("Y-m-d",strtotime($data['year'] . "W" . $data['week'] . $data['day'])) . " " . $data['time'] . ":00";
    Booking::addToDB($term,$_SESSION['user'],unserialize($_COOKIE["service_id"]));
    setcookie("service_id","",-1);

}
?>