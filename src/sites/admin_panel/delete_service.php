<?php
session_start();

include_once "../../Page_element.php";
include_once "../../Account.php";
include_once "../../Service.php";

if(!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
if(Account::getRole($_SESSION['user'])!='admin') {
    header("Location: ../index.php");
}
if(empty($_GET['id'])){
    header("Location: services_list.php");
} else {
    setcookie("delete_id",$_GET['id'],time()+600);
}

$service = Service::display1($_GET['id']);

?>
<script>
    function confirmAction() {
        let confirmAction = confirm("Na pewno chcesz usłunąć: <?php echo $service['name']?>");
        if (confirmAction) {
            alert('Usługa została usunięta!');
            window . location . href = 'delete.php';
        } else {
            window . location . href = 'services_list.php';
        }

    }
</script>

<script type='text/javascript'>
    confirmAction();
</script>
