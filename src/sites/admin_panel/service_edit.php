<?php
session_start();

include_once "../../Page_element.php";
include_once "../../Account.php";
include_once "../../Service.php";

if(!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}
if($_SESSION['role']!='admin') {
    header("Location: ../index.php");
}
if(empty($_GET['id'])){
    header("Location: services_list.php");
} else {
    setcookie("edit_id",$_GET['id'],time()+600);
}
$service  = Service::display1($_GET['id']);

if(!empty($_POST)){
   Service::update($_POST['price'],$_POST['duration'],$_COOKIE['edit_id']);
   header("Location: services_list.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytowanie usługi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
</head>
<body>
<?php Page_element::navbar()?>
<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-2 border bg-light">
            <?php Page_element::adminSidebar();?>
        </div>
        <div class="col-1"></div>
        <div class="col-6 justify-content-center">
            <h1 class="h3 text-center">Edycja usługi:</h1>
            <h2 class="h4 text-center"><?php echo $service['name']?></h2>
            <div class="col-sm-11 col-md-01 col-lg-9 col-xl-8 container-fluid border bg-light mt-5">
                <form name="service" method="post">
                    <table class="table mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col" class="text-nowrap text-center">Obecna wartość</th>
                            <th scope="col" class="text-center">Nowa wartość</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td  class="text-center"><label for="price">Cena</label></td>
                            <td  class="text-center"><?php echo $service['price']?></td>
                            <td><input type="number" step="0.01" name="price" id="price" placeholder="nowa nazwa"></td>
                        </tr>
                        <tr>
                            <td  class="text-center"><label for="duration">Czas</label></td>
                            <td  class="text-center"><?php echo $service['duration']?></td>
                            <td><input type="number" name="duration" id="duration" placeholder="nowa nazwa"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row mt-5">
                        <input type="submit" name="submit" value="ZATWIERDŹ"  class="btn btn-primary col-sm-8 container-fluid mb-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>