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
$services = Service::display2()->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Usługi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body>
    <?php Page_element::navbar()?>
    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-2 border bg-light">
                <?php Page_element::adminSidebar();?>
            </div>
            <div class="col-1"></div>
            <div class="col-6">
                <div class="row text-center mb-2">
                    <h1 class="h3">Usługi</h1>
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>Nazwa</th>
                                <th>Cena</th>
                                <th>Czas</th>
                                <th>Edytuj</th>
                                <th>Usuń</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service){ $name = json_encode($service['name']);?>
                                <tr>
                                    <td><?php echo $service['name']?></td>
                                    <td class="text-center"><?php echo $service['price']?></td>
                                    <td class="text-center"><?php echo $service['duration']?></td>
                                    <td class="text-center">
                                        <a href="service_edit.php?id=<?php echo $service['id']?>" class="btn bg-light">
                                            <i class="bi bi-gear-fill"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="delete_service.php?id=<?php echo $service['id']?>" class="btn  bg-light">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                                <tr>
                                    <td>
                                        <a href="service_add.php" class="btn btn-outline-primary fw-bold">
                                            <i class="bi bi-plus"></i>
                                            DODAJ USŁUGĘ
                                        </a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
